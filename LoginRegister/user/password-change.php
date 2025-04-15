<?php
session_start();

$page_title = "Login Form";
include('../../includes/header.php');


?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
                                    
                <div class="card">
                    <div class="card-header">
                        <h5>Change Password</h5>
                    </div>
                    <div class="card-body p-4">

                        <form action="password-reset-code.php" method="POST">
                            <input type="hidden" name="password_token" value="<?php if(isset($_GET['token'])){echo $_GET['token'];} ?>">
        
                            <div class="form-group mb-3">
                                <label>Email Address</label>
                                <input type="text" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>" class="form-control" placeholder="Enter Email Address">
                            </div>
                            <div class="form-group mb-3">
                                <label>New Password</label>
                                <input type="text" name="new_password" class="form-control" placeholder="Enter New Password">
                            </div>
                            <div class="form-group mb-3">
                                <label>Confirm New Password</label>
                                <input type="text" name="confirm_password" class="form-control" placeholder="Enter New Password">
                            </div>
                            <div class="form-group mb-3">
                                <button text="submit" name="password_update" class="btn btn-danger w-100">Update Password</button>
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

