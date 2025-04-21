<?php
    include('../authentication.php'); 
    $page_title = 'Loan Application';
    include('../../../includes/header_logged_in.php'); 
    include('../../../db_file/db_connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Professional Stepper Styles */
        .stepper-container {
            width: 80%;
            padding: 1rem 0;
            margin: 0 auto;
        }
        
        .stepper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin: 0 auto 1rem;
            counter-reset: step;
        }
        
        .stepper::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #e0e0e0;
            z-index: 1;
            transform: translateY(-50%);
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        
        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #e0e0e0;
            color: #9e9e9e;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 600;
            margin-bottom: 8px;
            border: 3px solid #e0e0e0;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        
        .step.active .step-circle {
            background-color: #fff;
            border-color: #0d6efd;
            color: #0d6efd;
        }
        
        .step.completed .step-circle {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }
        
        .step-label {
            font-size: 14px;
            color: #9e9e9e;
            text-align: center;
            max-width: 100px;
        }
        
        .step.active .step-label {
            color: #0d6efd;
            font-weight: 500;
        }
        
        .step.completed .step-label {
            color: #424242;
        }
        
        /* Form Styles */
        .step-form {
            display: none;
        }
        
        .step-form.active {
            display: block;
        }
        
        /* Validation Styles */
        .validation-message {
            display: none;
            margin-bottom: 20px;
        }
        
        /* Terms and Conditions Styles */
        .terms-container {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        
        .terms-checkbox {
            margin-bottom: 15px;
        }
        
        /* Loan Calculation Styles */
        .loan-summary {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .loan-summary p {
            margin-bottom: 5px;
        }
        
        .loan-summary .value {
            font-weight: bold;
            color: #0d6efd;
        }
        
        /* Collateral Styles */
        .collateral-card {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }
        
        .collateral-card h5 {
            margin-bottom: 15px;
        }
        
        .collateral-image-preview {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .stepper-container {
                width: 100%;
            }
            
            .step-label {
                font-size: 12px;
                max-width: 80px;
            }
            
            .step-circle {
                width: 28px;
                height: 28px;
                font-size: 14px;
            }
            
            .terms-container {
                max-height: 150px;
            }
        }
        
        /* Input validation error */
        .is-invalid {
            border-color: #dc3545 !important;
        }
        
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        
        .is-valid {
            border-color: #28a745 !important;
        }
    </style>
</head>
<body>
    <div class="container mt-3">
        <?php
        if(isset($_SESSION['message'])) {
            $message_type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'danger';
        ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
        ?>
        <div id="validation-message" class="alert alert-danger validation-message"></div>
        
        <!-- Professional Stepper -->
        <div class="stepper-container">
            <div class="stepper">
                <!-- Step 1 -->
                <div class="step completed" data-step="1">
                    <div class="step-circle">1</div>
                    <div class="step-label">Personal Details</div>
                </div>
                
                <!-- Step 2 -->
                <div class="step" data-step="2">
                    <div class="step-circle">2</div>
                    <div class="step-label">Address & ID</div>
                </div>
                
                <!-- Step 3 -->
                <div class="step" data-step="3">
                    <div class="step-circle">3</div>
                    <div class="step-label">Loan Details</div>
                </div>
                
                <!-- Step 4 (New Collateral Step) -->
                <div class="step" data-step="4">
                    <div class="step-circle">4</div>
                    <div class="step-label">Collateral</div>
                </div>
                
                <!-- Step 5 -->
                <div class="step" data-step="5">
                    <div class="step-circle">5</div>
                    <div class="step-label">Terms</div>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form id="multi-step-form" action="process_loan_application.php" method="POST" enctype="multipart/form-data">
                    <!-- Step 1: Personal Details -->
                    <fieldset class="step-form active mt-0" id="step-1">
                        <h5 class="text-center">Instant Cash Loan is on your Way</h5>
                        <h2 class="text-center">Personal Details</h2>
                        
                        <div class="form-group">
                            <div class="form-group">
                                <label for="full-name">Full Name</label>
                                <input type="text" id="full-name" name="full_name" class="form-control" value="<?= $_SESSION['auth_user']['username']; ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="contact-number">Contact Number</label>
                                <input type="text" id="contact-number" name="contact_number" class="form-control" value="<?= $_SESSION['auth_user']['phone']; ?>" readonly>
                            </div>
                            
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob" name="dob" class="form-control" required>
                                <div class="invalid-feedback">Please enter a valid date of birth (you must be at least 21 years old).</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender" class="form-control" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <div class="invalid-feedback">Please select your gender.</div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary" id="next-step-1">Next</button>
                        </div>
                    </fieldset>

                    <!-- Step 2: Address & ID -->
                    <fieldset class="step-form" id="step-2">
                        <h3 class="text-center">Address & Valid ID</h3>
                        
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="Complete Address" required>
                            <div class="invalid-feedback">Please enter your complete address.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="postal-code">Postal Code</label>
                            <input type="text" id="postal-code" name="postal_code" class="form-control" placeholder="Postal Code" required>
                            <div class="invalid-feedback">Please enter a valid 4-digit postal code.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="valid-id">Valid ID Type</label>
                            <select id="valid-id" name="valid_id_type" class="form-control" required>
                                <option value="">Select Valid ID</option>
                                <option value="Driver's License">Driver's License</option>
                                <option value="Postal ID">Postal ID</option>
                                <option value="PWD ID">PWD ID Card</option>
                                <option value="Philippine Passport">Philippine Passport</option>
                                <option value="Senior Citizen ID">Senior Citizen's ID</option>
                            </select>
                            <div class="invalid-feedback">Please select a valid ID type.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="id-number">ID Number</label>
                            <input type="text" id="id-number" name="id_number" class="form-control" placeholder="___-__-______" required>
                            <div class="invalid-feedback">ID number should contain only numbers and dashes.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="id-photo" class="form-label">Upload Valid ID (Front)</label>
                            <input class="form-control" type="file" id="id-photo" name="id_photo" accept="image/*,.pdf" required>
                            <div class="invalid-feedback">Please upload a valid ID (image or PDF).</div>
                            <small class="form-text text-muted">Accepted formats: JPG, PNG, PDF (Max 5MB)</small>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-danger prev-step">Previous</button>
                            <button type="button" class="btn btn-primary" id="next-step-2">Next</button>
                        </div>
                    </fieldset>

                    <!-- Step 3: Loan Details -->
                    <fieldset class="step-form" id="step-3">
                        <h3 class="text-center">Loan Details</h3>
                        
                        <div class="form-group">
                            <label for="loan-amount">Loan Amount (PHP)</label>
                            <input type="number" id="loan-amount" name="loan_amount" class="form-control" placeholder="5000 - 100000" min="5000" max="100000" required>
                            <div class="invalid-feedback">Please enter a valid amount between ₱5,000 and ₱100,000.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="loan-term">Loan Term (Months)</label>
                            <select id="loan-term" name="loan_term" class="form-control" required>
                                <option value="">Select Loan Term</option>
                                <option value="3">3 Months</option>
                                <option value="6">6 Months</option>
                                <option value="12">12 Months</option>
                                <option value="24">24 Months</option>
                            </select>
                            <div class="invalid-feedback">Please select a loan term.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="loan-purpose">Purpose of Loan</label>
                            <select id="loan-purpose" name="loan_purpose" class="form-control" required>
                                <option value="">Select Purpose</option>
                                <option value="Home Maintenance">Home Maintenance</option>
                                <option value="Medical Expenses">Medical Expenses</option>
                                <option value="Business">Business Capital</option>
                                <option value="Auto">Auto Loan</option>
                                <option value="Home">Home Loan</option>
                                <option value="Appliance">Home Appliance</option>
                            </select>
                            <div class="invalid-feedback">Please select a loan purpose.</div>
                        </div>
                        
                        <!-- Loan Calculation Summary -->
                        <div class="loan-summary mt-4">
                            <h5 class="text-center mb-3">Loan Summary</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Principal Amount:</p>
                                    <p>Interest Rate (Annual):</p>
                                    <p>Loan Term:</p>
                                    <p>Total Interest:</p>
                                    <p>Total Repayment:</p>
                                    <p>Monthly Payment:</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <p class="value" id="display-principal">₱0.00</p>
                                    <p class="value">5%</p>
                                    <p class="value" id="display-term">0 Months</p>
                                    <p class="value" id="display-total-interest">₱0.00</p>
                                    <p class="value" id="display-total-repayment">₱0.00</p>
                                    <p class="value" id="display-monthly-payment">₱0.00</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-danger prev-step">Previous</button>
                            <button type="button" class="btn btn-primary" id="next-step-3">Next</button>
                        </div>
                    </fieldset>
                    
                    <!-- Step 4: Collateral Information -->
                    <fieldset class="step-form" id="step-4">
                        <h3 class="text-center">Collateral Information</h3>
                        <p class="text-center text-muted mb-4">Please provide details about the collateral you're offering for this loan</p>
                        
                        <div class="collateral-card">
                            <div class="form-group">
                                <label for="collateral-type">Type of Collateral</label>
                                <select id="collateral-type" name="collateral_type" class="form-control" required>
                                    <option value="">Select Collateral Type</option>
                                    <option value="Real Estate">Real Estate Property</option>
                                    <option value="Vehicle">Vehicle</option>
                                    <option value="Jewelry">Jewelry</option>
                                    <option value="Electronics">High-value Electronics</option>
                                    <option value="Other">Other Valuables</option>
                                </select>
                                <div class="invalid-feedback">Please select a collateral type.</div>
                            </div>
                            
                            <div class="form-group mt-3">
                                <label for="collateral-description">Description</label>
                                <textarea id="collateral-description" name="collateral_description" class="form-control" rows="3" placeholder="Provide detailed description including make, model, year, condition, etc." required></textarea>
                                <div class="invalid-feedback">Please provide a detailed description of your collateral.</div>
                            </div>
                            
                            <div class="form-group mt-3">
                                <label for="collateral-value">Estimated Value (PHP)</label>
                                <input type="number" id="collateral-value" name="collateral_value" class="form-control" placeholder="Estimated market value" min="1000" required>
                                <div class="invalid-feedback">Please provide a valid estimated value (minimum ₱1,000).</div>
                            </div>
                            
                            <div class="form-group mt-3">
                                <label for="collateral-ownership">Proof of Ownership</label>
                                <select id="collateral-ownership" name="collateral_ownership" class="form-control" required>
                                    <option value="">Select Proof of Ownership</option>
                                    <option value="Title Deed">Title Deed</option>
                                    <option value="OR/CR">Official Receipt/Certificate of Registration</option>
                                    <option value="Sales Invoice">Sales Invoice</option>
                                    <option value="Other">Other Document</option>
                                </select>
                                <div class="invalid-feedback">Please select proof of ownership.</div>
                            </div>
                            
                            <div class="form-group mt-3">
                                <label for="collateral-images" class="form-label">Upload Collateral Images</label>
                                <input class="form-control" type="file" id="collateral-images" name="collateral_images[]" accept="image/*" multiple required>
                                <div class="invalid-feedback">Please upload at least one clear image of the collateral.</div>
                                <small class="form-text text-muted">Upload clear photos from different angles (Max 5MB per image)</small>
                                
                                <div id="collateral-preview-container" class="mt-2"></div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-danger prev-step">Previous</button>
                            <button type="button" class="btn btn-primary" id="next-step-4">Next</button>
                        </div>
                    </fieldset>
                    
                    <!-- Step 5: Terms and Conditions -->
                    <fieldset class="step-form" id="step-5">
                        <h3 class="text-center">Terms and Conditions</h3>
                        
                        <div class="terms-container">
                            <h5>Loan Terms and Conditions</h5>
                            <p><strong>1. Loan Agreement:</strong> By submitting this application, you agree to the terms and conditions outlined herein.</p>
                            <p><strong>2. Interest Rate:</strong> A fixed annual interest rate of 5% will be applied to your loan.</p>
                            <p><strong>3. Repayment:</strong> You agree to repay the loan amount plus interest according to the agreed schedule.</p>
                            <p><strong>4. Late Payments:</strong> Late payments will incur additional fees as specified in the loan agreement.</p>
                            <p><strong>5. Default:</strong> Failure to repay may result in legal action and affect your credit score.</p>
                            <p><strong>6. Collateral:</strong> The collateral provided may be seized if you default on your loan payments.</p>
                            <p><strong>7. Data Privacy:</strong> We collect and process your personal data in accordance with our Privacy Policy.</p>
                            <p><strong>8. Approval:</strong> Loan approval is subject to verification of your information and credit assessment.</p>
                            <p><strong>9. Changes:</strong> We reserve the right to modify these terms with prior notice.</p>
                        </div>
                        
                        <div class="form-check terms-checkbox">
                            <input class="form-check-input" type="checkbox" id="agree-terms" name="agree_terms" required>
                            <label class="form-check-label" for="agree-terms">
                                I have read and agree to the Terms and Conditions
                            </label>
                            <div class="invalid-feedback">You must agree to the terms and conditions to proceed.</div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-danger prev-step">Previous</button>
                            <button type="submit" class="btn btn-success" id="submit-application">Submit Application</button>
                        </div>
                    </fieldset>
                    
                    <!-- Hidden field to track current step -->
                    <input type="hidden" name="current_step" id="current-step" value="1">
                    <!-- Hidden field for interest rate -->
                    <input type="hidden" name="interest_rate" value="5">
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Constants
            const INTEREST_RATE = 0.05; // 5% annual interest rate
            
            let currentStep = 1;
            const totalSteps = 5;
            
            // Initialize stepper and loan calculation
            updateStepper(currentStep);
            calculateLoan();
            
            // Update stepper UI
            function updateStepper(step) {
                $('.step').each(function() {
                    const stepNumber = parseInt($(this).data('step'));
                    
                    $(this).removeClass('active completed');
                    
                    if (stepNumber < step) {
                        $(this).addClass('completed');
                    } else if (stepNumber === step) {
                        $(this).addClass('active');
                    }
                });
            }
            
            // Show validation error
            function showValidation(message) {
                $('#validation-message').text(message).fadeIn();
                setTimeout(() => $('#validation-message').fadeOut(), 5000);
            }
            
            // Hide validation error
            function clearValidation() {
                $('#validation-message').fadeOut();
            }
            
            // Clear all invalid feedback
            function clearAllInvalid() {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').hide();
            }
            
            // Format currency
            function formatCurrency(amount) {
                return '₱' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }
            
            // Calculate and display loan details
            function calculateLoan() {
                const amount = parseFloat($('#loan-amount').val()) || 0;
                const term = parseInt($('#loan-term').val()) || 0;
                
                // Calculate monthly interest rate (5% annual divided by 12 months)
                const monthlyInterestRate = INTEREST_RATE / 12;
                
                // Calculate total interest
                const totalInterest = amount * monthlyInterestRate * term;
                
                // Calculate total repayment
                const totalRepayment = amount + totalInterest;
                
                // Calculate monthly payment
                const monthlyPayment = term > 0 ? totalRepayment / term : 0;
                
                // Update display
                $('#display-principal').text(formatCurrency(amount));
                $('#display-term').text(term + ' Months');
                $('#display-total-interest').text(formatCurrency(totalInterest));
                $('#display-total-repayment').text(formatCurrency(totalRepayment));
                $('#display-monthly-payment').text(formatCurrency(monthlyPayment));
            }
            
            // Preview collateral images
            $('#collateral-images').on('change', function() {
                const files = this.files;
                const container = $('#collateral-preview-container');
                container.empty();
                
                if (files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        if (file.type.match('image.*')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                container.append(
                                    '<div class="mb-2">' +
                                    '<img src="' + e.target.result + '" class="collateral-image-preview img-thumbnail" style="display: block; max-width: 200px; max-height: 150px;">' +
                                    '<small>' + file.name + ' (' + Math.round(file.size / 1024) + 'KB)</small>' +
                                    '</div>'
                                );
                                $('.collateral-image-preview').fadeIn();
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                }
            });
            
            // Recalculate when amount or term changes
            $('#loan-amount, #loan-term').on('input change', function() {
                calculateLoan();
                
                // Also validate the fields
                if ($(this).attr('id') === 'loan-amount') {
                    const val = parseFloat($(this).val());
                    if (!isNaN(val) && val >= 5000 && val <= 100000) {
                        $(this).removeClass('is-invalid').addClass('is-valid');
                    } else {
                        $(this).removeClass('is-valid');
                    }
                }
            });
            
            // Auto-format ID number
            $('#id-number').on('input', function() {
                let val = $(this).val().replace(/[^0-9-]/g, '');
                $(this).val(val);
                
                if (/^[0-9-]+$/.test(val)) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid');
                }
            });
            
            // Validate step 1
            function validateStep1() {
                let isValid = true;
                clearAllInvalid();
                
                const dob = new Date($('#dob').val());
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const monthDiff = today.getMonth() - dob.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                
                if (!$('#dob').val()) {
                    $('#dob').addClass('is-invalid');
                    $('#dob').next('.invalid-feedback').show();
                    isValid = false;
                } else if (age < 21) {
                    $('#dob').addClass('is-invalid');
                    $('#dob').next('.invalid-feedback').text('You must be at least 21 years old to apply.').show();
                    isValid = false;
                }
                
                if (!$('#gender').val()) {
                    $('#gender').addClass('is-invalid');
                    $('#gender').next('.invalid-feedback').show();
                    isValid = false;
                }
                
                return isValid;
            }
            
            // Validate step 2
            function validateStep2() {
                let isValid = true;
                clearAllInvalid();
                
                const postalCode = $('#postal-code').val().trim();
                const idNumber = $('#id-number').val().trim();
                const postalCodePattern = /^\d{4}$/;
                const idNumberPattern = /^[0-9-]+$/;
                const fileInput = $('#id-photo')[0];
                
                if (!$('#address').val()) {
                    $('#address').addClass('is-invalid');
                    $('#address').next('.invalid-feedback').show();
                    isValid = false;
                }
                
                if (!postalCode) {
                    $('#postal-code').addClass('is-invalid');
                    $('#postal-code').next('.invalid-feedback').show();
                    isValid = false;
                } else if (!postalCodePattern.test(postalCode)) {
                    $('#postal-code').addClass('is-invalid');
                    $('#postal-code').next('.invalid-feedback').text('Please enter a valid 4-digit postal code.').show();
                    isValid = false;
                }
                
                if (!$('#valid-id').val()) {
                    $('#valid-id').addClass('is-invalid');
                    $('#valid-id').next('.invalid-feedback').show();
                    isValid = false;
                }
                
                if (!idNumber) {
                    $('#id-number').addClass('is-invalid');
                    $('#id-number').next('.invalid-feedback').show();
                    isValid = false;
                } else if (!idNumberPattern.test(idNumber)) {
                    $('#id-number').addClass('is-invalid');
                    $('#id-number').next('.invalid-feedback').text('ID number should contain only numbers and dashes.').show();
                    isValid = false;
                }
                
                if (!fileInput.files || fileInput.files.length === 0) {
                    $('#id-photo').addClass('is-invalid');
                    $('#id-photo').next('.invalid-feedback').show();
                    isValid = false;
                } else {
                    const file = fileInput.files[0];
                    const validTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                    const maxSize = 5 * 1024 * 1024; // 5MB
                    
                    if (!validTypes.includes(file.type)) {
                        $('#id-photo').addClass('is-invalid');
                        $('#id-photo').next('.invalid-feedback').text('Please upload a valid file type (JPG, PNG, or PDF).').show();
                        isValid = false;
                    } else if (file.size > maxSize) {
                        $('#id-photo').addClass('is-invalid');
                        $('#id-photo').next('.invalid-feedback').text('File size must be less than 5MB.').show();
                        isValid = false;
                    }
                }
                
                return isValid;
            }
            
            // Validate step 3
            function validateStep3() {
                let isValid = true;
                clearAllInvalid();
                
                const loanAmount = parseFloat($('#loan-amount').val());
                const loanTerm = $('#loan-term').val();
                
                if (!loanAmount || isNaN(loanAmount)) {
                    $('#loan-amount').addClass('is-invalid');
                    $('#loan-amount').next('.invalid-feedback').show();
                    isValid = false;
                } else if (loanAmount < 5000 || loanAmount > 100000) {
                    $('#loan-amount').addClass('is-invalid');
                    $('#loan-amount').next('.invalid-feedback').text('Please enter a valid amount between ₱5,000 and ₱100,000.').show();
                    isValid = false;
                }
                
                if (!loanTerm) {
                    $('#loan-term').addClass('is-invalid');
                    $('#loan-term').next('.invalid-feedback').show();
                    isValid = false;
                }
                
                if (!$('#loan-purpose').val()) {
                    $('#loan-purpose').addClass('is-invalid');
                    $('#loan-purpose').next('.invalid-feedback').show();
                    isValid = false;
                }
                
                return isValid;
            }
            
            // Validate step 4 (Collateral)
            function validateStep4() {
                let isValid = true;
                clearAllInvalid();
                
                const collateralValue = parseFloat($('#collateral-value').val());
                const collateralImages = $('#collateral-images')[0].files;
                
                if (!$('#collateral-type').val()) {
                    $('#collateral-type').addClass('is-invalid');
                    $('#collateral-type').next('.invalid-feedback').show();
                    isValid = false;
                }
                
                if (!$('#collateral-description').val()) {
                    $('#collateral-description').addClass('is-invalid');
                    $('#collateral-description').next('.invalid-feedback').show();
                    isValid = false;
                }
                
                if (!collateralValue || isNaN(collateralValue)) {
                    $('#collateral-value').addClass('is-invalid');
                    $('#collateral-value').next('.invalid-feedback').show();
                    isValid = false;
                } else if (collateralValue < 1000) {
                    $('#collateral-value').addClass('is-invalid');
                    $('#collateral-value').next('.invalid-feedback').text('Collateral value must be at least ₱1,000.').show();
                    isValid = false;
                }
                
                if (!$('#collateral-ownership').val()) {
                    $('#collateral-ownership').addClass('is-invalid');
                    $('#collateral-ownership').next('.invalid-feedback').show();
                    isValid = false;
                }
                
                if (!collateralImages || collateralImages.length === 0) {
                    $('#collateral-images').addClass('is-invalid');
                    $('#collateral-images').next('.invalid-feedback').show();
                    isValid = false;
                } else {
                    // Validate each image
                    for (let i = 0; i < collateralImages.length; i++) {
                        const file = collateralImages[i];
                        const validTypes = ['image/jpeg', 'image/png'];
                        const maxSize = 5 * 1024 * 1024; // 5MB
                        
                        if (!validTypes.includes(file.type)) {
                            $('#collateral-images').addClass('is-invalid');
                            $('#collateral-images').next('.invalid-feedback').text('Please upload valid image files (JPG or PNG only).').show();
                            isValid = false;
                            break;
                        } else if (file.size > maxSize) {
                            $('#collateral-images').addClass('is-invalid');
                            $('#collateral-images').next('.invalid-feedback').text('Each image must be less than 5MB.').show();
                            isValid = false;
                            break;
                        }
                    }
                }
                
                return isValid;
            }
            
            // Validate step 5 (Terms and Conditions)
            function validateStep5() {
                let isValid = true;
                clearAllInvalid();
                
                if (!$('#agree-terms').is(':checked')) {
                    $('#agree-terms').addClass('is-invalid');
                    $('#agree-terms').next('.invalid-feedback').show();
                    isValid = false;
                }
                
                return isValid;
            }
            
            // Navigation handlers
            $('#next-step-1').click(function() {
                if (validateStep1()) {
                    currentStep = 2;
                    updateStepper(currentStep);
                    $('#step-1').removeClass('active');
                    $('#step-2').addClass('active');
                    $('#current-step').val(currentStep);
                    clearValidation();
                }
            });
            
            $('#next-step-2').click(function() {
                if (validateStep2()) {
                    currentStep = 3;
                    updateStepper(currentStep);
                    $('#step-2').removeClass('active');
                    $('#step-3').addClass('active');
                    $('#current-step').val(currentStep);
                    clearValidation();
                }
            });
            
            $('#next-step-3').click(function() {
                if (validateStep3()) {
                    currentStep = 4;
                    updateStepper(currentStep);
                    $('#step-3').removeClass('active');
                    $('#step-4').addClass('active');
                    $('#current-step').val(currentStep);
                    clearValidation();
                }
            });
            
            $('#next-step-4').click(function() {
                if (validateStep4()) {
                    currentStep = 5;
                    updateStepper(currentStep);
                    $('#step-4').removeClass('active');
                    $('#step-5').addClass('active');
                    $('#current-step').val(currentStep);
                    clearValidation();
                }
            });
            
            $('.prev-step').click(function() {
                currentStep -= 1;
                updateStepper(currentStep);
                $('.step-form').removeClass('active');
                $(`#step-${currentStep}`).addClass('active');
                $('#current-step').val(currentStep);
                clearValidation();
                clearAllInvalid();
            });
            
            // Form validation before submit
            $('#multi-step-form').on('submit', function(e) {
                if (currentStep === 5) {
                    if (!validateStep5()) {
                        e.preventDefault();
                        return false;
                    }
                    
                    // Show loading state
                    const submitBtn = $('#submit-application');
                    submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');
                                
                    // Additional validation if needed
                    if (!validateStep1() || !validateStep2() || !validateStep3() || !validateStep4()) {
                        e.preventDefault();
                        submitBtn.prop('disabled', false).html('Submit Application');
                        return false;
                    }
                    
                    return true;
                } else {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
    <?php include('../../../includes/sidebar.php'); ?>
    <?php include('../../../includes/script.php'); ?>
</body>
</html>