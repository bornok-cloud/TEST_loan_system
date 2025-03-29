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
</body>
</html>