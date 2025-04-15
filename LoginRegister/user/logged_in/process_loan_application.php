<?php
// Include necessary files
include('../authentication.php');
include('../../../db_file/db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['auth_user'])) {
    $_SESSION['message'] = "User not authenticated.";
    $_SESSION['message_type'] = "danger";
    header('Location: index.php');
    exit();
}

// Get user ID from session
$user_id = $_SESSION['auth_user']['user_id'];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Validate and sanitize input data
    $full_name = isset($_POST['full_name']) ? mysqli_real_escape_string($con, $_POST['full_name']) : $_SESSION['auth_user']['username'];
    $contact_number = isset($_POST['contact_number']) ? mysqli_real_escape_string($con, $_POST['contact_number']) : $_SESSION['auth_user']['phone'];
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $postal_code = mysqli_real_escape_string($con, $_POST['postal_code']);
    $valid_id_type = mysqli_real_escape_string($con, $_POST['valid_id_type']);
    $id_number = mysqli_real_escape_string($con, $_POST['id_number']);
    $loan_amount = (float) $_POST['loan_amount'];
    $loan_purpose = mysqli_real_escape_string($con, $_POST['loan_purpose']);
    
    // Log data for debugging
    error_log("Processing form data: " . json_encode($_POST));
    
    // Validate required fields
    if (empty($dob) || empty($gender) || empty($address) || empty($postal_code) || 
        empty($valid_id_type) || empty($id_number) || empty($loan_amount) || empty($loan_purpose)) {
        $_SESSION['message'] = "All fields are required.";
        $_SESSION['message_type'] = "danger";
        header('Location: index.php');
        exit();
    }
    
    // Validate age - must be at least 21
    $birthdate = new DateTime($dob);
    $today = new DateTime();
    $age = $birthdate->diff($today)->y;
    
    if ($age < 21) {
        $_SESSION['message'] = "You must be at least 21 years old to apply.";
        $_SESSION['message_type'] = "danger";
        header('Location: index.php');
        exit();
    }
    
    // Validate loan amount
    if ($loan_amount < 5000 || $loan_amount > 100000) {
        $_SESSION['message'] = "Loan amount must be between ₱5,000 and ₱100,000.";
        $_SESSION['message_type'] = "danger";
        header('Location: index.php');
        exit();
    }
    
    // Validate postal code format
    if (!preg_match('/^\d{4}$/', $postal_code)) {
        $_SESSION['message'] = "Please enter a valid 4-digit postal code.";
        $_SESSION['message_type'] = "danger";
        header('Location: index.php');
        exit();
    }
    
    // Process ID photo upload
    $id_photo_path = '';
    if (isset($_FILES['id_photo']) && $_FILES['id_photo']['error'] == 0) {
        $upload_dir = '../../../uploads/id_documents/';
        
        // Check if directory exists, if not create it
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0755, true)) {
                error_log("Failed to create directory: $upload_dir");
                $_SESSION['message'] = "Failed to create upload directory.";
                $_SESSION['message_type'] = "danger";
                header('Location: index.php');
                exit();
            }
        }
        
        // Check if directory is writable
        if (!is_writable($upload_dir)) {
            error_log("Directory not writable: $upload_dir");
            $_SESSION['message'] = "Upload directory is not writable.";
            $_SESSION['message_type'] = "danger";
            header('Location: index.php');
            exit();
        }
        
        // Get file extension
        $file_extension = pathinfo($_FILES['id_photo']['name'], PATHINFO_EXTENSION);
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'pdf');
        
        // Check file extension
        if (!in_array(strtolower($file_extension), $allowed_extensions)) {
            $_SESSION['message'] = "Only JPG, JPEG, PNG, and PDF files are allowed.";
            $_SESSION['message_type'] = "danger";
            header('Location: index.php');
            exit();
        }
        
        // Generate unique filename
        $new_filename = 'id_' . $user_id . '_' . time() . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;
        
        // Log upload details
        error_log("Uploading file to: $upload_path");
        
        // Move uploaded file
        if (!move_uploaded_file($_FILES['id_photo']['tmp_name'], $upload_path)) {
            error_log("Failed to move uploaded file from " . $_FILES['id_photo']['tmp_name'] . " to $upload_path");
            $_SESSION['message'] = "Failed to upload ID document. Please try again.";
            $_SESSION['message_type'] = "danger";
            header('Location: index.php');
            exit();
        }
        
        // Store relative path in database
        $id_photo_path = 'uploads/id_documents/' . $new_filename;
    } else {
        // Log error details
        error_log("File upload error: " . (isset($_FILES['id_photo']) ? $_FILES['id_photo']['error'] : 'No file uploaded'));
        $_SESSION['message'] = "ID document is required.";
        $_SESSION['message_type'] = "danger";
        header('Location: index.php');
        exit();
    }
    
    // Generate unique reference number
    $reference_number = 'LOAN-' . date('YmdHis') . '-' . rand(1000, 9999);
    
    // Set application status
    $status = 'Pending';
    
    // Get current date and time
    $application_date = date('Y-m-d H:i:s');
    
    try {
        // Check if table exists
        $table_check = $con->query("SHOW TABLES LIKE 'loan_applications'");
        if ($table_check->num_rows == 0) {
            // Create table if it doesn't exist
            $create_table_sql = "CREATE TABLE IF NOT EXISTS `loan_applications` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11),
                `reference_number` varchar(50) NOT NULL,
                `full_name` varchar(255) NOT NULL,
                `contact_number` varchar(50) NOT NULL,
                `dob` date NOT NULL,
                `gender` varchar(10) NOT NULL,
                `address` text NOT NULL,
                `postal_code` varchar(10) NOT NULL,
                `valid_id_type` varchar(50) NOT NULL,
                `id_number` varchar(50) NOT NULL,
                `id_photo_path` varchar(255) NOT NULL,
                `loan_amount` decimal(10,2) NOT NULL,
                `loan_purpose` varchar(100) NOT NULL,
                `status` varchar(20) NOT NULL DEFAULT 'Pending',
                `application_date` datetime NOT NULL,
                `processed_date` datetime DEFAULT NULL,
                `remarks` text DEFAULT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `reference_number` (`reference_number`),
                KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            
            if (!$conn->query($create_table_sql)) {
                throw new Exception("Failed to create table: " . $conn->error);
            }
        }
        
        // Insert into database
        $sql = "INSERT INTO loan_applications (
                    user_id, reference_number, full_name, contact_number, dob, gender, 
                    address, postal_code, valid_id_type, id_number, id_photo_path, 
                    loan_amount, loan_purpose, status, application_date
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                )";
        
        // Prepare statement
        $stmt = $con->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        // Bind parameters
        $stmt->bind_param(
            "issssssssssdsss",
            $user_id, $reference_number, $full_name, $contact_number, $dob, $gender,
            $address, $postal_code, $valid_id_type, $id_number, $id_photo_path,
            $loan_amount, $loan_purpose, $status, $application_date
        );
        
        // Execute statement
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        // Store reference number in session for use on success page
        $_SESSION['loan_reference_number'] = $reference_number;

        
        // Close statement
        $stmt->close();
        
        // Redirect to success page
        header('Location: application_success.php');
        exit();
        
    } catch (Exception $e) {
        error_log("Database error: " . $e->getMessage());
        $_SESSION['message'] = "Database error: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
        header('Location: dashboard.php');
        exit();
    }
}
else {
    // If accessed directly without POST data
    $_SESSION['message'] = "Invalid request. Please submit the form properly.";
    $_SESSION['message_type'] = "warning";
    header('Location: index.php');
    exit();
}
?>