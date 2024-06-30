<?php
require_once 'config.php'; // Include the config.php file

$error = ''; // Initialize an error variable

if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Check if password and confirm password match
    if ($password !== $confirmPassword) {
        $error = "Password and Confirm Password do not match.";
    } else {
            include 'send-verification-code.php'; // Include the send-verification-code file to send verification code

            // Encrypt the password
            $encrypted_password = password_hash($password, PASSWORD_BCRYPT);

            // Set email verification status to NULL initially
            $email_verified_at = NULL;

            // Insert the user data along with verification code and timestamp into the database
            $sql = "INSERT INTO users (username, email, pass, verification_code, verification_code_timestamp, email_verified_at) VALUES (?, ?, ?, ?, ?, NULL)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $email, $encrypted_password, $verification_code, $currentTimestamp]);

            header("Location: email-verification.php?email=" . $email);
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="img/LogoSek.ico" type="image/x-icon">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .valid {
            border: 2px solid green;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 255, 0, 0.7);
        }

        .invalid {
            border: 2px solid red;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(255, 0, 0, 0.7);
        }
    </style>
</head>
<body style="background-image: url(img/background4.jpg); background-size: cover;">
     
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-10" style="margin-top: 90px;">
                <div class="card o-hidden border-0 shadow-lg col-6 my-5 mx-auto" style="background-color: rgba(255, 255, 255, 0.5);">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-10" style="margin: 20px auto;">
                                <div class="p-0">
                                    <h2 style="text-align: center; font-family: 'Your Exclusive Font', sans-serif; font-size: 36px; font-weight: bold; color: #000000; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);"" >Create Account</h2>
                                    <?php
                                    if (!empty($error)) {
                                        echo '<p style="color: red;">' . $error . '</p>';
                                    }
                                    ?>
                                    <form method="POST" style="font-size: 17px; color:#000000">
                                        <div class="form-group" >
                                            <label for="username">Username:</label>
                                            <input type="text" class="form-control" name="username" pattern="[A-Za-z ]+" value="Cikgu" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="email" class="form-control" name="email" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password:</label>
                                            <input type="password" class="form-control" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, one symbol, and be at least 8 characters long" required>
                                            <!-- <span id="passwordValidation" style="display: none; color: red;">Password does not meet the requirements.</span> -->
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm_password">Confirm Password:</label>
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, one symbol, and be at least 8 characters long" required>
                                            <!-- <span id="confirmValidation" style="display: none; color: red;">Passwords do not match or do not meet the requirements.</span>                                        </div> -->
                                        </div>
                                        <button type="submit" class="btn btn-primary col-12" name="register" style=" font-size: 16px; background: linear-gradient(45deg, #0077FF, #0033AA); color: #fff; border: 1px solid #0077FF; padding: 10px 20px; border-radius: 25px; text-transform: uppercase; font-weight: bold; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">Create</button>
                                    </form>
                                </div>
                            </div>
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

    <!-- Add Bootstrap JS and jQuery (make sure to include jQuery first) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirm_password');

        passwordInput.addEventListener('input', validatePassword);
        confirmInput.addEventListener('input', validatePassword);

        function validatePassword() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;

            if (password === confirm && password.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/)) {
                passwordInput.classList.remove('invalid');
                confirmInput.classList.remove('invalid');
                passwordInput.classList.add('valid');
                confirmInput.classList.add('valid');
            } else {
                passwordInput.classList.remove('valid');
                confirmInput.classList.remove('valid');
                passwordInput.classList.add('invalid');
                confirmInput.classList.add('invalid');
            }
        }
    </script>
</body>
</html>