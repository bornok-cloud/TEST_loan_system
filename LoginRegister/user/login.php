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
</head>
<body>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
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
                
                <div class="card shadow">
                    <div class="card-header">
                        <h5>Login Form</h5>
                    </div>
                    <div class="card-body">
                        <form action="logincode.php" method="POST" id="registrationForm">
                            <div class="form-group mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" name="email" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            
                            <div class="form-group mb-2">
                                <button type="submit" name="login_now_btn" class="btn btn-danger w-100 mb-3">Login</button>
                                <div class="text-end">
                                    <a href="password-reset.php">Forgot Your Password?</a>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <p class="mb-0">
                                    Did not receive your Verification Email?
                                    <a href="resend-email-verification.php">Resend</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../../includes/sidebar.php'); ?>
<?php include('../../includes/script.php'); ?>

</body>
</html>