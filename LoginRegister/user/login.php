<?php
    $page_title = 'Login Form';
    include('../../includes/header.php'); 
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if(isset($page_title)){echo"$page_title";}?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body { background-color: #f8f9fa; }
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            background-color: white;
        }
        .btn-register {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2 class="text-center">Login</h2>
        <p class="text-center">Complete the form.</p>

        <form action="" id="registrationForm">

            <div class="form-group mb-1">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group mb-1">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
            <button type="submit" class="btn btn-primary">Login </button>
            </div>
        </form>

        <div id="statusMessage" class="mt-3 text-center"></div>
    </div>
</div>

<script>
    $("#registrationForm").submit(function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "process_registration.php",
            data: $(this).serialize(),
            success: function(response) {
                $("#statusMessage").html('<div class="alert alert-info">' + response + '</div>');
            }
        });
    });
</script>
<?php include('../../includes/sidebar.php'); ?>
<?php include('../../includes/script.php'); ?>
</body>
</html>
