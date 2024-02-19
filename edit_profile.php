<?php
session_start();
require_once "config.php"; // Use require_once to ensure it's included only once
include "restricted.php";

$user_id = $_SESSION['user_id'];
$query = "SELECT pic, username ,name, email, phone, address, major FROM users WHERE user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindValue(':user_id', $user_id);
$stmt->execute();
$modalMessage = '';
$modalId = '';

if ($stmt && $stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $pic = $row['pic'];
    $username = $row['username'];
    $fullname = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $major = $row['major'];
    $address = $row['address'];
} else {
    // Handle the case where user information is not found
    $pic = "";
    $username = "";
    $fullname = "User Not Found";
    $email = "";
    $phone = "";
    $major = "";
    $address = "";
}

if (isset($_POST['save'])) {
    // Form was submitted; handle the update.
    $user_id = $_POST['user_id'];
    $newUsername = $_POST['username'];
    $newFullname = $_POST['name'];
    $newEmail = $_POST['email'];
    $newPhone = $_POST['phone'];
    $newMajor = $_POST['major'];
    $newAddress = $_POST['address'];

    // Handle profile picture update
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Directory where profile pictures will be stored
        $uploadFile = $uploadDir . basename($_FILES['profile_picture']['name']);

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
            // Update the user's profile picture in the database
            $query = "UPDATE users SET pic = :profile_picture WHERE user_id = :user_id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':profile_picture', $uploadFile);
            $stmt->bindValue(':user_id', $user_id);

            if ($stmt->execute()) {
                // Profile picture update was successful
                $modalMessage = "Profile picture updated successfully.";
                $modalId = 'successModal';
            } else {
                // Profile picture update failed; handle the error
                $modalMessage = "Profile picture update failed. Please try again.";
                $modalId = 'errorModal';
            }
        } else {
            // File upload failed; handle the error
            $modalMessage = "Error uploading profile picture. Please try again.";
            $modalId = 'errorModal';
        }
    }

    // Input validation
    if (empty($newUsername) || empty($newFullname) || empty($newEmail) || empty($newPhone) || empty($newMajor) || empty($newAddress)) {
        echo "All fields must be filled out.";
    } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } else {
        // Update the user's profile in the database.
        $query = "UPDATE users SET username = :username, name = :name, email = :email, phone = :phone, major = :major, address = :address WHERE user_id = :user_id";
        $stmt = $conn->prepare($query);
        
        $stmt->bindValue(':name', $newFullname);
        $stmt->bindValue(':username', $newUsername);
        $stmt->bindValue(':email', $newEmail);
        $stmt->bindValue(':phone', $newPhone);
        $stmt->bindValue(':major', $newMajor);
        $stmt->bindValue(':address', $newAddress);
        $stmt->bindValue(':user_id', $user_id);
        
        if ($stmt->execute()) {
            // Update was successful
            $modalMessage = "Profile updated successfully.";
            $modalId = 'successModal';
    
            // Fetch the updated values from the database
            $query = "SELECT pic, username ,name, email, phone, address, major FROM users WHERE user_id = :user_id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();
    
            if ($stmt && $stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $pic = $row['pic'];
                $username = $row['username'];
                $fullname = $row['name'];
                $email = $row['email'];
                $phone = $row['phone'];
                $major = $row['major'];
                $address = $row['address'];

                // Update the session variables
                $_SESSION['pic'] = $pic;
                $_SESSION['username'] = $username;
            }
        } else {
            // Update failed; handle the error
            $modalMessage = "Profile update failed. Please try again.";
            $modalId = 'errorModal';
        }
    }
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

    <title>STES</title>
    <link rel="icon" href="img/LogoSek.ico" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        /* Custom CSS for the square profile picture container */
        .square-profile-picture {
            width: 150px; /* Adjust the width and height as needed to make it square */
            height: 150px;
            border: 2px solid #3498db; /* Border style */
            border-radius: 10px; /* Adjust border radius for rounded corners */
            overflow: hidden; /* Hide image overflow */
        }

        /* Style for the profile picture to fill the container */
        .square-profile-picture img {
            width: 100%; /* Make the image fill the container */
            height: auto; /* Preserve aspect ratio */
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <img src="img/LogoSek.png" alt="logoSekolah" style="height: 70px; width: auto;">
                </div>
                <span><img src="img/logoSTES_white.png" alt="logoStes" style="height: auto; width: 150px;"></span><br><br>
                <!-- <div class="sidebar-brand-text mx-3" style="font-size: 30px;">STES</div> -->
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 16px;"></i>
                    <span style="font-size: 18px;">Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading" style="font-size: 18px;">
                MAIN
            </div>

            <li class="nav-item active">
                <a class="nav-link" href="stes_form.php">
                    <i class="fas fa-fw fa-list-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 18px;">STES Form</span>
                </a>
            </li>
            
            <hr class="sidebar-divider">
            <li class="nav-item active">
                <a class="nav-link" href="users.php">
                    <i class="fas fa-fw fa-user-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 18px;">Users</span>
                </a>
        
            <hr class="sidebar-divider">
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="users.php" data-toggle="collapse" data-target="#collapseUsers"
                    aria-expanded="true" aria-controls="collapseUsers">
                    <i class="fas fa-fw fa-clock" style="font-size: 18px;"></i>
                    <span style="font-size: 18px;">History Personal</span>
                </a>
                <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded" style="font-size: 18px;">
                        <h6 class="collapse-header">Types</h6>
                        <a class="collapse-item" href="absent_personal.php">Ketidakhadiran</a>
                        <a class="collapse-item" href="official_business_personal.php">Urusan Rasmi</a>
                        <a class="collapse-item" href="emergency_personal.php">Kecemasan</a>
                        <a class="collapse-item" href="others_personal.php">Keberadaan Jam</a>
                        <a class="collapse-item" href="crk_personal.php">CRK</a>
                        <a class="collapse-item" href="hajiUmrah_personal.php">Cuti Haji & Umrah</a>
                        <a class="collapse-item" href="bersalin_personal.php">Cuti Bersalin</a>
                        <a class="collapse-item" href="cutiLain_personal.php">Cuti Lain</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">

            <li class="nav-item active">
                <a class="nav-link" href="info.php">
                    <i class="fas fa-fw fa-info-circle" style="font-size: 18px;"></i>
                    <span style="font-size: 18px;">School Info</span>
                </a>
        <!-----Section Divider-------->
            <hr class="sidebar-divider">
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="settings.php">
                    <i class="fas fa-fw fa-cogs" style="font-size: 18px;"></i>
                    <span style="font-size: 18px;">Settings</span>
                </a>
        <!-----Section Divider-------->
            <hr class="sidebar-divider">
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-fw fa-sign-out-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 18px;">Log Out</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Alerts -->
                        <!-- <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i> -->
                                <!-- Counter - Alerts -->
                                <!-- <span class="badge badge-danger badge-counter">2+</span>
                            </a> -->
                            <!-- Dropdown - Alerts -->
                            <!-- <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown" style="font-size: 18px;">
                                <h6 class="dropdown-header" style="font-size: 18px;">
                                    Notifications
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2023</div>
                                        <span class="font-weight-bold">STES form approved!</span>
                                    </div>
                                </a>
                        
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2023</div>
                                        Please update your existences.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#" style="font-size: 18px;">Show All Alerts</a>
                            </div>
                        </li> -->

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small" style="font-size: 18px;"><?php echo $username; ?></span>
                                    <img class="img-profile rounded-circle"
                                        src="<?php echo $pic; ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown" style="font-size: 18px;">
                                <a class="dropdown-item" href="users.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="settings.php">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-900">SETTINGS</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <section style="background-color: #eee; width: 100%;">
                            <div class="container py-5">
                                <div class="col-lg-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <a href="edit_profile.php" style="color: black;">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <p class="mb-0">Edit Profile</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <hr>
                                            
                                            <form method="POST" action="" enctype="multipart/form-data"> 
                                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                                <!-- Place for changing profile picture -->
                                                <div class="mb-3 text-center"> <!-- Added the "text-center" class to center the contents -->
                                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                                        <img style="height: 250px; width: 250px;" src="<?php echo $pic;?>" alt=""><br>
                                                        <label for="profilePicture" class="form-label">Change Profile Picture</label>
                                                        <input type="file" class="form-control" id="profilePicture" name="profile_picture" accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $username;  ?>" pattern="[A-Za-z ]+">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="fname" class="form-label">Full Name</label>
                                                    <input type="text" class="form-control" id="fname" name="name" value="<?php echo $fullname; ?>" pattern="[A-Za-z ]+">
                                                </div>
                                                <div class="mb-3">
                                                  <label for="exampleInputEmail1" class="form-label">Email</label>
                                                  <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="<?php echo $email; ?>">
                                                  <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="PhoneNo" class="form-label">Phone Number</label>
                                                    <input type="text" class="form-control" id="PhoneNo" name="phone" value="<?php echo $phone; ?>" pattern="[0-9-]+">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="major" class="form-label">Major</label>
                                                    <input type="text" class="form-control" id="major" name="major" value="<?php echo $major; ?>" pattern="[A-Za-z ]+">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="major" class="form-label">Address</label>
                                                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>">
                                                </div>
                                                <button type="submit" class="btn btn-primary" name="save">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>                    
                    
                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            
                            
                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span style="font-size: 16px;">Copyright &copy; SMK METHODIST (ACS) SITIAWAN 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"><?php echo $modalMessage; ?></div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"><?php echo $modalMessage; ?></div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script>
        // Trigger the modal with the appropriate message and ID
        <?php if (!empty($modalId)) { ?>
            $('#<?php echo $modalId; ?>').modal('show');
        <?php } ?>
    </script>

</body>

</html>