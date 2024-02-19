<?php
require_once "config.php"; // Use require_once to ensure it's included only once

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];

    // Retrieve the email from the URL
    $email = $_GET["email"]; // Make sure to validate and sanitize this value

    // Find the user by email
    $query = $conn->prepare("SELECT user_id FROM users WHERE email = :email");
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();

    if ($user) {
        $user_id = $user["user_id"];

        // Verify that the new password and confirm password match
        if ($newPassword === $confirmPassword) {
            // Hash the new password
            $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

            // Update the user's password in the database
            $updateQuery = $conn->prepare("UPDATE users SET pass = :password WHERE user_id = :user_id");
            $updateQuery->bindParam(':password', $newPasswordHash, PDO::PARAM_STR);
            $updateQuery->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            if ($updateQuery->execute()) {
                // Password updated successfully
                echo "Password updated successfully!";
                // Redirect to the index page
                header("Location: login.php");
                exit;
            } else {
                // Error updating the password
                echo "Error updating the password.";
            }
        } else {
            // New password and confirm password don't match
            echo "New password and confirm password do not match!";
        }
    } else {
        // User not found
        echo "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
     <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="img/LogoSek.ico" type="image/x-icon">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body style="background-image: url(img/background4.jpg);">
    <div class="container">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-10" style="margin: 20px auto;">
                            <div class="p-5">
                                <h1 class="card-title" style="text-align:center; color:black">Change Password</h1>
                                <form method="post" action="">
                                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                                    <div class="form-group">
                                        <label for="newPassword">New Password</label>
                                        <input type="password" class="form-control" id="newPassword" name="newPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, one symbol, and be at least 8 characters long" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm New Password</label>
                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, one symbol, and be at least 8 characters long" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer style="position: fixed; bottom: 0; width: 100%;" class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; SMK METHODIST (ACS) SITIAWAN 2023</span>
            </div>
        </div>
        </footer>
</body>
</html>