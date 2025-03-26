<?php
session_start();

include('../db_file/db.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $username = $_POST['username'];
    $password = $_POST['Password'];

    // Query to find user
    $sql = "SELECT * FROM users WHERE email = '$username' LIMIT 1";
    // This is correct: you need to pass the connection object ($conn) and the SQL query
    $result = mysqli_query($conn, $sql);


    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Check password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['usertype'] = $user['usertype']; // 'user' or 'admin'
            // Redirect based on user type
            if ($user['usertype'] == 'admin') {
                header('Location: adminhome.php'); // Admin dashboard
            } else {
                header('Location: user/dashboard.php'); // User dashboard
            }
        } else {
            echo "Invalid credentials";
        }
    } else {
        echo "User not found";
    }
}
?>
