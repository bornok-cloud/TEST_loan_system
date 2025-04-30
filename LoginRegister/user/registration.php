<?php
    session_start();

    $page_title = 'Registration Form';
    ?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if(isset($page_title)){echo"$page_title";}?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body { background-color: #f8f9fa; }
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            background-color: white;
        }
        .btn-register {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            width: 100%;
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
                    <li class="nav-item "><a class="nav-link" href="../../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Loans Plans</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                    <li class="nav-item">
                        <a class="btn btn-danger ms-4" href="#">Payment</a>
                    </li>
                    <!-- <li class="nav-item dropdown">
                        <a class="btn btn-outline-dark dropdown-toggle ms-1" href="#" role="button" data-bs-toggle="dropdown">Account</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="login.php">Login</a></li>
                            <li><a class="dropdown-item" href="../../LoginRegister/user/registration.php">Register</a></li>
                        </ul>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>

<div class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <div class="alert">
                    <?php 
                        if(isset($_SESSION['status']))
                        {
                            echo "<h4>".$_SESSION['status']."</h4>";
                            unset($_SESSION['status']);
                        }
                    ?>
                </div>
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="text-center">Registration Form</h5>
                    </div>
                    <div class="card-body">
                    <form action="code.php" method="POST" id="registrationForm">
                        <div class="form-group mb-1">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group mb-1">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="form-group mb-1">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" required>
                        </div>
                        <div class="form-group mb-1">
                            <label class="form-label">Password</label>
                            <input type="text" name="password" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" name="register_btn" class="btn btn-danger">Register now</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../../includes/sidebar.php'); ?>
<?php include('../../includes/script.php'); ?>

</body>
</html>
