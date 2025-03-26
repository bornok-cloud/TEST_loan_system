<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Calculator</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color:rgb(212, 212, 212); 
            color: rgb(0, 0, 0); 
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Loan Management Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="adminhome.php">dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_borrower.php">borrowers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_calculator.php">calculator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="LOGIN1.php">logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Enable both scrolling & backdrop</button>

<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Backdrop with scrolling</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <p>Try scrolling the rest of the page to see this option in action.</p>
  </div>
</div>

    <!-- Loan Calculator -->
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="calculator card p-4">
                    <h1 class="text-center mb-4">Loan Calculator</h1>
                    <form id="loanForm" method="POST" action="">
                        <div class="form-group mb-3">
                            <label for="loanAmount">Loan Amount (₱):</label>
                            <input Placeholder="Loan Amount" type="number" class="form-control" id="loanAmount" name="loanAmount" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="interestRate">Interest Rate (%):</label>
                            <input Placeholder="Interest Rate" type="number" class="form-control" id="interestRate" name="interestRate" step="0.01" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="loanTerm">Loan Term (years):</label>
                            <input Placeholder="Loan Term(Years)" type="number" class="form-control" id="loanTerm" name="loanTerm" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" name="calculate">Calculate</button>
                    </form>
                    <div id="result" class="result mt-4">
                        <h2 class="text-center">Monthly Payment: 
                            <span id="monthlyPayment" class="fw-bold text-primary">
                                <?php
                                if (isset($_POST['calculate'])) {
                                    $loanAmount = $_POST['loanAmount'];
                                    $interestRate = $_POST['interestRate'];
                                    $loanTerm = $_POST['loanTerm'];
                                
                                    if (is_numeric($loanAmount) && is_numeric($interestRate) && is_numeric($loanTerm) && $loanTerm > 0) {
                                        $monthlyInterestRate = ($interestRate / 100) / 12;
                                        $numberOfPayments = $loanTerm * 12;
                                        $monthlyPayment = ($loanAmount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numberOfPayments));
                                        echo "₱" . number_format($monthlyPayment, 2);
                                    } else {
                                        echo "Invalid input";
                                    }
                                }
                                ?>
                            </span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--<script src="calcu.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>