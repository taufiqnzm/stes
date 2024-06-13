<?php
session_start();
require_once "config.php"; // Use require_once to ensure it's included only once

// Check if user_id and username are provided in the query string
if (isset($_GET['user_id']) && isset($_GET['username'])) {
    // Get user_id and username from the query string
    $user_id = $_GET['user_id'];
    $username = $_GET['username'];

    // Prepare the delete query
    $deleteQuery = "DELETE FROM users WHERE user_id = :user_id";

    // Prepare the statement
    $deleteStmt = $conn->prepare($deleteQuery);

    // Bind parameters
    $deleteStmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

    // Execute the delete query
    if ($deleteStmt->execute()) {
        // Redirect back to the users page with a success message
        $_SESSION['user_success_message'] = "User $username deleted successfully.";
        header("Location: admin6_history.php");
        exit();
    } else {
        // Redirect back to the users page with an error message
        $_SESSION['user_error_message'] = "Error deleting user $username.";
        header("Location: admin6_history.php");
        exit();
    }
} else {
    // Redirect back to the users page with an error message if user_id or username is not provided
    $_SESSION['error_message'] = "Invalid request.";
    header("Location: admin6_history.php");
    exit();
}
?>
