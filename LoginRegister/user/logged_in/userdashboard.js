
        $(document).ready(function() {
            let currentStep = 1;
            const totalSteps = 3;
            
            // Initialize stepper
            updateStepper(currentStep);
            
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
            
            // Validate step 1
            function validateStep1() {
                const dob = new Date($('#dob').val());
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const monthDiff = today.getMonth() - dob.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                
                if (!$('#dob').val() || !$('#gender').val()) {
                    showValidation('Please fill out all required fields.');
                    return false;
                }
                
                if (age < 21) {
                    showValidation('You must be at least 21 years old to apply.');
                    return false;
                }
                
                return true;
            }
            
            // Validate step 2
            function validateStep2() {
                const postalCode = $('#postal-code').val().trim();
                const idNumber = $('#id-number').val().trim();
                const postalCodePattern = /^\d{4}$/;
                const idNumberPattern = /^[0-9-]+$/;
                
                if (!$('#address').val() || !postalCode || !$('#valid-id').val() || !idNumber || !$('#id-photo')[0].files.length) {
                    showValidation('Please fill out all required fields.');
                    return false;
                }
                
                if (!postalCodePattern.test(postalCode)) {
                    showValidation('Please enter a valid 4-digit postal code.');
                    return false;
                }
                
                if (!idNumberPattern.test(idNumber)) {
                    showValidation('ID number should contain only numbers and dashes.');
                    return false;
                }
                
                return true;
            }
            
            // Validate step 3
            function validateStep3() {
                const loanAmount = parseFloat($('#loan-amount').val());
                
                if (!loanAmount || isNaN(loanAmount) || loanAmount < 5000 || loanAmount > 100000) {
                    showValidation('Please enter a valid loan amount between ₱5,000 and ₱100,000.');
                    return false;
                }
                
                if (!$('#loan-purpose').val()) {
                    showValidation('Please select a loan purpose.');
                    return false;
                }
                
                return true;
            }
            
            // Navigation handlers
            $('#next-step-1').click(function() {
                if (validateStep1()) {
                    currentStep = 2;
                    updateStepper(currentStep);
                    $('#step-1').removeClass('active');
                    $('#step-2').addClass('active');
                    clearValidation();
                }
            });
            
            $('#next-step-2').click(function() {
                if (validateStep2()) {
                    currentStep = 3;
                    updateStepper(currentStep);
                    $('#step-2').removeClass('active');
                    $('#step-3').addClass('active');
                    clearValidation();
                }
            });
            
            $('.prev-step').click(function() {
                currentStep -= 1;
                updateStepper(currentStep);
                $('.step-form').removeClass('active');
                $(`#step-${currentStep}`).addClass('active');
                clearValidation();
            });
            
            // Form submission
            $('#multi-step-form').submit(function(e) {
                e.preventDefault();
                
                if (validateStep3()) {
                    // Here you would typically submit the form via AJAX
                    alert('Form submitted successfully!');
                    // window.location.href = 'confirmation.php';
                }
            });
        });
    