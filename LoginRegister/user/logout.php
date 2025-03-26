<?php
session_start();
session_destroy();
header("Location: ../LOGIN1.php");
exit();
?>