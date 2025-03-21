<?php
session_start();
require 'db.php'; 

// Check if the user is logged in
/*if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}*/

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['loan_id'], $_POST['action'])) {
    $loan_id = intval($_POST['loan_id']);
    $status = ($_POST['action'] === 'approve') ? 'approved' : 'rejected';

    $stmt = $conn->prepare("UPDATE loans SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $loan_id);
    $stmt->execute();
    $stmt->close();

    header("Location: user.php");
    exit();
}

$query = "SELECT loans.id AS loan_id, users.id AS user_id, users.username, loans.amount, loans.status 
          FROM users 
          JOIN loans ON users.id = loans.user_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowers' Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color:rgb(212, 212, 212); 
            color: rgb(0, 0, 0); 
        }
    </style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php"> Loan Management  Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="user.php">borrowers</a></li>
                    <li class="nav-item"><a class="nav-link" href="loan_plans.php">loan plans</a></li>
                    <li class="nav-item"><a class="nav-link" href="Loan_types.php">loan types</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_loan.php">add loan</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">logout</a></li>
                    <li class="nav-item"><a class="nav-link" href="calculator.php">calculator</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div>
        <img href="about.php" src="img/BANNER1.jpg" class="img-fluid" alt="...">
        </div>
        
            <div class="card-header bg-dark text-white text-center">
                <h3>Borrowers' Status</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Loan Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['user_id']) ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= $row['amount'] ? '$' . htmlspecialchars($row['amount']) : 'No Loan' ?></td>
                                <td>
                                    <?php 
                                    if (!$row['status']) {
                                        echo '<span class="badge bg-secondary">No Loan</span>';
                                    } elseif ($row['status'] == 'approved') {
                                        echo '<span class="badge bg-success">Approved</span>';
                                    } elseif ($row['status'] == 'pending') {
                                        echo '<span class="badge bg-warning text-dark">Pending</span>';
                                    } else {
                                        echo '<span class="badge bg-danger">Rejected</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 'pending'): ?>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="loan_id" value="<?= $row['loan_id'] ?>">
                                            <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="loan_id" value="<?= $row['loan_id'] ?>">
                                            <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <!--<div class="card-footer text-center">
                <a href="dashboard.php" class=""></a>
            </div>-->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
