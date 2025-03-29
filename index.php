<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

-/* container sa home page */
.custom-container {
            background-color:rgb(80, 18, 13);
            border-radius: 10px;
            padding: 20px;
            max-width: 900px;
            margin: auto;
        }
        .icon-text {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .icon-text i {
            color: green;
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
                    <li class="nav-item"><a class="nav-link" href="">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Loans Plans</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                    <li class="nav-item">
                        <a class="btn btn-danger ms-4" href="#">Payment</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="btn btn-outline-dark dropdown-toggle ms-1" href="#" role="button" data-bs-toggle="dropdown">Account</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Login</a></li>
                            <li><a class="dropdown-item" href="#">Register</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div id="sidebar" class="p-3">
        <h4>Dashboard <button id="sidebarClose" class="btn btn-outline-dark ">☰</button></h4> 
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="LoginRegister/user/loan_types.php">Loan Types</a></li>
            <li class="nav-item"><a class="nav-link" href="">Loan Plans</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
        </ul>
       
    </div>
    
    <!-- sa home page ulit -->
    <div class="container my-5">
    <div class="row align-items-center custom-container">
        <div class="col-md-6">
            <h3><strong>Why choose Home Credit for your installment loans?</strong></h3>
            <p class="icon-text"><i class="bi bi-check-circle-fill"></i> Lowest interest & monthly rates</p>
            <p class="icon-text"><i class="bi bi-check-circle-fill"></i> Flexible payment options</p>
            <p class="icon-text"><i class="bi bi-check-circle-fill"></i> Fast & easy application process</p>
            <button class="btn btn-success">Get Installments</button>
        </div>
        <div class="col-md-6">
            <img src="img/BANNER1.jpg" class="img-fluid rounded" alt="Home Credit Assistance">
        </div>
    </div>
</div>
    
    
<?php include('includes/script.php')?>
<?php include('includes/sidebar.php')?>
        
</body>
</html>


