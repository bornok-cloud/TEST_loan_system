<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script>
        document.getElementById("sidebarToggle").addEventListener("click", function() {
            document.getElementById("sidebar").classList.add("active");
            document.getElementById("sidebarToggle").style.display = "none";
        });
        
        document.getElementById("sidebarClose").addEventListener("click", function() {
            document.getElementById("sidebar").classList.remove("active");
            document.getElementById("sidebarToggle").style.display = "block";
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const loanAmountInput = document.getElementById("loanAmount");
        const loanRangeInput = document.getElementById("loanRange");
        const termButtons = document.querySelectorAll(".term-btn");
        const selectedTerm = document.getElementById("selectedTerm");
        const selectedAmount = document.getElementById("selectedAmount");
        const disbursedAmount = document.getElementById("disbursedAmount");
        const monthlyInstallment = document.getElementById("monthlyInstallment");

        function calculateInstallment(amount, term) {
            const interestRate = 0.12 / 12; // 12% annual rate divided by 12 months
            const numPayments = term;
            const monthlyPayment = (amount * interestRate) / (1 - Math.pow(1 + interestRate, -numPayments));
            return monthlyPayment.toFixed(2);
        }

        loanAmountInput.addEventListener("input", () => {
            loanRangeInput.value = loanAmountInput.value;
            selectedAmount.innerText = `₱${loanAmountInput.value}`;
            disbursedAmount.innerText = `₱${loanAmountInput.value - 500}`;
            monthlyInstallment.innerText = `₱${calculateInstallment(loanAmountInput.value, parseInt(selectedTerm.innerText))} per month`;
        });

        loanRangeInput.addEventListener("input", () => {
            loanAmountInput.value = loanRangeInput.value;
            selectedAmount.innerText = `₱${loanRangeInput.value}`;
            disbursedAmount.innerText = `₱${loanRangeInput.value - 500}`;
            monthlyInstallment.innerText = `₱${calculateInstallment(loanRangeInput.value, parseInt(selectedTerm.innerText))} per month`;
        });

        termButtons.forEach(button => {
            button.addEventListener("click", () => {
                termButtons.forEach(btn => btn.classList.remove("active"));
                button.classList.add("active");
                selectedTerm.innerText = `${button.dataset.term} months`;
                monthlyInstallment.innerText = `₱${calculateInstallment(loanAmountInput.value, parseInt(button.dataset.term))} per month`;
            });
        });
    </script>
    <script>
        // Form navigation
        function nextStep(current, next) {
            document.getElementById(`step${current}`).classList.remove('active');
            document.getElementById(`step${next}`).classList.add('active');
            updateProgressBar(next);
        }
        
        function skipStep() {
            // Logic to skip ID verification and submit form
            submitForm();
        }
        
        function submitForm() {
            // Form submission logic
            alert('Form submitted successfully!');
            // window.location.href = 'dashboard.html'; // Redirect after submission
        }
        
        function updateProgressBar(step) {
            const progressPercentage = (step / 5) * 100;
            document.querySelector('.progress-bar').style.width = `${progressPercentage}%`;
            document.querySelector('.progress-bar').setAttribute('aria-valuenow', progressPercentage);
        }
        
        function selectGender(element, gender) {
            // Remove active class from all gender options
            document.querySelectorAll('.gender-option').forEach(opt => {
                opt.classList.remove('active');
            });
            
            // Add active class to selected option
            element.classList.add('active');
            
            // Update radio button
            document.getElementById(gender).checked = true;
        }
        
        function selectLocation(element) {
            // Remove active class from all location options
            document.querySelectorAll('.list-group-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Add active class to selected location
            element.classList.add('active');
        }
    </script>

</body>
</html>