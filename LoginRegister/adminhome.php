<?php
/*session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}*/

include ('../db_file/db.php');
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
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style src="../stylekuno/admindashboard.css"></style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
        <h1 class="navbar-brand" href="dashboard.php"> Loan Management  Admin</h1>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="adminhome.php">dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_borrower.php">borrowers</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_calculator.php">calculator</a></li>
                    <li class="nav-item"><a class="nav-link" href="LOGIN1.php">logout</a></li>

                </ul>
            </div>
        </div>
    </nav>


    <div class="container mt-4">
        <h2 class="text-center"><!--____________________________________________________________________________________--></h2>
        <div data-aos="fade-right">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-black bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Loans</h5>
                        <p class="card-text fs-3"><?php echo $totalLoans; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-black bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Approved Loans</h5>
                        <p class="card-text fs-3"><?php echo $approveLoans; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-black bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Rejected Loans</h5>
                        <p class="card-text fs-3"><?php echo $activeLoans; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-black bg-primary mb-3">
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

        <script>
        const ctx = document.getElementById('loanChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Total Loans', 'Rejected Loans', 'Pending Loans', 'Approved Loans'],
                datasets: [{
                    label: 'UNIQLOAN Statistics',
                    data: [<?php echo $totalLoans; ?>, <?php echo $activeLoans; ?>, <?php echo $paidLoans; ?>, <?php echo $approveLoans; ?>],
                    backgroundColor: ['#06D001', '#06D001', '#06D001', '#06D001'],
                }]
            },
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</body>
</html>