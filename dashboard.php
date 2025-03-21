<?php
/*session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}*/

require 'db.php';
$totalLoans = $conn->query("SELECT COUNT(*) as count FROM loans")->fetch_assoc()['count'];
$activeLoans = $conn->query("SELECT COUNT(*) as count FROM loans WHERE status='rejected'")->fetch_assoc()['count'];
$paidLoans = $conn->query("SELECT COUNT(*) as count FROM loans WHERE status='pending'")->fetch_assoc()['count'];
$approveLoans = $conn->query("SELECT COUNT(*) as count FROM loans WHERE status='approved'")->fetch_assoc()['count'];

$query = "SELECT users.username, loans.amount, loans.status 
          FROM users 
          JOIN loans ON users.id = loans.user_id
          WHERE loans.status = 'approved'";
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
        .card {
            border-radius: 10px;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
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
        .table {
            text-align: left;
        }
        .clearfix {
            margin-top: 40px;
        }
        .card-body p {
            font-size: 1rem;
            line-height: 1.5;
        }
        .card-img-top {
            max-width: 100%;
            height: auto;
        }

        .card-body {
            padding: 10px;
            justify-content: flex-end;
        }

        .card-title {
            font-size: 23px;
            font-weight: bold;
        }

        .card-text {
            margin: 15px 0;
        }
        .row {
            display: flex;
            justify-content: space-evenly; 
            gap: 90px;
            align-items: center; 
        }
        table, th, td {
            border: 20px solid black;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!--<a class="navbar-brand" href="dashboard.php">
                <img src="#" alt="UNIQLOAN Logo" class="img-fluid"> 
            </a>-->
            <a>UNIQLOAN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user.php">Borrowers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="loan_plans.php">Loan Plans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Loan_types.php">Loan Types</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_loan.php">Add Loan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="LOGIN1.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
        <div>
        <img href="about.php" src="img/BANNER1.jpg" class="img-fluid" alt="...">
        </div>
        
    <div class="container mt-4">
        <h2 class="text-center"><!--____________________________________________________________________________________--></h2>
        <div data-aos="fade-right">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-black bg-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Loans</h5>
                        <p class="card-text fs-3"><?php echo $totalLoans; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-black bg-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Approved Loans</h5>
                        <p class="card-text fs-3"><?php echo $approveLoans; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-black bg-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Rejected Loans</h5>
                        <p class="card-text fs-3"><?php echo $activeLoans; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-black bg-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pending Loans</h5>
                        <p class="card-text fs-3"><?php echo $paidLoans; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <canvas id="loanChart"></canvas>
        
        
        <div class="card-body mt-50">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Borrower</th>
                        <th>Loan Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td>₱<?= htmlspecialchars($row['amount']) ?></td>
                            <td><span class="badge bg-success">Active</span></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
         
        <div class="clearfix">
            <img src="people.jpg" class="col-md-6 float-md-end mb-3 ms-md-3" alt="...">
            <p>At UNIQLOAN, your privacy and security are our top priorities. We use advanced encryption to protect your personal and financial information, keeping it safe from unauthorized access.</p>
            <p>We make sure that only trusted team members can access your data, and we never share it with anyone without your permission. Your information is always kept secure and private.</p>
            <p>To stay ahead of potential risks, we regularly update our security practices. With UNIQLOAN, you can be confident that your data is protected every step of the way.</p>
        </div>
    </div>
    <!-- card malapit sa footer-->
    <div class="container mt-4">
    <div class="row d-flex justify-content-center align-items-center mt-4">
    
    <div id="b1" class="card" style="width: 18rem;">
  <img src="img/banner2.jpg" class="card-img-top " alt="...">
  <div class="card-body ">
    <h5 class="card-title">LOAN TYPES</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="Loan_types.php" class="btn btn-dark stretched-link">Go somewhere</a>
  </div>
</div>
<div id="b2" class="card" style="width: 18rem;">
  <img src="img/banner3.jpg" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Free to browse</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="dashboard.php" class="btn btn-dark stretched-link">Go somewhere</a>
  </div>
</div>
<div id="b3" class="card" style="width: 18rem;">
  <img src="img/banner2.jpg" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">ADD LOAN</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="add_loan.php" class="btn btn-dark stretched-link">Go somewhere</a>
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
