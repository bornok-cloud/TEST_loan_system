<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color:rgb(212, 212, 212); 
            color: rgb(0, 0, 0); 
        }
        h2 {
            text-shadow: 0 0 3px rgb(0, 0, 0), 0 0 5px rgb(0, 0, 0);
            margin-bottom: 3;
            padding: 0;
        }
        .navbar {
            margin-bottom: 0px;
        }
        .navbar-nav .nav-link {
            padding: 8px 15px;
            font-size: 16px;
        }
        .navbar-brand img {
            width: 40px;
            height: 40px;
        }
        h5{
            text-shadow: 0 0 3px rgb(0, 0, 0), 0 0 5px rgb(0, 0, 0);
            margin-bottom: 3;
            padding: 0;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!--<a class="navbar-brand" href="dashboard.php">
                <img src="#" alt="UNIQLOAN Logo" class="img-fluid"> 
            </a>-->
            
            <a class="navbar-brand" href="dashboard.php">UniqLoan Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="loan_plans.php">loan plans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Loan_types.php">loan types</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_loan.php">add loan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="LOGIN1.php">logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="calculator.php">calculator</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="card text-bg-dark">
  <img src="img/BANNER1.jpg" class="card-img" alt="...">
  <div class="card-img-overlay">
    <h5 class="card-title">Page for Loan Plans</h5>
    <p class="card-text"></p>
    <p class="card-text"><small></small></p>
  </div>
</div>
</body>
</html>