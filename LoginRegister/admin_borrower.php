<?php
include('../includes/header.php');
$host = 'localhost';
$db = 'loan_management'; 
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch loan application data from the database
$query = "SELECT * FROM loan_applications"; 
$result = $conn->query($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'update') {
        // Handle the edit action
        $loan_id = intval($_POST['loan_id']);
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $loan_amount = $_POST['loan_amount'];
        $income = $_POST['income'];
        $loan_duration = $_POST['loan_duration'];
        $employment_status = $_POST['employment_status'];

        $stmt = $conn->prepare("UPDATE loan_applications SET name = ?, email = ?, phone = ?, address = ?, loan_amount = ?, income = ?, loan_duration = ?, employment_status = ? WHERE id = ?");
        $stmt->bind_param("ssssdsdsi", $name, $email, $phone, $address, $loan_amount, $income, $loan_duration, $employment_status, $loan_id);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>User information updated successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error updating user information: " . $conn->error . "</div>";
        }
        $stmt->close();
    } elseif ($_POST['action'] == 'approve' || $_POST['action'] == 'reject') {
        // Handle the approve/reject action
        $loan_id = intval($_POST['loan_id']);
        $status = ($_POST['action'] === 'approve') ? 'approved' : 'rejected';

        // Update loan status in the database
        $stmt = $conn->prepare("UPDATE loan_applications SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $loan_id);
        $stmt->execute();
        $stmt->close();

        // Redirect to refresh the page
        header("Location: admin_borrower.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Borrowers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>


<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white text-center">
            <h3>Borrowers' Status</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-warning">
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Loan Amount</th>
                        <th>Income</th>
                        <th>Loan Duration</th>
                        <th>Loan Type</th>
                        <th>Employment Status</th>
                        <th>Interest Rate</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['phone']) ?></td>
                            <td><?= htmlspecialchars($row['address']) ?></td>
                            <td><?= $row['loan_amount'] ? '₱' . htmlspecialchars($row['loan_amount']) : 'No Loan' ?></td>
                            <td><?= htmlspecialchars($row['income']) ?></td>
                            <td><?= htmlspecialchars($row['loan_duration']) ?> months</td>
                            <td><?= htmlspecialchars($row['loan_type']) ?></td>
                            <td><?= htmlspecialchars($row['employment_status']) ?></td>
                            <td><?= htmlspecialchars($row['interest_rate']) ?>%</td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="loan_id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                                    <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                                <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Borrower Information</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="admin_borrower.php">
                                                    <input type="hidden" name="loan_id" value="<?= $row['id'] ?>">
                                                    <!-- Form fields... -->
                                                    <button type="submit" name="action" value="update" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include('../includes/sidebar.php'); ?>
<?php include('../includes/script.php'); ?>
</html>