<?php
 include('../includes/admin_header.php'); 
$host = 'localhost';
$db = 'loan_management'; 
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$totalLoans = $conn->query("SELECT COUNT(*) as count FROM loan_applications")->fetch_assoc()['count'];
$activeLoans = $conn->query("SELECT COUNT(*) as count FROM loan_applications WHERE status='rejected'")->fetch_assoc()['count'];
$paidLoans = $conn->query("SELECT COUNT(*) as count FROM loan_applications WHERE status='pending'")->fetch_assoc()['count'];
$approveLoans = $conn->query("SELECT COUNT(*) as count FROM loan_applications WHERE status='approved'")->fetch_assoc()['count'];

// Fetch the loan details including statuses (joining the users table in the LoanManagement database)
$query = "SELECT loan_type, loan_amount, status, name 
          FROM loan_management.loan_applications 
          JOIN Loan_Management.users ON loan_applications.name = name
          WHERE loan_applications.status = 'approved'
          GROUP BY name"; 
$result = mysqli_query($conn,$query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style src="../stylekuno/admindashboard.css"></style>
</head>
<body>
<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <h1 class="navbar-brand" href="dashboard.php"> Loan Management Admin</h1>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="adminhome.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_borrower.php">Borrowers</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_calculator.php">Calculator</a></li>
                <li class="nav-item"><a class="nav-link" href="LOGIN1.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav> -->

<div class="container mt-4">
    <h2 class="text-center">Loan Statistics</h2>

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
    
    <div class="card-body mt-4">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Loan Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>₱<?= htmlspecialchars($row['loan_amount']) ?></td>
                        <td><span class="badge bg-success"><?= htmlspecialchars($row['status']) ?></span></td>
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
                    label: 'Loan Statistics',
                    data: [<?php echo $totalLoans; ?>, <?php echo $activeLoans; ?>, <?php echo $paidLoans; ?>, <?php echo $approveLoans; ?>],
                    backgroundColor: ['#06D001', '#FF6347', '#FFD700', '#32CD32'],
                }]
            },
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</body>
<?php include('../includes/admin_sidebar.php'); ?>
<?php include('../includes/script.php'); ?>
</html>

<?php
$conn->close();
?>
