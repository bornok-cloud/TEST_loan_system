<?php
session_start(); // Start session to check if the user is logged in

// Check if user is logged in and has a session variable
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'loan_management');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user email based on logged-in user ID
$user_id = $_SESSION['user_id'];
$sql = "SELECT email FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_email = $row['email'];
} else {
    die("User not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $loan_amount = $_POST['loan_amount'];
    $income = $_POST['income'];
    $loan_duration = $_POST['loan_duration'];
    $employment_status = $_POST['employment_status'];
    $loan_type = "Home Loan";

    $min_loan_amount = 50000;  
    $max_loan_amount = 1000000; 
    $min_interest_rate = 8.00;
    $max_interest_rate = 4.00;

    $interest_rate = $min_interest_rate - (($loan_amount - $min_loan_amount) / ($max_loan_amount - $min_loan_amount)) * ($min_interest_rate - $max_interest_rate);

    // Check if the email entered matches the logged-in user's email
    if ($email !== $user_email) {
        echo "<div class='alert alert-danger'>Error: Email should be the same as the email registered for your account.</div>";
    } elseif ($loan_amount < $min_loan_amount || $loan_amount > $max_loan_amount) {
        echo "<div class='alert alert-danger'>Error: Loan amount must be between $50,000 and $1,000,000.</div>";
    } else {
        $sql = "INSERT INTO loan_applications (name, email, phone, address, loan_type, loan_amount, income, loan_duration, employment_status, interest_rate, min_loan_amount, max_loan_amount)
                VALUES ('$name', '$email', '$phone', '$address', '$loan_type', '$loan_amount', '$income', '$loan_duration', '$employment_status', '$interest_rate', '$min_loan_amount', '$max_loan_amount')";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Loan application submitted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Loan Application</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../loan_types.php"> UniqLoan Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../dashboard.php">dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="../calculator.php">calculator</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="form-container">
        <h2 class="text-center mb-4">Home Loan Application Form</h2>
        <form method="POST" action="HOMELOAN.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" name="phone" id="phone" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" name="address" id="address" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="loan_amount">Loan Amount</label>
                <input type="number" class="form-control" name="loan_amount" id="loan_amount" min="50000" max="1000000" required>
            </div>

            <div class="form-group">
                <label for="income">Monthly Income</label>
                <input type="number" class="form-control" name="income" id="income" required>
            </div>

            <div class="form-group">
                <label for="loan_duration">Loan Duration (in months)</label>
                <input type="number" class="form-control" name="loan_duration" id="loan_duration" required>
            </div>

            <div class="form-group">
                <label for="employment_status">Employment Status</label>
                <select class="form-control" name="employment_status" id="employment_status" required>
                    <option value="Employed">Employed</option>
                    <option value="Self-employed">Self-employed</option>
                    <option value="Unemployed">Unemployed</option>
                </select>
            </div>

            <div class="form-group">
                <label for="interest_rate">Interest Rate</label>
                <input type="text" class="form-control" name="interest_rate" id="interest_rate" value="<?php echo isset($interest_rate) ? number_format($interest_rate, 2) . '%' : ''; ?>" readonly>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit Application</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
