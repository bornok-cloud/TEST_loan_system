<?php
//include('../includes/header.php');
$host = 'localhost';
$db = 'loan_system'; 
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM loan_applications ORDER BY id DESC"; 
$result = $conn->query($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'update') {
        $loan_id = intval($_POST['id']);
        $name = $conn->real_escape_string($_POST['full_name']);
        $phone = $conn->real_escape_string($_POST['contact_number']);
        $address = $conn->real_escape_string($_POST['address']);
        $vidtype = $conn->real_escape_string($_POST['valid_id_type']);
        $vidphoto = $conn->real_escape_string($_POST['id_photo_path']);
        $loan_amount = floatval($_POST['loan_amount']);
        $loanpurpose = $conn->real_escape_string($_POST['loan_purpose']);

        $stmt = $conn->prepare("UPDATE loan_applications SET 
            full_name = ?, 
            contact_number = ?, 
            address = ?, 
            valid_id_type = ?, 
            id_photo_path = ?, 
            loan_amount = ?, 
            loan_purpose = ? 
            WHERE id = ?");
        
        $stmt->bind_param("sssssdsi", $name, $phone, $address, $vidtype, $vidphoto, $loan_amount, $loanpurpose, $loan_id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "<div class='alert alert-success'>Loan application updated successfully.</div>";
        } else {
            $_SESSION['message'] = "<div class='alert alert-danger'>Error updating application: " . $conn->error . "</div>";
        }
        $stmt->close();
        header("Location: admin_borrower.php");
        exit();
    } elseif ($_POST['action'] == 'approve' || $_POST['action'] == 'reject') {
        $loan_id = intval($_POST['loan_id']);
        $status = ($_POST['action'] === 'approve') ? 'Approved' : 'Rejected';

        $stmt = $conn->prepare("UPDATE loan_applications SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $loan_id);
        $stmt->execute();
        $stmt->close();

        $_SESSION['message'] = "<div class='alert alert-success'>Application has been $status.</div>";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .img-thumbnail {
            max-width: 150px;
            max-height: 120px;
            object-fit: contain;
        }
        .view-image-modal-img {
            max-width: 100%;
            max-height: 80vh;
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
                    <li class="nav-item "><a class="nav-link" href="adminhome.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Loans Plans</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                    <li class="nav-item">
                        <a class="btn btn-danger ms-4" href="#">Payment</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="btn btn-outline-dark toggle ms-1" href="../LoginRegister/user/login.php" role="button">Log out</a>
                        
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="container mt-5">
    <?php if (isset($_SESSION['message'])): ?>
        <?= $_SESSION['message'] ?>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    
    <div class="card shadow">
        <div class="card-header bg-danger text-white text-center">
            <h3>Loan Applications</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Reference Number</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>ID Type</th>                           
                            <th>Loan Amount</th>
                            <th>Purpose</th>
                            <th>Collateral Type</th>
                            <th>Collateral Loan Details</th>
                            <th>Proof of Ownership</th>
                            <th>Collateral Estimated Value</th>
                            <th>Collateral Image</th>
                            <th>Valid ID Image</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['reference_number']) ?></td>
                                <td><?= htmlspecialchars($row['full_name']) ?></td>
                                <td><?= htmlspecialchars($row['contact_number']) ?></td>
                                <td><?= htmlspecialchars($row['dob']) ?></td>
                                <td><?= htmlspecialchars($row['gender']) ?></td>
                                <td><?= htmlspecialchars($row['address']) ?>, <?= htmlspecialchars($row['postal_code']) ?></td>
                                <td><?= htmlspecialchars($row['valid_id_type']) ?>: <?= htmlspecialchars($row['id_number']) ?></td>
                                <td>₱<?= number_format($row['loan_amount'], 2) ?></td>
                                <td><?= htmlspecialchars($row['loan_purpose']) ?></td>
                                <td><?= htmlspecialchars($row['type_of_collateral']) ?></td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                <td><?= htmlspecialchars($row['proof_of_ownership']) ?></td>
                                <td><?= htmlspecialchars($row['estimated_value']) ?></td>
                                <td>
                                    <?php if (!empty($row['collateral_image'])): ?>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal<?= $row['id'] ?>_collateral">
                                            <img src="../<?= htmlspecialchars($row['collateral_image']) ?>" alt="Collateral" class="img-thumbnail">
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">No image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($row['id_photo_path'])): ?>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal<?= $row['id'] ?>_id">
                                            <img src="../<?= htmlspecialchars($row['id_photo_path']) ?>" alt="ID Photo" class="img-thumbnail">
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">No image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge 
                                        <?= $row['status'] == 'Approved' ? 'bg-success' : 
                                           ($row['status'] == 'Rejected' ? 'bg-danger' : 'bg-warning') ?>">
                                        <?= htmlspecialchars($row['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= date('M d, Y h:i A', strtotime($row['application_date'])) ?>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-2">
                                        <!-- Edit Button -->
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        
                                        <!-- Action Buttons -->
                                        <div class="d-flex gap-1">
                                            <form method="POST" class="flex-grow-1">
                                                <input type="hidden" name="loan_id" value="<?= $row['id'] ?>">
                                                <button type="submit" name="action" value="approve" class="btn btn-success btn-sm w-100" 
                                                    <?= $row['status'] == 'Approved' ? 'disabled' : '' ?>>
                                                    <i class="bi bi-check-circle"></i> Approve
                                                </button>
                                            </form>
                                            <form method="POST" class="flex-grow-1">
                                                <input type="hidden" name="loan_id" value="<?= $row['id'] ?>">
                                                <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm w-100"
                                                    <?= $row['status'] == 'Rejected' ? 'disabled' : '' ?>>
                                                    <i class="bi bi-x-circle"></i> Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Collateral Image Modal -->
                            <div class="modal fade" id="imageModal<?= $row['id'] ?>_collateral" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Collateral Image</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="../<?= htmlspecialchars($row['collateral_image']) ?>" alt="Collateral" class="view-image-modal-img">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- ID Image Modal -->
                            <div class="modal fade" id="imageModal<?= $row['id'] ?>_id" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">ID Photo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="../<?= htmlspecialchars($row['id_photo_path']) ?>" alt="ID Photo" class="view-image-modal-img">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Application #<?= $row['id'] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST">
                                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                <input type="hidden" name="id_photo_path" value="<?= htmlspecialchars($row['id_photo_path']) ?>">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Full Name</label>
                                                    <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($row['full_name']) ?>" required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Contact Number</label>
                                                    <input type="text" class="form-control" name="contact_number" value="<?= htmlspecialchars($row['contact_number']) ?>" required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Address</label>
                                                    <textarea class="form-control" name="address" required><?= htmlspecialchars($row['address']) ?></textarea>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">ID Type</label>
                                                    <input type="text" class="form-control" name="valid_id_type" value="<?= htmlspecialchars($row['valid_id_type']) ?>" required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Loan Amount</label>
                                                    <input type="number" step="0.01" class="form-control" name="loan_amount" value="<?= $row['loan_amount'] ?>" required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Loan Purpose</label>
                                                    <input type="text" class="form-control" name="loan_purpose" value="<?= htmlspecialchars($row['loan_purpose']) ?>" required>
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="action" value="update" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include('../includes/admin_sidebar.php'); ?>
<?php include('../includes/script.php'); ?>
</html>
<?php $conn->close(); ?>