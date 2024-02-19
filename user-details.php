
<?php
session_start();
require_once('config.php'); 
date_default_timezone_set('Asia/Kuala_Lumpur');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit'])) {

    $email = $_POST['email']; // Assuming you have an email input in the form

    // Debug: Check if the email is received correctly
    echo "Email: " . $email . "<br>";

    // Add code to retrieve the user's ID or other identifier based on the email
    $sql = "SELECT user_id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result) {
        $user_id = $result['user_id']; // Retrieve the user's ID
        
        // Set the user_id in the session
        $_SESSION['user_id'] = $user_id;
        
        // Debug: Check if the user_id is found
        echo "User ID: " . $user_id . "<br>";
    } else {
        // Handle the case where the email is not found in the database
        echo 'User not found.';
        exit();
    }

    // Handle image upload
    $target_directory = "uploads/";
    if (!is_dir($target_directory)) {
        mkdir($target_directory, 0777, true); // Create the directory if it doesn't exist
    }

    $pic = $_FILES['pic'];
    if (!empty($pic['name'])) {
        // Generate a unique filename
        $target_file = $target_directory . uniqid() . '_' . basename($pic["name"]);

        // Check file type and size (modify these checks as needed)
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        $max_file_size = 5242880; // 5MB

        $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_extensions) && $pic["size"] <= $max_file_size) {
            if (move_uploaded_file($pic["tmp_name"], $target_file)) {
                // Update the user's profile pic field in the database
                $sql = "UPDATE users SET pic = ? WHERE user_id = ?";
                try {
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(1, $target_file);
                    $stmt->bindParam(2, $user_id); // Use the user's ID to update the correct record
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo 'Database Error: ' . $e->getMessage();
                }
            } else {
                $update_error = 'File upload failed';
            }
        } else {
            $update_error = 'Invalid file type or size';
        }
    }

    // Continue with the other data you want to update in the database
    $name = $_POST['name'];
    $major = $_POST['major'];
    $ic = $_POST['ic'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $position = $_POST['position'];
    $teacher_session = $_POST['session'];
    $posting_date = $_POST['posting_date'];

    // Update the additional user details in the database
    $sql = "UPDATE users SET name=?, major=?, ic=?, phone=?, gender=?, position=?,teacher_session=?, posting_date=? WHERE user_id=?";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $major);
        $stmt->bindParam(3, $ic);
        $stmt->bindParam(4, $phone);
        $stmt->bindParam(5, $gender);
        $stmt->bindParam(6, $position);
        $stmt->bindParam(7, $teacher_session);
        $stmt->bindParam(8, $posting_date);
        $stmt->bindParam(9, $user_id); // Use the user's ID to update the correct record

        if ($stmt->execute()) {
            // Redirect or display a success message upon successful update
            header('Location: login.php');
            exit();
        } else {
            $update_error = 'Update Failed';
        }
    } catch (PDOException $e) {
        echo 'Database Error: ' . $e->getMessage();
    }
}

if (isset($_GET["email"])) {
    $email = $_GET["email"];
    echo '<input type="hidden" name="email" value="' . $email . '"><br>';
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

    <title>SB Admin 2 - Register</title>
    <link rel="icon" href="img/LogoSek.ico" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body style="background-image: url(img/background4.jpg); background-size: cover;">

    <div class="container" >

        <div class="card o-hidden border-0 shadow-lg my-3" style="background-color: rgba(255, 255, 255, 0.5);">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-10" style="margin: 10px auto;">
                        <div class="p-2" style="font-size:20px">
                            <div class="text-center" style="font-size:20px">
                                <h1 class=" text-gray-900 mb-4" style="font-family: 'Your Exclusive Font', sans-serif; font-size: 36px; font-weight: bold; color: #000000; text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);">Create an Account!</h1>
                                <?php
                                if (isset($registration_error)) {
                                    echo '<p>' . $registration_error . '</p>';
                                }
                                ?>
                            </div>
                            <form class="user" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" >
                                <!-- Rounded input fields with placeholders inside -->
                                <input type="hidden" name="email" value="<?php echo $email;  ?>" style="font-size:18px">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user rounded-pill"
                                        id="name" name="name" placeholder="Name" pattern="[A-Za-z ]+" style="font-size:18px">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user rounded-pill"
                                        id="ic" name="ic" placeholder="IC Number" pattern="[0-9-]+" style="font-size:18px">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user rounded-pill"
                                        id="phone" name="phone" placeholder="Phone Number" pattern="[0-9-]+" style="font-size:18px">
                                </div>
                                <div class="form-group" >
                                    <select class="custom-select rounded-pill" id="gender" name="gender"style="font-size:18px">
                                        <option selected hidden>Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user rounded-pill"
                                        id="major" name="major" placeholder="Subject Teaching/Major" style="font-size:18px">
                                </div>
                                <div class="form-group">
                                    <select class="custom-select rounded-pill" id="position" name="position" style="font-size:18px">
                                        <option selected hidden>Position</option>
                                        <option value="Pengetua">Pengetua</option>
                                        <option value="GPK Pentadbiran">GPK Pentadbiran</option>
                                        <option value="GPK Hem">GPK Hem</option>
                                        <option value="GPK Koku">GPK Koku</option>
                                        <option value="Guru">Guru</option>
                                        <option value="Staff">Staff</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="custom-select rounded-pill" id="session" name="session" style="font-size:18px">
                                        <option selected hidden>Session</option>
                                        <option value="Pagi">Sesi Pagi</option>
                                        <option value="Petang">Sesi Petang</option>                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                <label for="posting_date" style="font-size:18px">Posting Date</label>
                                    <input type="date" class="form-control form-control-user rounded-pill"
                                        id="posting_date" name="posting_date" placeholder="Posting Date" style="font-size:18px" min="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="form-group" style="font-size:18px">
                                    <label for="pic">Profile Picture:</label>
                                    <input type="file" class="form-control-file" id="pic" name="pic" accept="image/*">
                                </div>
                                <input type="submit" class="btn btn-primary btn-user btn-block rounded-pill" name="Submit" value="Register Account"
                                style=" font-size: 16px; background: linear-gradient(45deg, #0077FF, #0033AA); color: #fff; border: 1px solid #0077FF; padding: 10px 20px; border-radius: 25px; text-transform: uppercase; font-weight: bold; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

                                <hr>
                            </form>
                            <div class="text-center">
                                <a class="small" href="forgot-password.php" style="font-size:18px; font-weight: bold;">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php" style="font-size:18px; font-weight: bold;">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <br>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>