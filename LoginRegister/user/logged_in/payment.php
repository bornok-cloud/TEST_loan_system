<?php
// Start session
session_start();

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
$reference_number = '';
$loan_details = null;
$payment_amount = 0;
$message = '';
$amortization_schedule = [];
$violation_rate = 0.06; // 6% violation rate
$fixed_interest_rate = 0.03; // Fixed 3% interest rate

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Search for loan by reference number
    if (isset($_POST['search'])) {
        $reference_number = $conn->real_escape_string($_POST['reference_number']);
        
        $query = "SELECT la.*, 
                 COALESCE(SUM(p.amount), 0) as total_paid,
                 la.term_of_loan, la.application_date  /* Added these fields explicitly */
                 FROM loan_applications la
                 LEFT JOIN payments p ON la.reference_number = p.reference_number
                 WHERE la.reference_number = ? AND la.status = 'Approved'
                 GROUP BY la.id";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $reference_number);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $loan_details = $result->fetch_assoc();
            
            // Calculate total loan amount with interest
            $loan_term = $loan_details['term_of_loan']; // Get the term from the DB
            $base_loan_amount = $loan_details['loan_amount'];
            $total_interest = $base_loan_amount * $fixed_interest_rate * $loan_term / 12;
            $total_loan_amount = $base_loan_amount + $total_interest;
            
            // Add these values to loan_details
            $loan_details['total_loan_amount'] = $total_loan_amount;
            $loan_details['total_interest'] = $total_interest;
            $loan_details['remaining_balance'] = $total_loan_amount - $loan_details['total_paid'];
            
            // Generate amortization schedule
            generateAmortizationSchedule($conn, $loan_details, $reference_number);
        } else {
            $message = "<div class='alert alert-danger'>No approved loan found with that reference number.</div>";
        }
        $stmt->close();
    }
    
    // Process payment
    elseif (isset($_POST['pay'])) {
        $reference_number = $conn->real_escape_string($_POST['reference_number']);
        $payment_amount = floatval($_POST['payment_amount']);
        $payment_method = $conn->real_escape_string($_POST['payment_method']);
        $transaction_id = 'UNIQLOAN-' . strtoupper(substr(md5(uniqid()), 0, 8));
        
        // Verify the loan exists and is approved
        $verify_query = "SELECT * FROM loan_applications WHERE reference_number = ? AND status = 'Approved'";
        $stmt = $conn->prepare($verify_query);
        $stmt->bind_param("s", $reference_number);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $loan = $result->fetch_assoc();
            $loan_term = $loan['term_of_loan']; // Get the term
            $base_loan_amount = $loan['loan_amount'];
            $total_interest = $base_loan_amount * $fixed_interest_rate * $loan_term / 12;
            $total_loan_amount = $base_loan_amount + $total_interest;
            
            // Get current total paid
            $balance_query = "SELECT COALESCE(SUM(amount), 0) as total_paid FROM payments WHERE reference_number = ?";
            $stmt = $conn->prepare($balance_query);
            $stmt->bind_param("s", $reference_number);
            $stmt->execute();
            $balance_result = $stmt->get_result();
            $balance_row = $balance_result->fetch_assoc();
            $total_paid = $balance_row['total_paid'];
            
            $remaining_balance = $total_loan_amount - $total_paid;
            
            // Check if payment amount is valid
            $epsilon = 0.01; // Small tolerance for floating point comparison
            if ($payment_amount <= 0) {
                $message = "<div class='alert alert-danger'>Payment amount must be greater than zero.</div>";
            } elseif ($payment_amount > ($remaining_balance + $epsilon)) {
                $message = "<div class='alert alert-danger'>Payment amount cannot exceed the remaining balance of ₱" . number_format($remaining_balance, 2) . ".</div>";
            } else {
                // Ensure payment doesn't exceed actual balance (in case it's within epsilon but slightly higher)
                $payment_amount = min($payment_amount, $remaining_balance);
                
                // Insert payment record
                $insert_query = "INSERT INTO payments (reference_number, amount, payment_method, transaction_id, payment_date) 
                                VALUES (?, ?, ?, ?, NOW())";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param("sdss", $reference_number, $payment_amount, $payment_method, $transaction_id);
                
                if ($stmt->execute()) {
                    // Check if loan is fully paid
                    $new_total_paid = $total_paid + $payment_amount;
                    if ($new_total_paid >= $total_loan_amount) {
                        // Update loan status to paid
                        $update_query = "UPDATE loan_applications SET status = 'Paid' WHERE reference_number = ?";
                        $stmt = $conn->prepare($update_query);
                        $stmt->bind_param("s", $reference_number);
                        $stmt->execute();
                        $message = "<div class='alert alert-success'>Payment of ₱" . number_format($payment_amount, 2) . " successful! Your loan has been fully paid. Transaction ID: " . $transaction_id . "</div>";
                    } else {
                        $message = "<div class='alert alert-success'>Payment of ₱" . number_format($payment_amount, 2) . " successful! Remaining balance: ₱" . number_format($total_loan_amount - $new_total_paid, 2) . ". Transaction ID: " . $transaction_id . "</div>";
                    }
                    
                    // Refresh loan details
                    $query = "SELECT la.*, 
                             COALESCE(SUM(p.amount), 0) as total_paid,
                             la.term_of_loan, la.application_date
                             FROM loan_applications la
                             LEFT JOIN payments p ON la.reference_number = p.reference_number
                             WHERE la.reference_number = ? AND la.status IN ('Approved', 'Paid')
                             GROUP BY la.id";
                    
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("s", $reference_number);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $loan_details = $result->fetch_assoc();
                    
                    // Calculate loan details with interest
                    $loan_term = $loan_details['term_of_loan'];
                    $base_loan_amount = $loan_details['loan_amount'];
                    $total_interest = $base_loan_amount * $fixed_interest_rate * $loan_term / 12;
                    $total_loan_amount = $base_loan_amount + $total_interest;
                    
                    // Add these values to loan_details
                    $loan_details['total_loan_amount'] = $total_loan_amount;
                    $loan_details['total_interest'] = $total_interest;
                    $loan_details['remaining_balance'] = $total_loan_amount - $loan_details['total_paid'];
                    
                    // Recalculate amortization schedule after payment
                    generateAmortizationSchedule($conn, $loan_details, $reference_number);
                } else {
                    $message = "<div class='alert alert-danger'>Error processing payment: " . $conn->error . "</div>";
                }
            }
        } else {
            $message = "<div class='alert alert-danger'>No approved loan found with that reference number.</div>";
        }
        $stmt->close();
    }
}

// Get payment history if loan details exist
$payment_history = [];
if ($loan_details) {
    $history_query = "SELECT * FROM payments WHERE reference_number = ? ORDER BY payment_date DESC";
    $stmt = $conn->prepare($history_query);
    $stmt->bind_param("s", $reference_number);
    $stmt->execute();
    $history_result = $stmt->get_result();
    while ($row = $history_result->fetch_assoc()) {
        $payment_history[] = $row;
    }
    $stmt->close();
    
    // Generate amortization schedule if not already done
    if (empty($amortization_schedule)) {
        generateAmortizationSchedule($conn, $loan_details, $reference_number);
    }
}

// Function to generate amortization schedule
function generateAmortizationSchedule($conn, $loan_details, $reference_number) {
    global $amortization_schedule, $violation_rate, $fixed_interest_rate;
    
    // Get loan details
    $base_loan_amount = $loan_details['loan_amount'];
    
    // Get loan term from database
    $loan_term = isset($loan_details['term_of_loan']) ? $loan_details['term_of_loan'] : 12;
    
    // Calculate interest properly (fixed rate of 3% for the entire loan term)
    $total_interest = $base_loan_amount * $fixed_interest_rate * $loan_term / 12; // Convert to monthly interest
    $total_repayment = $base_loan_amount + $total_interest;
    
    // Calculate the monthly payment (always the same for all months)
    $monthly_payment = $loan_term > 0 ? $total_repayment / $loan_term : 0;
    
    // Round to 2 decimal places for consistency
    $monthly_payment = round($monthly_payment, 2);
    
    // Ensure the total repayment matches when multiplied by the term
    // This prevents rounding discrepancies in the final payment
    $adjusted_total_repayment = $monthly_payment * $loan_term;
    
    // Get application date and set first payment date to 1 month after application date
    $first_payment_date = null;
    
    if (isset($loan_details['application_date'])) {
        // Set first payment date to 1 month after application date
        $application_date = new DateTime($loan_details['application_date']);
        $first_payment_date = clone $application_date;
        $first_payment_date->modify('+1 month'); // First payment due 1 month after application
    } else {
        // Fallback to current date if application_date is not available
        $first_payment_date = new DateTime();
        $first_payment_date->modify('first day of this month'); // First day of current month
    }
    
    // Get all payments with their dates
    $payments_query = "SELECT amount, payment_date FROM payments WHERE reference_number = ? ORDER BY payment_date ASC";
    $stmt = $conn->prepare($payments_query);
    $stmt->bind_param("s", $reference_number);
    $stmt->execute();
    $payments_result = $stmt->get_result();
    
    // Map to store payments by month
    $payments_by_month = [];
    
    while ($payment = $payments_result->fetch_assoc()) {
        $payment_date = new DateTime($payment['payment_date']);
        $year_month = $payment_date->format('Y-m');
        
        if (!isset($payments_by_month[$year_month])) {
            $payments_by_month[$year_month] = 0;
        }
        $payments_by_month[$year_month] += $payment['amount'];
    }
    
    // Calculate total paid amount
    $total_paid_query = "SELECT COALESCE(SUM(amount), 0) as total_paid FROM payments WHERE reference_number = ?";
    $stmt = $conn->prepare($total_paid_query);
    $stmt->bind_param("s", $reference_number);
    $stmt->execute();
    $total_paid_result = $stmt->get_result();
    $total_paid_row = $total_paid_result->fetch_assoc();
    $overall_total_paid = $total_paid_row['total_paid'];
    
    // Generate schedule
    $amortization_schedule = [];
    $remaining_balance = $adjusted_total_repayment;
    $current_date = new DateTime(); // Today's date
    
    // Track allocated payments for each installment
    $allocated_payments = array_fill(0, $loan_term, 0);
    
    // First, allocate payments to installments chronologically
    $remaining_payment = $overall_total_paid;
    
    for ($i = 0; $i < $loan_term && $remaining_payment > 0; $i++) {
        $due_date = clone $first_payment_date;
        $due_date->modify("+$i month");
        
        // Only allocate up to the monthly payment amount for each installment
        $allocation = min($monthly_payment, $remaining_payment);
        $allocated_payments[$i] = $allocation;
        $remaining_payment -= $allocation;
    }
    
    // Calculate interest portion for each payment (consistent for all payments)
    $interest_per_payment = $total_interest / $loan_term;
    $principal_per_payment = $monthly_payment - $interest_per_payment;
    
    // Create the amortization schedule
    for ($i = 0; $i < $loan_term; $i++) {
        $due_date = clone $first_payment_date;
        $due_date->modify("+$i month");
        
        $year_month = $due_date->format('Y-m');
        $month_payment = isset($payments_by_month[$year_month]) ? $payments_by_month[$year_month] : 0;
        $allocated_payment = $allocated_payments[$i];
        
        // Calculate remaining balance after this payment
        $remaining_balance -= $allocated_payment;
        
        // Determine status based on due date, current date, and payment allocation
        $epsilon = 0.01; // Small tolerance for float comparison
        
        // Check if this installment is fully paid (allocated payment covers the monthly payment)
        $is_fully_paid = $allocated_payment >= ($monthly_payment - $epsilon);
        
        // Check if this installment has partial payment
        $is_partial = $allocated_payment > $epsilon && $allocated_payment < ($monthly_payment - $epsilon);
        
        // Check if this payment is past due
        $is_past_due = $due_date < $current_date && !$is_fully_paid;
        
        // Calculate violation fee if applicable (only for past due dates)
        $violation_fee = $is_past_due ? ($monthly_payment - $allocated_payment) * $violation_rate : 0;
        
        // Determine status
        if ($due_date > $current_date) {
            // Future installment
            if ($is_fully_paid) {
                $status = 'Paid (Early)';
            } else if ($is_partial) {
                $status = 'Partial (Early)';
            } else {
                $status = 'Upcoming';
            }
        } else {
            // Current or past installment
            if ($is_fully_paid) {
                $status = 'Paid';
            } else if ($is_partial) {
                $status = 'Partial';
            } else {
                $status = 'Overdue';
            }
        }
        
        $amortization_schedule[] = [
            'due_date' => $due_date,
            'monthly_payment' => $monthly_payment,
            'interest_payment' => $interest_per_payment,
            'principal_payment' => $principal_per_payment,
            'remaining_balance' => max(0, $remaining_balance),
            'actual_payment' => $allocated_payment,
            'is_past_due' => $is_past_due,
            'violation_fee' => $violation_fee,
            'status' => $status
        ];
        
        // If total balance is zero, no need to continue
        if ($remaining_balance <= 0) {
            break;
        }
    }
    
    return $amortization_schedule;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniQLoan Payment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .payment-card {
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
        .payment-header {
            background-color: #dc3545;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px;
        }
        .payment-logo {
            font-size: 24px;
            font-weight: bold;
        }
        .payment-method-card {
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .payment-method-card.active {
            border-color: #dc3545;
            background-color: rgba(220, 53, 69, 0.05);
        }
        .payment-history-item {
            border-left: 4px solid #dc3545;
            padding-left: 15px;
            margin-bottom: 15px;
        }
        .amortization-table th, .amortization-table td {
            vertical-align: middle;
        }
        .status-paid {
            background-color: rgba(25, 135, 84, 0.1);
        }
        .status-partial {
            background-color: rgba(255, 193, 7, 0.1);
        }
        .status-overdue {
            background-color: rgba(220, 53, 69, 0.1);
        }
        .status-upcoming {
            background-color: rgba(13, 110, 253, 0.1);
        }
        .payment-calendar {
            max-height: 500px;
            overflow-y: auto;
        }
        .violation-fee {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
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
                    <a class="btn btn-danger ms-4 active" href="payment.php">Payment</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="btn btn-outline-dark toggle ms-1" href="../../../index.php" role="button">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <?php if (!empty($message)): ?>
                <?= $message ?>
            <?php endif; ?>
            
            <div class="card payment-card">
                <div class="payment-header text">
                <a href="javascript:history.back()" class="btn btn-outline-light back-btn">
            <i class="bi bi-arrow-left"></i> Back
        </a>
                    <div class="payment-logo mb-2">UNIQLOAN E-PAYMENT</div>
                    <p class="mb-0">Safe, secure, and convenient way to pay your loans</p>
                </div>
                
                <div class="card-body p-4">
                    <!-- Search Form -->
                    <form method="POST" class="mb-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text bg-danger text-white"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control form-control-lg" name="reference_number" 
                                           placeholder="Enter your reference number" 
                                           value="<?= htmlspecialchars($reference_number) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" name="search" class="btn btn-danger btn-lg w-100">
                                    Find My Loan
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <?php if ($loan_details): ?>
                        <!-- Loan Details -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Loan Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p><strong>Reference Number:</strong> <?= htmlspecialchars($loan_details['reference_number']) ?></p>
                                        <p><strong>Borrower Name:</strong> <?= htmlspecialchars($loan_details['full_name']) ?></p>
                                        <p><strong>Status:</strong> 
                                            <span class="badge <?= $loan_details['status'] == 'Paid' ? 'bg-success' : 'bg-primary' ?>">
                                                <?= htmlspecialchars($loan_details['status']) ?>
                                            </span>
                                        </p>
                                        <p><strong>Loan Term:</strong> <?= htmlspecialchars($loan_details['term_of_loan']) ?> months</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Principal Amount:</strong> ₱<?= number_format($loan_details['loan_amount'], 2) ?></p>
                                        <p><strong>Interest Amount (3%):</strong> ₱<?= number_format($loan_details['total_interest'], 2) ?></p>
                                        <p><strong>Total Loan Amount:</strong> ₱<?= number_format($loan_details['total_loan_amount'], 2) ?></p>
                                        <p><strong>Amount Paid:</strong> ₱<?= number_format($loan_details['total_paid'], 2) ?></p>
                                        <p><strong>Remaining Balance:</strong> ₱<?= number_format($loan_details['remaining_balance'], 2) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Amortization Schedule Calendar -->
                        <div class="card mb-4">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Amortization Schedule</h5>
                                <span class="badge bg-danger">6% Violation Rate for Late/Missed Payments</span>
                            </div>
                            <div class="card-body payment-calendar">
                                <div class="table-responsive">
                                    <table class="table table-bordered amortization-table">
                                        <thead>
                                            <tr class="table-light">
                                                <th>Due Date</th>
                                                <th>Monthly Payment</th>
                                                <th>Principal</th>
                                                <th>Interest</th>
                                                <th>Remaining Balance</th>
                                                <th>Status</th>
                                                <th>Violation Fee</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($amortization_schedule as $index => $payment): ?>
                                                <tr class="status-<?= strtolower($payment['status']) ?>">
                                                    <td><?= $payment['due_date']->format('M d, Y') ?></td>
                                                    <td>₱<?= number_format($payment['monthly_payment'], 2) ?></td>
                                                    <td>₱<?= number_format($payment['principal_payment'], 2) ?></td>
                                                    <td>₱<?= number_format($payment['interest_payment'], 2) ?></td>
                                                    <td>₱<?= number_format($payment['remaining_balance'], 2) ?></td>
                                                    <td>
                                                        <span class="badge <?php 
                                                            switch($payment['status']) {
                                                                case 'Paid': echo 'bg-success'; break;
                                                                case 'Partial': echo 'bg-warning'; break;
                                                                case 'Overdue': echo 'bg-danger'; break;
                                                                case 'Upcoming': echo 'bg-primary'; break;
                                                            }
                                                        ?>">
                                                            <?= $payment['status'] ?>
                                                        </span>
                                                        <?php if ($payment['actual_payment'] > 0 && $payment['status'] != 'Paid'): ?>
                                                            <div class="small mt-1">Paid: ₱<?= number_format($payment['actual_payment'], 2) ?></div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($payment['violation_fee'] > 0): ?>
                                                            <span class="violation-fee">₱<?= number_format($payment['violation_fee'], 2) ?></span>
                                                        <?php else: ?>
                                                            ₱0.00
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <strong>Note:</strong> A 6% violation fee is applied to any unpaid or partially paid monthly amortization amount.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($loan_details['remaining_balance'] > 0): ?>
                            <!-- Payment Form -->
                            <form method="POST" id="paymentForm">
                                <input type="hidden" name="reference_number" value="<?= htmlspecialchars($reference_number) ?>">
                                
                                <h5 class="mb-3">Make a Payment</h5>
                                
                                <!-- Payment Methods -->
                                <div class="mb-4">
                                    <label class="form-label">Select Payment Method</label>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="payment-method-card active" data-method="UniQ E-Wallet">
                                                <div class="text-center">
                                                    <i class="bi bi-wallet2 fs-2 text-danger"></i>
                                                    <h6 class="mt-2 mb-0">UniQ E-Wallet</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="payment_method" id="paymentMethod" value="UniQ E-Wallet">
                                </div>
                                
                                <!-- Payment Amount -->
                                <div class="mb-4">
                                    <label for="paymentAmount" class="form-label">Payment Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="number" step="0.01" class="form-control" id="paymentAmount" name="payment_amount" 
                                               placeholder="Enter amount" min="1" max="<?= $loan_details['remaining_balance'] ?>" required>
                                    </div>
                                    <div class="form-text">Remaining balance: ₱<?= number_format($loan_details['remaining_balance'], 2) ?></div>
                                </div>
                                
                                <!-- Quick Amount Buttons -->
                                <div class="mb-4">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-danger quick-amount" data-amount="<?= round($loan_details['remaining_balance'] * 0.25, 2) ?>">25%</button>
                                        <button type="button" class="btn btn-outline-danger quick-amount" data-amount="<?= round($loan_details['remaining_balance'] * 0.5, 2) ?>">50%</button>
                                        <button type="button" class="btn btn-outline-danger quick-amount" data-amount="<?= round($loan_details['remaining_balance'], 2) ?>">Full Amount</button>
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <button type="submit" name="pay" class="btn btn-danger btn-lg w-100 mt-3">
                                    <i class="bi bi-lock-fill me-2"></i> Pay Now
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <!-- Payment History -->
                        <?php if (!empty($payment_history)): ?>
                            <div class="mt-5">
                                <h5 class="mb-3">Payment History</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>Transaction</th> -->
                                                        <th>Transaction ID</th>
                                                        <th>Amount</th>
                                                        <th>Payment Method</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($payment_history as $payment): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($payment['transaction_id']) ?></td>
                                                            <td>₱<?= number_format($payment['amount'], 2) ?></td>
                                                            <td><?= htmlspecialchars($payment['payment_method']) ?></td>
                                                            <td><?= date('M d, Y h:i A', strtotime($payment['payment_date'])) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                    <?php elseif ($reference_number): ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            No approved loan found with reference number: <?= htmlspecialchars($reference_number) ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-credit-card text-danger" style="font-size: 4rem;"></i>
                            <h4 class="mt-3">Enter your reference number to make a payment</h4>
                            <p class="text-muted">Your reference number can be found on your loan agreement document or email.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Payment method selection
    const paymentCards = document.querySelectorAll('.payment-method-card');
    const paymentMethodInput = document.getElementById('paymentMethod');
    
    paymentCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove active class from all cards
            paymentCards.forEach(c => c.classList.remove('active'));
            // Add active class to clicked card
            this.classList.add('active');
            // Update hidden input
            paymentMethodInput.value = this.getAttribute('data-method');
        });
    });
    
    // Quick amount buttons
    const quickAmountButtons = document.querySelectorAll('.quick-amount');
    const paymentAmountInput = document.getElementById('paymentAmount');
    
    quickAmountButtons.forEach(button => {
        button.addEventListener('click', function() {
            paymentAmountInput.value = this.getAttribute('data-amount');
        });
    });
});
</script>

<?php include('../../../includes/sidebar_logged_in.php'); ?>
<?php include('../../../includes/script.php'); ?>
</body>
</html>
<?php $conn->close(); ?>