<?php
/*session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}*/

include ('../../db_file/db.php');
/*$totalLoans = $conn->query("SELECT COUNT(*) as count FROM loans")->fetch_assoc()['count'];
$activeLoans = $conn->query("SELECT COUNT(*) as count FROM loans WHERE status='rejected'")->fetch_assoc()['count'];
$paidLoans = $conn->query("SELECT COUNT(*) as count FROM loans WHERE status='pending'")->fetch_assoc()['count'];
$approveLoans = $conn->query("SELECT COUNT(*) as count FROM loans WHERE status='approved'")->fetch_assoc()['count'];

$query = "SELECT users.username, loans.amount, loans.status 
          FROM users 
          JOIN loans ON users.id = loans.user_id
          WHERE loans.status = 'approved'";
$result = $conn->query($query);*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style scr="../../stylekuno/userdashboard.css"></style>
    <style>
        .navbar-brand img {
            width: 70px;  
            height: 70px; 
            border-radius: 80%; 
            margin-right: 20px; 
            margin-left:20px;
        }
    </style>
</head>
<body>
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
    </nav>
        <!--<div>
        <img href="about.php" src="img/BANNER1.jpg" class="img-fluid" alt="...">
        </div>-->
        <!-- SLIDER PART-->
            <!--<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
        <img class="d-block w-100" src="../../img/BANNER1.jpg" alt="First slide">
        </div>
        <div class="carousel-item">
        <img class="d-block w-100" src="../../img/BANNER_CITY.jpg" alt="Second slide">
        </div>
        <div class="carousel-item">
        <img class="d-block w-100" src="../../img/BANNER_SUMMER.jpg" alt="Third slide">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only"></span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only"></span>
    </a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script src="../../javascript/carousel.js"></script>-->
<!--SLIDER PART -->     
        <div class="clearfix mt-5 ms-5">
            <img src="../../img/people.jpg" class="col-md-16 float-md-end mb-3 ms-md-3" alt="...">
            <p>At UNIQLOAN, your privacy and security are our top priorities. We use advanced encryption to protect your personal and financial information, keeping it safe from unauthorized access.</p>
            <p>We make sure that only trusted team members can access your data, and we never share it with anyone without your permission. Your information is always kept secure and private.</p>
            <p>To stay ahead of potential risks, we regularly update our security practices. With UNIQLOAN, you can be confident that your data is protected every step of the way.</p>
        </div>

    <!-- card malapit sa footer-->
    <div class="container mt-4">
    <div class="row d-flex justify-content-center align-items-center mt-4">
        <!-- Card 1 -->
        <div id="b1" class="col-md-4 mb-4">
            <div class="card" style="width: 18rem;">
                <img src="../../img/banner2.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">LOAN TYPES</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="Loan_types.php" class="btn btn-dark stretched-link">Go somewhere</a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div id="b2" class="col-md-4 mb-4">
            <div class="card" style="width: 18rem;">
                <img src="../../img/banner3.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Free to browse</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="dashboard.php" class="btn btn-dark stretched-link">Go somewhere</a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div id="b3" class="col-md-4 mb-4">
            <div class="card" style="width: 18rem;">
                <img src="../../img/banner2.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">ADD LOAN</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="add_loan.php" class="btn btn-dark stretched-link">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</div>


    <script>
        const ctx = document.getElementById('loanChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Total Loans', 'Rejected Loans', 'Pending Loans', 'Approved Loans'],
                datasets: [{
                    label: 'UNIQLOAN Statistics',
                    data: [<?php echo $totalLoans; ?>, <?php echo $activeLoans; ?>, <?php echo $paidLoans; ?>, <?php echo $approveLoans; ?>],
                    backgroundColor: ['#37AFE1', '#37AFE1', '#37AFE1', '#37AFE1'],
                }]
            },
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- FOOTER -->
</body>
</html>
