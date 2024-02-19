<?php
// logout.php
session_start();
session_destroy();
session_unset();
unset($_SESSION['user_id']); // This removes the 'user_id' session variable
// You can unset other variables as needed
header("Location: login.php"); // Redirect to the login page or any other appropriate location
// exit;