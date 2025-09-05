<?php
session_start();
session_destroy(); // Destroy all sessions
header("Location: adminlogin.php"); // Redirect to login page
exit();
?>
