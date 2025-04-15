<?php
session_start();
include('../../db_file/db_connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function resend_email_verify($name, $email, $verify_token)
{
    $mail = new PHPMailer(true);

    $mail->isSMTP(); 
    $mail->SMTPAuth   = true; 

    $mail->Host       = 'smtp.gmail.com';
    $mail->Username   = 'unilolo769@gmail.com';                   
    $mail->Password   = 'ahlh zrrh xzql yoxx'; 

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;   

    $mail->setFrom('unilolo769@gmail.com', $name);
    $mail->addAddress($email);

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Resend Email Verification from uniqloan system';

    $email_template ="
        <h2>You have Registered with Uniqloan Management</h2>
        <h5>Verify your email address to login with the link given below.</h5>
        <h1> VERIFY YOUR EMAIL. </h1>
        <br/><br/>
        <a href='http://localhost/LOAN_MANAGEMENT_SYSTEM/LoginRegister/user/verify-email.php?token=$verify_token'>click me</a>
    ";

    $mail->Body    = $email_template;
    $mail->send();
}



if(isset($_POST['resend_email_verify_btn']))
{
    if(!empty(trim($_POST['email'])))
    {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $checkemail_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $checkemail_query_run = mysqli_query($con, $checkemail_query);

        if(mysqli_num_rows($checkemail_query_run) > 0)
        {
            $row = mysqli_fetch_array($checkemail_query_run);
            if($row['is_verified'] == "0")
            {
                $name = $row['full_name'];
                $email = $row['email'];
                $verify_token = $row['verify_token'];

                resend_email_verify($name,$email,$verify_token);

                $_SESSION['status'] = "Verification Email Link has been sent to your email address.";
                header("Location: login.php");
                exit(0);
            }
            else
            {
                $_SESSION['status'] = "Email is Already Verified. Please Login.";
                header("Location: resend-email-verification.php");
                exit(0);
            }
        }
        else
        {
            $_SESSION['status'] = "Email is Not Registered. Please Register.";
            header("Location: registration.php");
            exit(0);
        }
    }
    else
    {
        $_SESSION['status'] = "Please enter the email field.";
        header("Location: resend-email-verification.php");
        exit(0);
    }
}


?>