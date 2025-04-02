<?php 
include('../../db_file/db_connection.php');
session_start();


if(isset($_GET['token']))
{
    $token = $_GET['token'];
    $verify_query = "SELECT verify_token,is_verified FROM users WHERE verify_token='$token' LIMIT 1";
    $verify_query_run = mysqli_query($con, $verify_query);

    if(mysqli_num_rows($verify_query_run) > 0)
    {
        $row = mysqli_fetch_array($verify_query_run);
        if($row['is_verified'] == "0")
        {
            $clicked_token = $row['verify_token'];
            $update_query ="UPDATE users SET is_verified='1' WHERE verify_token='$clicked_token' LIMIT 1";
            $update_query_run = mysqli_query($con, $update_query);

            if($update_query_run)
            {
                $_SESSION['status'] = "Your account has been Verified Successfully.";
                header("location: login.php");
                exit(0);
            }
            else
            {
                $_SESSION['status'] = "Verification Failed.";
                header("location: login.php");
                exit(0);
            }
        }
        else
        {
            $_SESSION['status'] = "Email Already Verified. Please Login";
            header("location: login.php");
            exit(0);
        }
    }
    else
    {
        $_SESSION['status'] = "This token does not exists.";
        header("location: login.php");
    }

}
else
{
    $_SESSION['status'] = "Not Allowed";
    header("location: login.php");
}

?>