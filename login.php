<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once('config.php'); // Include your database configuration file

// Debugging output
error_log("Debugging: Before form submission processing.");

$output_message = ""; // Initialize the output message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_submit'])) {
    $email_phone = $_POST['email_phone'];
    $pass = isset($_POST['pass']) ? $_POST['pass'] : '';

    // Check if 'pass' is not empty before proceeding
    if (!empty($pass)) {
        try {
            // Check if the input is a valid email address
            if (filter_var($email_phone, FILTER_VALIDATE_EMAIL)) {
                // If it's a valid email, use it to search by the 'email' column
                $sql = "SELECT * FROM users WHERE email = ?";
            } else {
                // If it's not a valid email, use it to search by the 'phone' column
                $sql = "SELECT * FROM users WHERE phone = ?";
            }

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $email_phone);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($pass, $user['pass'])) {
                // Check if the user is an admin
                if ($user['is_admin'] == 1) {
                    // Admin login
                    $_SESSION['admin_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username']; // Store the username in the session
                    $_SESSION['pic'] = $user['pic']; // Store the pic in the session
                    echo '
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Admin Login Successfully",
                                text: "' . $output_message . '",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.href = "admin1_dashboard.php";
                            });
                        });
                    </script>';
                } else {
                    // Normal user login
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username']; // Store the username in the session
                    $_SESSION['pic'] = $user['pic']; // Store the pic in the session
                    $_SESSION['teacher_session'] = $user['teacher_session']; // Store the user's session in the session

                    // Check if the "Remember Me" checkbox was selected
                    if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
                        // Generate a unique token (you can use a library like random_bytes)
                        $token = bin2hex(random_bytes(32));

                        // Store the token in a cookie with an expiration time (e.g., 30 days)
                        setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/');

                        // Store the token in the database table associated with the user
                        // You need a 'remember_token' column in your 'Users' table
                        $updateTokenSql = "UPDATE users SET remember_token = ? WHERE email = ?";
                        $updateTokenStmt = $conn->prepare($updateTokenSql);
                        $updateTokenStmt->bindParam(1, $token);
                        $updateTokenStmt->bindParam(2, $email_phone);
                        $updateTokenStmt->execute();
                    }

                    // $output_message = "User Login Successful";
                    // Add the following script to show the pop-up message
                    // Add the following script to show the pop-up message and redirect immediately
                    echo '
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Login Successfully",
                                text: "' . $output_message . '",
                                icon: "success",
                                showConfirmButton: false, // Remove the "OK" button
                                timer: 2000, // Auto-close the pop-up after 2 seconds
                                timerProgressBar: true
                            }).then(() => {
                                window.location.href = "index.php"; // Redirect after showing the pop-up
                            });
                        });
                    </script>';
                }
            } else {
                $output_message = "Login Failed. Please check your username/email and password.";
                error_log("Debugging: $output_message");
            }
        } catch (PDOException $e) {
            $output_message = 'Database Error: ' . $e->getMessage();
        }
    } else {
        $output_message = 'Please enter a password.';
    }

    $conn = null; // Close the database connection
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>STES-Login</title>
    <link rel="icon" href="img/LogoSek.ico" type="image/x-icon">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Add SweetAlert2 CDN here -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

</head>
<body style="background-image: url(img/background4.jpg); background-size: cover;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9 my-1">
            <div class="card o-hidden border-0 shadow-lg my-5 mx-4 " style="background-color: rgba(255, 255, 255, 0.5);">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-10" style="margin: 10px auto;">
                            <div class="p-4">
                                <div class="text-center">
                                    <img src="img/LogoSek.png" alt="logoSekolah" style="height: 100px; width: auto;">
                                    <img src="img/logoSTES.png" alt="logoStes" style="height: auto; width: 300px;"><br><br>
                                    <!-- <h1 class="h4 text-gray-900 mb-4" style="font-family: 'Your Exclusive Font', sans-serif; font-size: 36px; font-weight: bold; color: #000; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">STES</h1> -->
                                    <h1 class="h4 text-gray-900 mb-4" style="font-family: 'Your Exclusive Font', sans-serif; font-size: 30px; font-weight: bold; color: #000; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">SCHOOL TEACHER EXISTENCE SYSTEM</h1>
                                </div>
                                
                                <?php
                                if (!empty($output_message)) {
                                    echo '
                                    <div class="alert alert-danger">
                                        ' . $output_message . '
                                    </div>
                                    ';
                                }
                                ?>
                                <form class="user" method="POST" action="login.php" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" name="email_phone" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Email" style="font-size: 17px; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); border: 1px solid #ccc;">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="pass" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" style=" font-size: 17px; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); border: 1px solid #ccc;">
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck" name="remember">
                                            <label class="custom-control-label" for="customCheck" style=" font-size: 17px; color:#000000">Remember Me</label>
                                        </div>
                                    </div>


                                <button type="submit" name="login_submit" class="btn btn-user btn-block" style=" font-size: 16px; background: linear-gradient(45deg, #0077FF, #0033AA); color: #fff; border: 1px solid #0077FF; padding: 10px 20px; border-radius: 25px; text-transform: uppercase; font-weight: bold; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
                                            Login
                                    </button>

                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="forgot-password.php" style=" font-size: 17px; font-weight: bold;">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="register.php" style=" font-size: 17px; font-weight: bold;">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer style="bottom: 0; width: 100%;" class="sticky-footer">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span style="font-size: 16px;">Copyright &copy; SMK METHODIST (ACS) SITIAWAN 2023</span>
        </div>
    </div>
</footer>


<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>

</body>
</html>