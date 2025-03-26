<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Types</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style scr="../../stylekuno/userloan_type.css" ></style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">UniqLoan Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="loan_plans.php">Loan Plans</a></li>
                    <li class="nav-item"><a class="nav-link" href="Loan_types.php">Loan Types</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_loan.php">Add Loan</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <li class="nav-item"><a class="nav-link" href="calculator.php">Calculator</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row card-columns justify-content-center">
            <!-- Car loan card -->
            <div class="col-md-4 col-sm-6 col-12">
                <div id="b1" class="card">
                    <img src="../../img/carloan.jpg" class="card-img-top" alt="Car loan">
                    <div class="card-body">
                        <h5 class="card-title">Car Loan</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="Loan_types.php" class="btn btn-dark stretched-link">Go somewhere</a>
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
                        <a href="dashboard.php" class="btn btn-dark stretched-link">Go somewhere</a>
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
                        <a href="add_loan.php" class="btn btn-dark stretched-link">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
