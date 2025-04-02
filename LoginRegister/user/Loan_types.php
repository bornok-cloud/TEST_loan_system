<?php include('../../includes/header.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Types</title>
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style scr="../../stylekuno/userloan_type.css" ></style>
    <style>
        .navbar-brand img {
            width: 70px;  
            height: 70px; 
            border-radius: 80%; 
            margin-right: 20px; 
            margin-left:20px;
        }
    </style> -->
</head>
<body class="bg-light">
<!--<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="dashboard.php">
                <img src="../../img/uniqloan_logo.jpg" alt="Logo"> UniqLoan Management
            </a>
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="loan_plans.php">loan plans</a></li>
                    <li class="nav-item"><a class="nav-link" href="Loan_types.php">loan types</a></li>
                    <li class="nav-item"><a class="nav-link" href="payment.php">payment</a></li>
                    <li class="nav-item"><a class="nav-link" href="calculator.php">calculator</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">logout</a></li>
                </ul>
            </div>
        </div>
    </nav>-->

    <div class="container mt-2">
        <div class="row card-columns justify-content-center">
            <!-- Car loan card -->
            <div class="col-md-4 col-sm-1 col-12">
                <div id="b1" class="card">
                    <img src="../../img/carloan.jpg" class="card-img-top" alt="Car loan">
                    <div class="card-body">
                        <h5 class="card-title">Car Loan</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="loantype_section/CARLOAN.php" class=""></a>
                    </div>
                </div>
            </div>

            <!-- Home loan card -->
            <div class="col-md-4 col-sm-6 col-12">
                <div id="b2" class="card">
                    <img src="../../img/homeloan.jpg" class="card-img-top" alt="Home loan">
                    <div class="card-body">
                        <h5 class="card-title">Home Loan</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="loantype_section/HOMELOAN.php" class=""></a>
                    </div>
                </div>
            </div>

            <!-- Appliance loan card -->
            <div class="col-md-4 col-sm-6 col-12">
                <div id="b3" class="card">
                    <img src="../../img/applianceloan.jpg" class="card-img-top" alt="Appliance loan">
                    <div class="card-body">
                        <h5 class="card-title">Appliance Loan</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="loantype_section/APPLIANCELOAN.php" class=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include('../../includes/sidebar.php')?>
    <?php include('../../includes/footer.php')?>
    <?php include('../../includes/script.php')?>

    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>-->
</body>
</html>
