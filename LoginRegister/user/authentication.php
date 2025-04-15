<?php
session_start();

if (!isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "Please log in to access this page.";
    header('Location: login.php');
    exit(0);
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
