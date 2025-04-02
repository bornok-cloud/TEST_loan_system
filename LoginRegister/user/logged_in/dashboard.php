<?php
    include('../authentication.php'); 

    $page_title = 'Dashboard';
    include('../../../includes/header_logged_in.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    
    <!-- <div class="container mt-3">
        <div class="card">
            <div class="card-header text-center">
                <h3>Dashboard</h3>
            </div>
            <div class="card-body text-center">
                <h5>Welcome! You Are Now Logged In.
                </h5>
            </div>
        </div>
    </div> -->


    <div class="container mt-2">
        <div class="progress mb-3">
            <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div id="validation-messages" class="alert alert-danger d-none"></div>
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="multi-step-form">
                    
                    <!-- Step 1: Personal Details -->
                    <fieldset class="step step-1">
                        <h5 class="text-center">Instant Cash Loan is on your Way</h5>
                        <h2 class="text-center">Personal Details</h2>

                        <!-- <div class="progress mb-3">
                            <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">Step 1 of 3</div>
                        </div> -->
                        
                        <div class="form-group">
                            
                            <!-- <input type="" id="full-name" class="form-control" placeholder="Full Name" required> -->
                            <div class="form-group">
                                <label for="full-name">Full Name</label>
                                <input type="text" id="full-name" class="form-control" value="<?= $_SESSION['auth_user']['username']; ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label for="contact-number">Contact Number</label>
                                <input type="text" id="contact-number" class="form-control" value="<?= $_SESSION['auth_user']['phone']; ?>" disabled>
                            </div>
                            
                        </div>
                        <!-- <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+63</span>
                                </div>
                                <input type="text" id="contact-number" class="form-control" placeholder="Contact Number" required>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <input type="date" id="dob" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <select id="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" id="next-step-1">Next</button>
                    </fieldset>

                    <!-- Step 2: Address & ID -->
                    <fieldset class="step step-2 d-none">
                        <h3 class="text-center">Address & Valid ID</h3>
                        <div class="form-group">
                            <input type="text" id="address" class="form-control" placeholder="Address" required>
                        </div>
                        <div class="form-group">
                            <input type="text" id="postal-code" class="form-control" placeholder="Postal Code" required>
                        </div>
                        <div class="form-group">
                            <select id="valid-id" class="form-control" required>
                                <option value="">Select Valid ID</option>
                                <option value="Driver’s License">Driver’s License</option>
                                <option value="Postal ID">Postal ID</option>
                                <option value="PWD ID">PWD ID Card</option>
                                <option value="Philippine Passport">Philippine Passport</option>
                                <option value="Senior Citizen ID">Senior Citizen’s ID</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ID Number</label>
                            <input type="text" id="id-number" class="form-control" placeholder="___-__-______" required>
                        </div>
                        <div class="mb-3">
                        <label for="formFile" class="form-label">Provide a Picture of Your Valid ID</label>
                        <input class="form-control" type="file" id="formFile">
                        </div>
                        <button type="button" class="btn btn-danger prev-step">Previous</button>
                        <button type="button" class="btn btn-primary" id="next-step-2">Next</button>
                    </fieldset>

                    <!-- Step 3: Loan Purpose -->
                    <fieldset class="step step-3 d-none">

            

                        <h3 class="text-center">Purpose of Loan</h3>
                        <div class="form-group">
                        <div class="form-group">
                            <label>Loan Amount</label>
                            <input type="text" id="id-number" class="form-control" placeholder="5000 - 100000" required>
                        </div>
                            <label for="loan-purpose">Purpose of Loan</label>
                            <select id="loan-purpose" class="form-control" required>
                                <option value="">Select Purpose</option>
                                <option value="Establishing Credit History">Establishing Credit History</option>
                                <option value="Home Maintenance">Home Maintenance</option>
                                <option value="Medical Expenses">Medical Expenses</option>
                                <option value="Business">Business</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-danger prev-step">Previous</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Multi-Step Form -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="userdashboard.js"></script>
    <?php include('../../../includes/sidebar.php'); ?>
    <?php include('../../../includes/script.php'); ?>

</body>
</html>
