 src="https://code.jquery.com/jquery-3.6.0.min.js">

        $(document).ready(function() {
    var currentStep = 1;
    var totalSteps = 3;

    // Function to show the current step and hide others
    function showStep(step) {
        $(".step").addClass("d-none");
        $(".step-" + step).removeClass("d-none");
        $("#validation-messages").addClass("d-none");
        updateProgressBar(step);
    }

    // Function to update the progress bar
    function updateProgressBar(step) {
        var progressPercentage = (step / totalSteps) * 100;
        $("#progress-bar")
            .css("width", progressPercentage + "%")
            .text("Step " + step + " of " + totalSteps);
    }

    // Step 1 validation function
    function validateStep1() {
        const dob = new Date($("#dob").val());
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        if (!$("#full-name").val() || !$("#dob").val() || !$("#gender").val()) {
            $("#validation-messages").text("Please fill out all fields.").removeClass("d-none");
            return false;
        } else if (age <= 20) {
            $("#validation-messages").text("You must be older than 20 years to continue.").removeClass("d-none");
            return false;
        }
        return true;
    }

    // Step 2 validation function
    function validateStep2() {
        const postalCode = $("#postal-code").val().trim();
        const idNumber = $("#id-number").val().trim();
        const postalCodePattern = /^\d{4}$/;
        const idNumberPattern = /^[0-9-]+$/;

        if (!$("#address").val() || !postalCode || !$("#valid-id").val() || !idNumber) {
            $("#validation-messages").text("Please fill out all fields.").removeClass("d-none");
            return false;
        } else if (!postalCodePattern.test(postalCode)) {
            $("#validation-messages").text("Please enter a valid 4-digit Postal Code.").removeClass("d-none");
            return false;
        } else if (!idNumberPattern.test(idNumber)) {
            $("#validation-messages").text("ID Number should contain only numbers and dashes.").removeClass("d-none");
            return false;
        }
        return true;
    }

    // Step 3 validation function
    function validateStep3() {
        if (!$("#loan-purpose").val()) {
            $("#validation-messages").text("Please select a loan purpose.").removeClass("d-none");
            return false;
        }
        return true;
    }

    // Next button logic for step 1
    $("#next-step-1").click(function() {
        if (validateStep1()) {
            currentStep = 2;
            showStep(currentStep);
        }
    });

    // Next button logic for step 2
    $("#next-step-2").click(function() {
        if (validateStep2()) {
            currentStep = 3;
            showStep(currentStep);
        }
    });

    // Submit button for final step
    $("#next-step-3").click(function() {
        if (validateStep3()) {
            // Form submission logic goes here (e.g., AJAX call or form submission)
            alert("Form submitted successfully!");
        }
    });

    // Previous button logic to navigate backward through steps
    $(".prev-step").click(function() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // Initial progress bar update
    updateProgressBar(currentStep);
});






