<?php 
session_start();
include('../../db_file/db_connection.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function sendemail_verify($name,$email,$verify_token)
{
    $mail = new PHPMailer(true);

    $mail->isSMTP(); 
    $mail->SMTPAuth   = true; 

    $mail->Host       = 'smtp.gmail.com';
    $mail->Username   = 'unilolo769@gmail.com';                   
    $mail->Password   = 'wzdd fwiv lsvh jduw'; 

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;   

    $mail->setFrom('unilolo769@gmail.com', $name);
    $mail->addAddress($email);

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email Verification from uniqloan system';

    $email_template ="
        <h2>You have Registered with Uniqloan Management</h2>
        <h5>Verify your email address to login with the link given below.</h5>
        <h1> VERIFY YOUR EMAIL. </h1>
        <br/><br/>
        <a href='http://localhost/LOAN_MANAGEMENT_SYSTEM/LoginRegister/user/verify-email.php?token=$verify_token'>click me</a>
    ";

    $mail->Body    = $email_template;
    $mail->send();
    //echo 'Message has been sent';
}


if(isset($_POST['register_btn']))
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verify_token = md5(rand());
    

    // email exist or not
    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if(mysqli_num_rows($check_email_query_run) > 0 )
    {
        $_SESSION['status'] = "Email ID already Exists";
        header("location: registration.php");
    }
    else
    {
        //insert user data
        $query = "INSERT INTO users (full_name,phone,email,password,verify_token) VALUES ('$name','$phone','$email','$password','$verify_token')";
        $query_run = mysqli_query($con, $query);

        if($query_run) 
        {
            sendemail_verify("$name","$email","$verify_token");
            $_SESSION['status'] = "Registration successfull. Please verify your email.";
            header("location: registration.php");
        }
        else
        {
            $_SESSION['status'] = "Registration failed";
            header("location: registration.php");
        }
    }
}



?>