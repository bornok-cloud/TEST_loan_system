<?php
/*session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}*/

require 'db.php';

$success = $error = "";

$borrowers_query = "SELECT id, username FROM users";
$borrowers_result = $conn->query($borrowers_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = intval($_POST['user_id']);
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    $interest = isset($_POST['interest']) ? floatval($_POST['interest']) : 0;
    $duration = isset($_POST['duration']) ? intval($_POST['duration']) : 0;
    $status = 'pending'; 

    if ($user_id > 0 && $amount > 0 && $interest >= 0 && $duration > 0) {
        $stmt = $conn->prepare("INSERT INTO loans (user_id, amount, interest_rate, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("idds", $user_id, $amount, $interest, $status);
        
        if ($stmt->execute()) {
            $success = "Loan added successfully!";
        } else {
            $error = "Error adding loan.";
        }
        $stmt->close();
    } else {
        $error = "All fields are required and must be valid values.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Loan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background-color:rgb(212, 212, 212); 
            color: rgb(0, 0, 0);
        }
        .card {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"> Loan Management  Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="user.php">Borrowers</a></li>
                    <li class="nav-item"><a class="nav-link" href="loan_plans.php">Loan Plans</a></li>
                    <li class="nav-item"><a class="nav-link" href="Loan_types.php">Loan Types</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_loan.php">Add Loan</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="card">
            <h3 class="text-center">Add Loan</h3>
            <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
            <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Borrower</label>
                    <select class="form-control" name="user_id" required>
                        <option value="">Select Borrower</option>
                        <?php while ($borrower = $borrowers_result->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($borrower['id']) ?>">
                                <?= htmlspecialchars($borrower['username']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Loan Amount (₱)</label>
                    <input type="number" class="form-control" name="amount" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Interest Rate (%)</label>
                    <input type="number" class="form-control" name="interest" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Duration (Months)</label>
                    <input type="number" class="form-control" name="duration" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>
                        <!-- application form para sa user--- Bootstrap-->
                        <!--<form class="row g-3">
  <div class="col-md-4">
    <label for="validationDefault01" class="form-label">First name</label>
    <input type="text" class="form-control" id="validationDefault01" value="Mark" required>
  </div>
  <div class="col-md-4">
    <label for="validationDefault02" class="form-label">Last name</label>
    <input type="text" class="form-control" id="validationDefault02" value="Otto" required>
  </div>
  <div class="col-md-4">
    <label for="validationDefaultUsername" class="form-label">Username</label>
    <div class="input-group">
      <span class="input-group-text" id="inputGroupPrepend2">@</span>
      <input type="text" class="form-control" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
    </div>
  </div>
  <div class="col-md-6">
    <label for="validationDefault03" class="form-label">City</label>
    <input type="text" class="form-control" id="validationDefault03" required>
  </div>
  <div class="col-md-3">
    <label for="validationDefault04" class="form-label">State</label>
    <select class="form-select" id="validationDefault04" required>
      <option selected disabled value="">Choose...</option>
      <option>...</option>
    </select>
  </div>
  <div class="col-md-3">
    <label for="validationDefault05" class="form-label">Zip</label>
    <input type="text" class="form-control" id="validationDefault05" required>
  </div>
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
      <label class="form-check-label" for="invalidCheck2">
        Agree to terms and conditions
      </label>
    </div>
  </div>
  <div class="col-12">
    <button class="btn btn-primary" type="submit">Submit form</button>
  </div>
</form>-->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
