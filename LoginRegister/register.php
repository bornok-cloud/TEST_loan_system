<?php
include('../db_file/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $email = $_POST['email'];
    $userType = $_POST['userType']; // 'user' or 'admin'

    // Insert data into the database
    $sql = "INSERT INTO users (username, password, email, usertype) VALUES ('$username', '$password', '$email', '$userType')";

    if (mysqli_query($conn, $sql)) {
        echo "Registration successful";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
