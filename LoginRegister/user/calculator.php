<?php include('../../includes/header.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Calculator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
        }
        .calculator {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .result-card {
            background: #fdf3e6;
            border-radius: 10px;
            padding: 20px;
        }
        .loan-terms button {
            border: 1px solid #ddd;
            padding: 8px 12px;
            margin: 5px;
            background: white;
            cursor: pointer;
        }
        .loan-terms button.active {
            background: #16a34a;
            color: white;
        }
        .apply-btn {
            background: #16a34a;
            color: white;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            text-align: center;
            float: right;
        }
        .center-btn {
            display: block;
            margin: 0 auto;
            text-align: center;
            width: 30%; /* Adjust width as necessary */
            margin-top: 70px; /* Add top margin if needed */
            margin-left: 472px;
        }

        

            
        
    </style>
</head>
<body>
<a href="registration.php">
  <button type="button" id="apply_btn" class="btn btn-success btn-lg btn-block center-btn">Register to apply for cash loan</button>
</a>

    <div class="container mt-5">
        <h3 class="text-center text-dark">Need A Quick Personal Loan?</h3>
        <h1 class="text-center">Try Our Cash Loan Calculator</h1>
        <p class="text-center">Want cash and need to know how much your online loan’s monthly payments will be?</p>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="calculator">
                    <h4><i class="fa-solid fa-wallet text-danger"></i> Get a sample cash loan computation</h4>
                    <label for="loanAmount" class="form-label">How much money do you need?</label>
                    <input type="number" id="loanAmount" class="form-control" value="30000" min="3000" max="150000">
                    <input type="range" id="loanRange" class="form-range mt-2" min="5000" max="100000" value="30000">
                    <p class="text-muted">Loan amount starts at ₱5,000 up to ₱100,000</p>
                    <div class="loan-terms">
                        <p>Sample Loan Terms (months)</p>
                        <div>
                            <button class="term-btn" data-term="6">6</button>
                            <button class="term-btn" data-term="9">9</button>
                            <button class="term-btn" data-term="12">12</button>
                            <button class="term-btn active" data-term="24">24</button>
                            <button class="term-btn" data-term="30">30</button>
                            <button class="term-btn" data-term="36">36</button>
                            <button class="term-btn" data-term="45">45</button>
                            <button class="term-btn" data-term="48">48</button>
                            <button class="term-btn" data-term="60">60</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="result-card">
                    <table class="table">
                        <tr>
                            <td>Loan Term</td>
                            <td id="selectedTerm">24 months</td>
                        </tr>
                        <tr>
                            <td>Loan Amount</td>
                            <td id="selectedAmount">₱30,000</td>
                        </tr>
                        <tr>
                            <td>Processing Fee <i class="fa-solid fa-info-circle"></i></td>
                            <td>-₱500</td>
                        </tr>
                        <tr>
                            <td>Amount to be Disbursed</td>
                            <td id="disbursedAmount">₱29,500</td>
                        </tr>
                    </table>
                    <h5 class="text-center">Estimated Monthly Installment</h5>
                    <h2 class="text-center text-dark fw-bold" id="monthlyInstallment">₱1,965.59 per month</h2>
                    <a href="#" class="apply-btn btn btn-danger"><b>Check if you are qualified for a cash loan</b></a>
                </div>
            </div>
        </div>
    </div>

    
       <?php include('../../includes/sidebar.php')?>
       <?php include('../../includes/footer.php')?>
    <?php include('../../includes/script.php')?>

</body>
</html>
