<?php
session_start();
require '../db_file/db.php'; 

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


//$query = "SELECT * FROM loan_types";
//$result = $conn->query($query);
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php"> Loan Management  Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="adminhome.php">dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_borrower.php">borrowers</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="admin_calculator.php">calculator</a></li>
                    <li class="nav-item"><a class="nav-link" href="LOGIN1.php">logout</a></li>
                    
                </ul>
            </div>
        </div>
    </nav>
    <div class="card-header bg-primary text-white text-center">
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
        </div>
    </div>


    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h3>Loan Types</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Loan Type</th>
                            <th>Interest Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['type_name']) ?></td>
                                <td><?= htmlspecialchars($row['interest_rate']) ?>%</td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>