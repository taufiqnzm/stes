<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

require_once 'config.php'; // Include the config.php file

$message = "A verification code has been sent to your email. The code will expire in 30 minutes";

if (isset($_GET["email"])) {
    $email = $_GET["email"];
    
    // Get the verification code from the session variable
    if (isset($_SESSION['verification_code'])) {
        $verification_code = $_SESSION['verification_code'];
    } else {
        // Handle the case where the verification code is not set in the session
    }

    // Update the verification code and timestamp in the database
    $sql = "UPDATE users SET verification_code = ?, verification_code_timestamp = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $currentTimestamp = date('Y-m-d H:i:s'); // Get the current timestamp
    $stmt->execute([$verification_code, $currentTimestamp, $email]);

    // Provide a message to the user
    $message = "A new verification code has been sent to your email. The code will expire in 30 minutes";
}

if (isset($_POST["verify"])) {
    $verification_code = $_POST["verification_code"];
    $email = $_GET["email"]; // Get the email from the URL parameter

    // Query the database to check if the entered verification code is correct and not expired
    $sql = "SELECT email_verified_at, verification_code_timestamp, verification_code FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $result = $stmt->fetch();

    if ($result && $result['email_verified_at'] !== null && $result['verification_code'] === $verification_code) {
        // Check if the code is still valid
        $codeTimestamp = strtotime($result['verification_code_timestamp']);
        if ($codeTimestamp !== false) {
            $currentTimestamp = time();
            $codeValidityDuration = 30 * 60; // 30 minutes
    
            if ($currentTimestamp - $codeTimestamp <= $codeValidityDuration) {
                // Verification code is correct and still valid
                // Mark the email as verified
                $sql = "UPDATE users SET email_verified_at = NOW() WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$email]);
    
                // Provide a success message and maybe redirect the user to a login page
                $message = "Email verification successful. You can now log in.";
                header("Location: logged-out-change-password.php?email=" . $email);
            } else {
                // Verification code is expired
                $message = "The verification code has expired. Please request a new code.";
            }
        } else {
            // Invalid timestamp (verification_code_timestamp is null)
            $message = "Invalid verification timestamp. Please request a new code.";
        }
    } else {
        // Verification code is incorrect or the email is already verified
        $message = "Invalid verification code. Please try again or check your email verification status.";
    }
}

if (isset($_POST["resend"])) {
    $email = $_POST["email"];
    
    // Generate a new verification code (similar to the registration process)
    $new_verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

    include 'send-verification-code.php'; // Include the send-verification-code file to send verification code

    // Update the verification code and timestamp in the database
    $sql = "UPDATE users SET verification_code = ?, verification_code_timestamp = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$new_verification_code, $currentTimestamp, $email]);

    // Provide a message to the user
        $message = "A new verification code has been sent to your email. The code will expire in 30 minutes";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="img/LogoSek.ico" type="image/x-icon">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body style="background-image: url(img/background4.jpg); background-size: cover;">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-10" style="margin: 20px auto;">
                        <div class="p-5">
                            <h2 style="text-align: center;">Verification Email</h2><br>
                            <?php echo $message; ?>
                            <form action="" method="POST" style="text-align: center;">
                                <br><label for="verification_code">Enter verification code</label>
                                <input type="text" name="verification_code">
                                <input style=" font-size: 16px; background: linear-gradient(45deg, #0077FF, #0033AA); color: #fff; border: 1px solid #0077FF; padding: 10px 20px; border-radius: 25px; text-transform: uppercase; font-weight: bold; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);" type="submit" name="verify" value="Verify"><br>
                                <?php
                                // Add a "Resend Verification Code" button
                                if (isset($_GET["email"])) {
                                    $email = $_GET["email"];
                                    echo '<input type="hidden" name="email" value="' . $email . '"><br>
                                        <label for="resend">Didn t receive the verification code?</label>
                                        <input type="submit"style="font-size: 16px; background: linear-gradient(45deg, #FF0000, #990000); color: #fff; border: 1px solid #FF0000; padding: 10px 20px; border-radius: 25px; text-transform: uppercase; font-weight: bold; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);" name="resend" value="Resend Verification Code">';
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer style="position: fixed; bottom: 0; width: 100%;" class="sticky-footer">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span style="font-size: 16px;">Copyright &copy; SMK METHODIST (ACS) SITIAWAN 2023</span>
            </div>
    </div>
    </footer>
    </body>
</html>