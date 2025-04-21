<?php 
session_start();
include('../../db_file/db_connection.php');

if(isset($_POST['login_now_btn']))
{
    if(!empty(trim($_POST['email'])) && !empty(trim($_POST['password'])))
    {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        // Check if admin credentials are used
        $admin_email = "admin@loanapp.com"; // Set your admin email here
        $admin_password = "admin123"; // Set your admin password here
        
        if($email == $admin_email && $password == $admin_password)
        {
            // Admin login successful
            $_SESSION['authenticated'] = TRUE;
            $_SESSION['auth_role'] = 'admin';
            $_SESSION['auth_user'] = [
                'username' => 'Administrator',
                'email' => $admin_email,
            ];
            $_SESSION['status'] = "Welcome to Admin Dashboard";
            header("location: ../adminhome.php");
            exit(0);
        }
        else
        {
            // Regular user login process
            $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
            $login_query_run = mysqli_query($con, $login_query);

            if(mysqli_num_rows($login_query_run) > 0)
            {
                $row = mysqli_fetch_array($login_query_run);
                if($row['is_verified'] == "1")
                {
                    $_SESSION['authenticated'] = TRUE;
                    $_SESSION['auth_role'] = 'user';
                    $_SESSION['auth_user'] = [
                        'user_id' => $row['id'],
                        'username' => $row['full_name'],
                        'phone' => $row['phone'],
                        'email' => $row['email'],
                    ];
                    $_SESSION['status'] = "You are Logged In Successfully.";
                    header("location: logged_in/dashboard.php?#");
                    exit(0);
                }
                else
                {
                    $_SESSION['status'] = "Please Verify your Email";
                    header('location: login.php');
                    exit(0);
                }
            }
            else
            {
                $_SESSION['status'] = "Invalid Email or Password";
                header('location: login.php');
                exit(0);
            }
        }
    }
    else
    {
        $_SESSION['status'] = "All fields are Mandatory";
        header('location: login.php');
        exit(0);
    }
}
?>