<?php
// Start output buffering at the very beginning
ob_start();

// Include necessary files
include('../authentication.php');
include('../../../db_file/db_connection.php');

// Initialize variables
$page_title = 'Application Success';
$reference_number = '';
$application = null;

// Check for existing application
if (!isset($_SESSION['loan_reference_number'])) {
    // Check database for most recent application
    $sql = "SELECT reference_number FROM loan_applications 
            WHERE user_id = ? 
            ORDER BY application_date DESC LIMIT 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $_SESSION['auth_user']['user_id']);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['loan_reference_number'] = $row['reference_number'];
            $reference_number = $row['reference_number'];
        } else {
            $_SESSION['message'] = "No application found. Please submit an application first.";
            $_SESSION['message_type'] = "danger";
            header('Location: dashboard.php');
            ob_end_flush();
            exit();
        }
    } else {
        $_SESSION['message'] = "Database error. Please try again.";
        $_SESSION['message_type'] = "danger";
        header('Location: index.php');
        ob_end_flush();
        exit();
    }
    $stmt->close();
} else {
    $reference_number = $_SESSION['loan_reference_number'];
}

// Get full application details
$sql = "SELECT * FROM loan_applications WHERE reference_number = ?";
$stmt = $con->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $reference_number);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $application = $result->fetch_assoc();
        } else {
            $_SESSION['message'] = "Application not found. Please try again.";
            $_SESSION['message_type'] = "danger";
            header('Location: dashboard.php');
            ob_end_flush();
            exit();
        }
    } else {
        $_SESSION['message'] = "Database error. Please try again.";
        $_SESSION['message_type'] = "danger";
        header('Location: index.php');
        ob_end_flush();
        exit();
    }
    $stmt->close();
} else {
    $_SESSION['message'] = "Database error. Please try again.";
    $_SESSION['message_type'] = "danger";
    header('Location: index.php');
    ob_end_flush();
    exit();
}

// Format loan amount
$formatted_loan_amount = '₱' . number_format($application['loan_amount'], 2);

// Now include the header (after all possible redirects)
include('../../../includes/header_logged_in.php');

// Flush the output buffer
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .success-card {
            max-width: 700px;
            margin: 2rem auto;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .success-icon {
            font-size: 60px;
            color: #28a745;
        }
        .reference-number {
            font-family: monospace;
            font-size: 1.2rem;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .application-details {
            margin-top: 2rem;
        }
        .detail-row {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="success-card bg-white">
            <div class="text-center mb-4">
                <div class="success-icon mb-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2>Application Submitted Successfully!</h2>
                <p class="lead">Your loan application has been received and is currently under review.</p>
                <div class="mt-3">
                    <p class="mb-1">Reference Number:</p>
                    <div class="reference-number"><?php echo $reference_number; ?></div>
                    <p class="text-muted small mt-2">Please save this reference number for future inquiries.</p>
                </div>
            </div>
            
            <div class="application-details">
                <h4 class="mb-3">Application Summary</h4>
                <div class="row detail-row">
                    <div class="col-md-4 fw-bold">Name:</div>
                    <div class="col-md-8"><?php echo htmlspecialchars($application['full_name']); ?></div>
                </div>
                <div class="row detail-row">
                    <div class="col-md-4 fw-bold">Loan Amount:</div>
                    <div class="col-md-8"><?php echo $formatted_loan_amount; ?></div>
                </div>
                <div class="row detail-row">
                    <div class="col-md-4 fw-bold">Purpose:</div>
                    <div class="col-md-8"><?php echo htmlspecialchars($application['loan_purpose']); ?></div>
                </div>
                <div class="row detail-row">
                    <div class="col-md-4 fw-bold">Application Date:</div>
                    <div class="col-md-8"><?php echo date('F d, Y h:i A', strtotime($application['application_date'])); ?></div>
                </div>
                <div class="row detail-row">
                    <div class="col-md-4 fw-bold">Status:</div>
                    <div class="col-md-8">
                        <span class="badge bg-warning text-dark"><?php echo htmlspecialchars($application['status']); ?></span>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p>We will review your application and get back to you within 24-48 hours.</p>
                <a href="../../../index.php" class="btn btn-light mt-3"></a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include('../../../includes/sidebar_logged_in.php'); ?>
    <?php include('../../../includes/script.php'); ?>
</body>
</html>