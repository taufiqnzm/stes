<?php
session_start();
$username = $_SESSION['username'];
$pic = $_SESSION['pic'];
include "restricted.php";
$modalMessage = '';
$modalId = '';

if (isset($_POST["submit"])) {
    $target_dir = "uploadInfo/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if ($check = getimagesize($_FILES["fileToUpload"]["tmp_name"])) {
        $modalMessage = "File is an image - " . $check["mime"] . ".";
        $modalId = 'successModal';
        $uploadOk = 1;
    } else {
        $modalMessage = "File is not an image.";
        $modalId = 'errorModal';
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $modalMessage = "Sorry, file already exists.";
        $modalId = 'errorModal';
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $modalMessage = "Sorry, your file is too large.";
        $modalId = 'errorModal';
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
        $modalMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $modalId = 'errorModal';
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $modalMessage = "Sorry, your file was not uploaded.";
        $modalId = 'errorModal';
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $modalMessage = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            $modalId = 'successModal';
        } else {
            $modalMessage = "Sorry, there was an error uploading your file.";
            $modalId = 'errorModal';
        }
    }
}

if (isset($_POST["delete"])) {
    $imageToDelete = $_POST['imageToDelete'];

    if (file_exists($imageToDelete)) {
        unlink($imageToDelete);
        $modalMessage = "Image deleted successfully.";
        $modalId = 'successModal';
    } else {
        $modalMessage = "Image not found.";
        $modalId = 'errorModal';
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

    <title>STES - Admin</title>
    <link rel="icon" href="img/LogoSek.ico" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .carousel-control-prev,
        .carousel-control-next {
            border: none;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #your_desired_color; /* Change this to your preferred color */
            color: #fff; /* Change this to the text color you want */
            border-radius: 50%; /* Optional: Make the buttons round */
        }

        /* change the size of the carousel control buttons */
        .carousel-control-prev,
        .carousel-control-next {
            font-size: 1.5rem; 
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin1_dashboard.php">
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
                <a class="nav-link" href="admin1_dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 18px;">Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading" style="font-size: 18px;">
                MAIN
            </div>

            <li class="nav-item active">
                <a class="nav-link" href="admin8_stesForm.php">
                    <i class="fas fa-fw fa-list-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 18px;">STES Form</span>
                </a>
            </li>
            <hr class="sidebar-divider">

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-chart-bar" style="font-size: 18px;"></i>
                    <span style="font-size: 18px;">Management</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded" style="font-size: 18px;">
                    <h6 class="collapse-header" style="font-size: 18px;">Types</h6>
                        <a class="collapse-item" href="admin2_listTeacher.php">Jumlah Ketiadaan<br>Guru</a>
                        <a class="collapse-item" href="admin3_absent.php">Ketidakhadiran</a>
                        <a class="collapse-item" href="admin4_OfficialBusiness.php">Urusan Rasmi</a>
                        <a class="collapse-item" href="admin5_emergency.php">Kecemasan</a>
                        <a class="collapse-item" href="admin21_others.php">Keberadaan Jam </a>
                        <a class="collapse-item" href="admin17_crk.php">Cuti Rehat Khas</a>
                        <a class="collapse-item" href="admin18_hajiUmrah.php">Cuti Haji & Umrah</a>
                        <a class="collapse-item" href="admin19_bersalin.php">Cuti Bersalin</a>
                        <a class="collapse-item" href="admin20_cutiLain.php">Cuti Lain</a>
                        
                        <!-- <a class="collapse-item" href="admin6_stesFrom.php">STES Form</a> -->
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item active">
                <a class="nav-link" href="admin6_history.php">
                    <i class="fas fa-fw fa-clock" style="font-size: 18px;"></i>
                    <span style="font-size: 18px;">History</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item active">
                <a class="nav-link" href="admin7_users.php">
                    <i class="fas fa-fw fa-user-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 18px;">Users</span>
                </a>
        
            <!-- <hr class="sidebar-divider"> -->
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="users.php" data-toggle="collapse" data-target="#collapseUsers"
                    aria-expanded="true" aria-controls="collapseUsers">
                    <i class="fas fa-fw fa-clock"></i>
                    <span>History Personal</span>
                </a>
                <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Types</h6>
                        <a class="collapse-item" href="absent_personal.php">Absent</a>
                        <a class="collapse-item" href="official_business_personal.php">Official Business</a>
                        <a class="collapse-item" href="emergency_personal.php">Emergency</a>
                    </div>
                </div>
            </li> -->
            <hr class="sidebar-divider">

            <li class="nav-item active">
                <a class="nav-link" href="admin11_adminInfo.php">
                    <i class="fas fa-fw fa-info-circle" style="font-size: 18px;"></i>
                    <span style="font-size: 18px;">School Info</span>
                </a>
        <!-----Section Divider-------->
            <hr class="sidebar-divider">
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="admin12_settingAdmin.php">
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
                                <i class="fas fa-bell fa-fw" style="font-size: 18px;"></i> -->
                                <!-- Counter - Alerts -->
                                <!-- <span class="badge badge-danger badge-counter" >2+</span>
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
                                <a class="dropdown-item" href="admin7_users.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="admin12_settingAdmin.php">
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
                        <h1 class="h3 mb-0 text-gray-800">INFORMATION</h1>
                        <!-- <button class="btn btn-dark" id="post-plus-button" style="font-size: 18px;">Post | +</button> -->
                    </div>

                    <!-- Content Row -->
                    <div class="row justify-content-center">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-lg-5 col-lg-5 ">
                            <!-- Add the following HTML code to create a form for image upload with enhanced button styling -->
                            <form action="" method="post" enctype="multipart/form-data" class="mt-10">
                                <div class="input-group">
                                    <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" style="display: none;">
                                        <label for="fileToUpload" class="btn btn-dark" style="font-size: 18px;">
                                            Choose Image
                                        </label>
                                </div>
                                <input type="submit" value="Upload Image" name="submit" onclick="return checkImage();" class="btn btn-success" id="uploadImageBtn" style="font-size: 18px;"><br><br>
                                
                            </form>

                            <div class="card shadow mb-4 ps-10">

                                <!-- Display uploaded images in the carousel -->
                                <div id="carouselExampleIndicators" class="carousel slide " data-bs-ride="carousel">
                                    <div class="carousel-indicators ">
                                        <?php
                                        $imageFolder = "uploadInfo/"; // Change this to your actual image folder
                                        $images = glob($imageFolder . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                                        
                                        foreach ($images as $key => $image) {
                                            $activeClass = ($key == 0) ? 'active' : '';
                                            echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' . $key . '" class="' . $activeClass . '"></button>';
                                        }
                                        ?>
                                    </div>
                                    <div class="carousel-inner " >
                                        <?php
                                        foreach ($images as $key => $image) {
                                            $activeClass = ($key == 0) ? 'active' : '';
                                            echo '<div class="carousel-item ' . $activeClass . '">';
                                            echo '<img src="' . $image . '" class="d-block w-100" alt="Slide ' . ($key + 1) . '">';
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <!-- <span class="visually-hidden"></span> -->
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <!-- <span class="visually-hidden"></span> -->
                                    </button>
                                </div>

                                <!-- <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                                            aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                                            aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                                            aria-label="Slide 3"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="img/sekolah.jpg" class="d-block w-100" alt="sekolah">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="img/1.jpg" class="d-block w-100" alt="event1">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="img/2.jpg" class="d-block w-100" alt="event2">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div> -->
                            </div>
                            <!-- Add the following HTML code to create a form for image deletion with enhanced button styling -->
                            <form action="" method="post" class="mt-3">
                                <div class="input-group">
                                    <select name="imageToDelete" class="form-select">
                                        <?php
                                        foreach ($images as $key => $image) {
                                            echo '<option value="' . $image . '">Slide ' . ($key + 1) . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <input type="submit" name="delete" value="Delete Image" class="btn btn-danger">
                                </div>
                            </form>
                        </div>                        
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        

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

    <!-- Custom Modal for "Choose Image First" -->
    <div class="modal fade" id="chooseImageModal" tabindex="-1" role="dialog" aria-labelledby="chooseImageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chooseImageModalLabel">Attention</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <!-- <span aria-hidden="true">×</span> -->
                    </button>
                </div>
                <div class="modal-body">
                    Please choose an image before uploading.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

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
            <div class="modal-content" style="font-size: 18px;">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            <?php if ($modalId === 'successModal' || $modalId === 'errorModal'): ?>
                $('#<?php echo $modalId; ?>').modal('show');
            <?php endif; ?>

            // Add this script to handle modal dismissal
            $('#<?php echo $modalId; ?>').on('hidden.bs.modal', function (e) {
                // Reset the form inside the modal
                $(this).find('form')[0].reset();
            });

            // Add this script to handle modal dismissal on OK button click
            $('.modal-footer .btn-primary').on('click', function () {
                $('#<?php echo $modalId; ?>').modal('hide');
            });

            // Add an event listener for the "OK" button inside chooseImageModal
            $('#chooseImageModal .btn-primary').on('click', function () {
                $('#chooseImageModal').modal('hide');
            });

            // Script for preventing form submission without choosing an image
            $('#uploadForm').submit(function (e) {
                if ($('#fileToUpload').val() === "") {
                    e.preventDefault();
                    $('#chooseImageModal').modal('show');
                }
            });
        });

        function checkImage() {
            console.log('checkImage called');
            if ($('#fileToUpload').val() === "") {
                $('#chooseImageModal').modal('show');
                return false; // Prevent form submission
            } else {
                $('#chooseImageModal').modal('hide'); // Close the modal
                return true; // Allow form submission
            }
        }
    </script>

</body>

</html>