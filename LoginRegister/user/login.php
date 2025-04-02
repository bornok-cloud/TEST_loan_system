<?php
    session_start();
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
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

</head>
<body>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php 
                    if(isset($_SESSION['status']))
                    {
                        ?>
                        <div class="alert alert-success">
                            <h5><?=$_SESSION['status']?></h5>
                        </div>
                        <?php
                            unset($_SESSION['status']);
                        }
                    ?>
                </div>
                <div class="card shadow">
                    <div class="card-header">
                        <h5>Login Form</h5>
                    </div>
                    <div class="card-body">
                    <form action="logincode.php" method="POST" id="registrationForm">

                        <div class="form-group mb-2">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Password</label>
                            <input type="text" name="password" class="form-control" required>
                        </div>
                        
                        <div class="form-group mb-1">
                            <button type="submit" name="login_now_btn" class="btn btn-primary mb-5">Login</button>
                        </div>
                        <hr>
                        <h6>
                            Did not recieve you Verification Email?
                            <a href="resend-email-verification.php">Resend</a>
                        </h6>
                        
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script>
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
</script> -->
<?php include('../../includes/sidebar.php'); ?>
<?php include('../../includes/script.php'); ?>
<?php include('../../includes/footer.php')?>
</body>
</html>
