<?php include('../../includes/header.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - UNIQLOAN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            background-color: white;
        }
        .form-header {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .form-step {
            display: none;
        }
        .form-step.active {
            display: block;
        }
        .btn-continue {
            background-color: #28a745;
            color: white;
            padding: 10px 30px;
            font-weight: bold;
        }
        .btn-skip {
            background-color: #6c757d;
            color: white;
            padding: 10px 30px;
            font-weight: bold;
        }
        .progress {
            height: 10px;
            margin-bottom: 30px;
        }
        .nav-tabs {
            display: none;
        }
        .gender-option {
            cursor: pointer;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-right: 10px;
        }
        .gender-option.active {
            border-color: #28a745;
            background-color: rgba(40, 167, 69, 0.1);
        }
        .privacy-notice {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <!-- Registration Form Container -->
    <div class="container my-5">
        <div class="form-container">
            <!-- Progress Bar -->
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <!-- Step 1: Phone & Email Registration -->
            <div class="form-step active" id="step1">
                <div class="form-header">
                    <h2>Registration</h2>
                    <p>Please add your phone & email so we match you with the best partners.</p>
                </div>
                
                <form>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="tel" placeholder="Phone Number" class="form-control" id="phoneNumber" value="">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" placeholder="Email" class="form-control" id="email" value="">
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="termsCheck">
                        <label class="form-check-label" for="termsCheck">
                            I have read and agree to the Terms and Conditions and the Privacy Policy.
                        </label>
                    </div>
                    <div class="d-grid">
                        <button type="button" class="btn btn-continue" onclick="nextStep(1, 2)">REGISTER</button>
                    </div>
                    <div class="privacy-notice">
                        By clicking 'Register' above, the customer confirms that he has read and agreed to Terms and Conditions and Privacy Policy of the company.
                    </div>
                </form>
            </div>

            <!-- Step 2: Personal Information -->
            <div class="form-step" id="step2">
                <div class="form-header">
                    <h2>Enter your name and age</h2>
                    <p>Your age will help us find better lender matches</p>
                </div>
                
                <form>
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" value="microholdosantos">
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="text" class="form-control" id="dob" value="April 2005">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Gender</label>
                        <div class="d-flex">
                            <div class="gender-option active" onclick="selectGender(this, 'male')">
                                <input type="radio" class="form-check-input" name="gender" id="male" checked>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="gender-option" onclick="selectGender(this, 'female')">
                                <input type="radio" class="form-check-input" name="gender" id="female">
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="button" class="btn btn-continue" onclick="nextStep(2, 3)">CONTINUE →</button>
                    </div>
                </form>
            </div>

            <!-- Step 3: Location Information -->
            <div class="form-step" id="step3">
                <div class="form-header">
                    <h2>In which city do you reside?</h2>
                    <p>Some of our lenders support only particular locations. Please choose yours.</p>
                </div>
                
                <form>
                    <div class="mb-4">
                        <label class="form-label">Region IV-A (CALABARZON)</label>
                        <div class="list-group">
                            <button type="button" class="list-group-item list-group-item-action" onclick="selectLocation(this)">Laguna</button>
                            <button type="button" class="list-group-item list-group-item-action" onclick="selectLocation(this)">Pagsanjan</button>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="button" class="btn btn-continue" onclick="nextStep(3, 4)">CONTINUE →</button>
                    </div>
                </form>
            </div>

            <!-- Step 4: Loan Purpose -->
            <div class="form-step" id="step4">
                <div class="form-header">
                    <h2>Loan Information</h2>
                    <p>By providing details about your desired loan, you enable us to design a loan package that's specifically tailored to your needs.</p>
                </div>
                
                <form>
                    <div class="mb-4">
                        <label class="form-label">Purpose of Loan</label>
                        <select class="form-select">
                            <option selected disabled>Select purpose</option>
                            <option>Home maintenance</option>
                            <option>Medical expenses</option>
                            <option>For My business</option>
                            <option>To pay off another loan</option>
                            <option>Payment for services</option>
                            <option>For purchase of electronics</option>
                            <option>Groceries and daily expenses</option>
                            <option>School expenses</option>
                            <option>For traveling</option>
                            <option>Unexpected expenses</option>
                            <option>Vehicle Purchase</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="button" class="btn btn-continue" onclick="nextStep(4, 5)">CONTINUE →</button>
                    </div>
                </form>
            </div>

            <!-- Step 5: ID Verification -->
            <div class="form-step" id="step5">
                <div class="form-header">
                    <h2>ID number/CCCD</h2>
                    <p>Please enter your ID number</p>
                </div>
                
                <form>
                    <div class="mb-3">
                        <label for="idNumber" class="form-label">ID Number</label>
                        <input type="text" class="form-control" id="idNumber" placeholder="034-24-008550">
                    </div>
                    <div class="privacy-notice">
                        <p>Your ID information will only be used for loan disbursement purposes and will be kept secure through our strict privacy and security measures. Your ID information will increase your chance of getting approved.</p>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-skip" onclick="skipStep()">SKIP →</button>
                        <button type="button" class="btn btn-continue" onclick="submitForm()">CONTINUE →</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include('../../includes/sidebar.php')?>
    <?php include('../../includes/footer.php')?>
    <?php include('../../includes/script.php')?>

</body>
</html>