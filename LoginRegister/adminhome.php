<?php
include('../includes/admin_header.php'); 

// Connect to the correct database (loan_system instead of loan_management)
$host = 'localhost';
$db = 'loan_system';  // Changed from loan_management to loan_system
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Count queries - all pointing to loan_system database
$totalLoans = $conn->query("SELECT COUNT(*) as count FROM loan_applications")->fetch_assoc()['count'];
$activeLoans = $conn->query("SELECT COUNT(*) as count FROM loan_applications WHERE status='rejected'")->fetch_assoc()['count'];
$paidLoans = $conn->query("SELECT COUNT(*) as count FROM loan_applications WHERE status='pending'")->fetch_assoc()['count'];
$approveLoans = $conn->query("SELECT COUNT(*) as count FROM loan_applications WHERE status='approved'")->fetch_assoc()['count'];

// Fetch loan details - simplified to use the correct database
$query = "SELECT full_name as name, loan_amount, status 
          FROM loan_applications 
          WHERE status = 'approved'";
$result = $conn->query($query);
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

<div class="container mt-4">
    <h2 class="text-center">Loan Statistics</h2>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-black bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Loans</h5>
                    <p class="card-text fs-3"><?php echo $totalLoans; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-black bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Approved Loans</h5>
                    <p class="card-text fs-3"><?php echo $approveLoans; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-black bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Rejected Loans</h5>
                    <p class="card-text fs-3"><?php echo $activeLoans; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-black bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pending Loans</h5>
                    <p class="card-text fs-3"><?php echo $paidLoans; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <canvas id="loanChart" height="200"></canvas>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            <h4>Approved Loans</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
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
                                <td>₱<?= number_format($row['loan_amount'], 2) ?></td>
                                <td><span class="badge bg-success"><?= ucfirst(htmlspecialchars($row['status'])) ?></span></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Enhanced chart with better styling
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('loanChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Loans', 'Approved', 'Rejected', 'Pending'],
                datasets: [{
                    label: 'Loan Statistics',
                    data: [
                        <?php echo $totalLoans; ?>,
                        <?php echo $approveLoans; ?>,
                        <?php echo $activeLoans; ?>,
                        <?php echo $paidLoans; ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Loan Application Statistics',
                        font: {
                            size: 16
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include('../includes/admin_sidebar.php'); ?>
<?php include('../includes/script.php'); ?>
</html>

<?php
$conn->close();
?>