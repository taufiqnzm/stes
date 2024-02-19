<?php
require_once 'config.php'; // Include the config.php file

if (isset($_POST["reset"])) {
    $email = $_POST["email"];
    include 'send-verification-code.php'; // Include the send-verification-code file to send verification code

    // Generate a random verification code
    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        // Update the verification code and timestamp in the database
        try {
            $stmt = $conn->prepare("UPDATE users SET verification_code = :verification_code, verification_code_timestamp = :verification_code_timestamp WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':verification_code', $verification_code);
            $stmt->bindParam(':verification_code_timestamp', $currentTimestamp);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    

        header("Location: logged-out-email-verification.php?email=" . $email);
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>STES - Forgot Password</title>
    <link rel="icon" href="img/LogoSek.ico" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body style="background-image: url(img/background4.jpg); background-size: cover;">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5" style="background-color: rgba(255, 255, 255, 0.5);">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-12" style="margin: 20px auto;">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2" style="font-family: 'Your Exclusive Font', sans-serif; font-size: 36px; font-weight: bold; color: #ff6600; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Forgot Your Password?</h1>
                                        <p class="mb-4" style=" font-size: 16px; color: #000000" >We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form class="user" action="" method="POST">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." style=" font-size: 16px;">
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" name="reset" value="Reset Password" style=" font-size: 16px; background: linear-gradient(45deg, #0077FF, #0033AA); color: #fff; border: 1px solid #0077FF; padding: 10px 20px; border-radius: 25px; text-transform: uppercase; font-weight: bold; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
                                        
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.php" style=" font-size: 17px; font-weight: bold;" >Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login.php" style=" font-size: 17px; font-weight: bold;">Already have an account? Login!</a>
                                    </div>
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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>