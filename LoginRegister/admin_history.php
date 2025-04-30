<?php
// Start session
session_start();
include('../includes/admin_header.php'); 
// Database connection
$host = 'localhost';
$db = 'loan_system'; 
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$paid_loans = [];
$message = '';

// Fetch all paid loans
$query = "SELECT la.*, 
         COALESCE(SUM(p.amount), 0) as total_paid,
         la.term_of_loan, la.application_date
         FROM loan_applications la
         LEFT JOIN payments p ON la.reference_number = p.reference_number
         WHERE la.status = 'Paid'
         GROUP BY la.id
         ORDER BY la.application_date DESC";

$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Calculate total loan amount with interest
        $loan_term = $row['term_of_loan'];
        $base_loan_amount = $row['loan_amount'];
        $fixed_interest_rate = 0.03; // Fixed 3% interest rate
        $total_interest = $base_loan_amount * $fixed_interest_rate * $loan_term / 12;
        $total_loan_amount = $base_loan_amount + $total_interest;
        
        // Add these values to the loan details
        $row['total_loan_amount'] = $total_loan_amount;
        $row['total_interest'] = $total_interest;
        
        // Get the last payment date
        $last_payment_query = "SELECT MAX(payment_date) as last_payment_date FROM payments WHERE reference_number = ?";
        $stmt = $conn->prepare($last_payment_query);
        $stmt->bind_param("s", $row['reference_number']);
        $stmt->execute();
        $payment_result = $stmt->get_result();
        $payment_row = $payment_result->fetch_assoc();
        $row['completion_date'] = $payment_row['last_payment_date'];
        
        $paid_loans[] = $row;
    }
} else {
    $message = "<div class='alert alert-info'>No paid loans found.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan History - UniQLoan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .history-card {
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
        .history-header {
            background-color: #198754;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px;
        }
        .history-logo {
            font-size: 24px;
            font-weight: bold;
        }
        .loan-item {
            border-left: 4px solid #198754;
            padding-left: 15px;
            margin-bottom: 15px;
        }
        .paid-badge {
            background-color: #198754;
        }
        .no-loans {
            padding: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <button id="sidebarToggle" class="btn btn-outline-dark">☰</button>
        <a class="navbar-brand text-danger fw-bold ms-4" href="#">UNIQLOAN</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../../../index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Loans Plans</a></li>
                <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
             <li class="nav-item">
                    <a class="btn btn-danger ms-4" href="payment.php">Payment</a>
                </li> -->
                <!-- <li class="nav-item dropdown">
                    <a class="btn btn-outline-dark toggle ms-1" href="../../../index.php" role="button">Log out</a>
                </li> 
            </ul>
        </div>
    </div>
</nav> -->

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <?php if (!empty($message)): ?>
                <?= $message ?>
            <?php endif; ?>
            
            <div class="card history-card">
            
                <div class="history-header text">
                <a href="javascript:history.back()" class="btn btn-outline-light back-btn">
            <i class="bi bi-arrow-left"></i> Back
        </a>
                    <div class="history-logo mb-2">UNIQLOAN PAYMENT HISTORY</div>
                    <p class="mb-0">View your completed loan payments and history</p>
                </div>
                
                <div class="card-body p-4">
                    <?php if (!empty($paid_loans)): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            You have <strong><?= count($paid_loans) ?></strong> fully paid loan(s).
                        </div>
                        
                        <!-- Paid Loans List -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Reference Number</th>
                                        <th>Borrower</th>
                                        <th>Loan Amount</th>
                                        <th>Interest</th>
                                        <th>Total Paid</th>
                                        <th>Term</th>
                                        <th>Application Date</th>
                                        <th>Completion Date</th>
                                        <!-- <th>Actions</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($paid_loans as $loan): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($loan['reference_number']) ?></td>
                                            <td><?= htmlspecialchars($loan['full_name']) ?></td>
                                            <td>₱<?= number_format($loan['loan_amount'], 2) ?></td>
                                            <td>₱<?= number_format($loan['total_interest'], 2) ?></td>
                                            <td>₱<?= number_format($loan['total_paid'], 2) ?></td>
                                            <td><?= htmlspecialchars($loan['term_of_loan']) ?> months</td>
                                            <td><?= date('M d, Y', strtotime($loan['application_date'])) ?></td>
                                            <td><?= date('M d, Y', strtotime($loan['completion_date'])) ?></td>
                                            <!-- <td>
                                                <a href="payment.php?reference_number=<?= urlencode($loan['reference_number']) ?>" class="btn btn-sm btn-success">
                                                    <i class="bi bi-eye"></i> View Details
                                                </a>
                                            </td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="no-loans">
                            <i class="bi bi-journal-check text-success" style="font-size: 4rem;"></i>
                            <h4 class="mt-3">No Completed Loans Found</h4>
                            <p class="text-muted">When you complete loan payments, they will appear here for your reference.</p>
                            <a href="payment.php" class="btn btn-success mt-3">
                                <i class="bi bi-credit-card me-2"></i> Make a Payment
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include('../includes/admin_sidebar.php'); ?>
<?php include('../includes/script.php'); ?>
</body>
</html>
<?php $conn->close(); ?>