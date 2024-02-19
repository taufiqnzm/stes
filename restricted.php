<?php
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: restricted.html"); // Redirect to the login page if the user is not logged in
    exit;
}
?>
