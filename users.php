<?php
session_start();
$username = $_SESSION['username'];
$pic = $_SESSION['pic'];
require_once "config.php"; // Use require_once to ensure it's included only once
include "restricted.php";
include "count_personal_existences.php";

// Modify the query to select the 'pic' column
$user_id = $_SESSION['user_id'];
$query = "SELECT username, name, email, phone, address, major, pic FROM users WHERE user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

if ($stmt && $stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $username = $row['username'];
    $fullname = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $major = $row['major'];
    $address = $row['address'];
    $pic = $row['pic']; 
} else {
    // Handle the case where user information is not found
    $username = "";
    $fullname = "User Not Found";
    $email = "";
    $phone = "";
    $major = "";
    $address = "";
    $pic = "img/userprofile.jpg"; // Provide a default image URL
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
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Cache-Control" content="post-check=0, pre-check=0">
    <meta http-equiv="Pragma" content="no-cache">


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

        /* Style for the profile picture */
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
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
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
                        <h1 class="h3 mb-0 text-gray-900">PROFILE USER</h1>
                    </div>

                    <!-- Content Row -->
                        <div class="row">
                            <section style="background-color: #eee; width: 100%;">
                                <div class="container py-4">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card mb-4">
                                            <div class="card-body text-center">
                                            <img src="<?php echo $pic; ?>" alt="avatar"
                                                class="rounded-circle img-fluid" style="width: 250px; height: 250px;">
                                            <h6 class="my-3" style="font-size: 18px;"><?php echo $username; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <p class="mb-0">Full Name</p>
                                            </div>
                                            <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $fullname; ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <p class="mb-0">Email</p>
                                            </div>
                                            <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $email; ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <p class="mb-0">Phone</p>
                                            </div>
                                            <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $phone;  ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <p class="mb-0">Major</p>
                                            </div>
                                            <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $major; ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                            <p class="mb-0">Address</p>
                                            </div>
                                            <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $address; ?></p>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                  </section>
                                  <!-- Content Row -->
                                    <div class="row" style="background-color: #eee; width: 100%; margin-left:0.3px">

                                        <!-- Earnings (Monthly) Card Example -->
                                        <div class="col-xl-3 col-lg-6 mb-4" >
                                            <div class="card border-left-warning shadow h-100 py-2">
                                                <a href="absent_personal.php" style="color: burlywood;">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 18px;">
                                                                    Ketidakhadiran</div>
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col-auto">
                                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $absent_personal_count . " Hari"; ?></div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="progress progress-sm mr-2">
                                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                                    style="width: <?php echo $absent_personal_count ; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                                                    aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-user-injured fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Earnings (Monthly) Card Example -->
                                        <div class="col-xl-3 col-md-6 mb-4">
                                            <div class="card border-left-info shadow h-100 py-2">
                                                <a href="official_business_personal.php" style="color: rgb(14, 186, 189);">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: 18px;">Urusan Rasmi
                                                                </div>
                                                                <div class="row no-gutters align-items-center">
                                                                    <div class="col-auto">
                                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $official_business_personal_count . " Hari"; ?></div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="progress progress-sm mr-2">
                                                                                <div class="progress-bar bg-info" role="progressbar"
                                                                                    style="width: <?php echo $official_business_personal_count; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                                                    aria-valuemax="100"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Pending Requests Card Example -->
                                        <div class="col-xl-3 col-md-6 mb-4">
                                            <div class="card border-left-danger shadow h-100 py-2">
                                                <a href="emergency_personal.php" style="color:rgb(197, 39, 39);">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-size: 18px;">
                                                                    Kecemasan</div>
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col-auto">
                                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $emergency_personal_count . " Hari"; ?></div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="progress progress-sm mr-2">
                                                                                <div class="progress-bar bg-danger" role="progressbar"
                                                                                    style="width: <?php echo $emergency_personal_count; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                                                    aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- keluar kurang 4 jam -->
                                        <div class="col-xl-3 col-md-6 mb-4">
                                            <div class="card" style="border-left: 4px solid #C2187F; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding:0.5rem;">
                                                <a href="others_personal.php" style="color:#C2187F">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text text-uppercase mb-1" style="font-size: 18px;color:#C2187F;">
                                                                    Keberadaan 4 jam</div>
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col-auto">
                                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $keberadaan_jam_personal_count . " Hari"; ?></div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="progress progress-sm mr-2">
                                                                                <div class="progress-bar bg-dark" role="progressbar"
                                                                                    style="width: <?php echo $keberadaan_jam_personal_count; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                                                    aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6 mb-4">
                                            <div class="card border-left-dark shadow h-100 py-2" style="color:#5a5c69">
                                                <a href="crk_personal.php" style="color:#5a5c69">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text text-uppercase mb-1" style="font-size: 18px;color:#5a5c69;">
                                                                    Cuti Rehat Khas - CRK</div>
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col-auto">
                                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $cuti_rehat_khas_personal_count . " Hari"; ?></div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="progress progress-sm mr-2">
                                                                                <div class="progress-bar bg-dark" role="progressbar"
                                                                                    style="width: <?php echo $cuti_rehat_khas_personal_count; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                                                    aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-home fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- Haji & Umrah -->
                                        <div class="col-xl-3 col-md-6 mb-4">
                                            <div class="card border-left-success shadow h-100 py-2" style="color:rgb(22, 160, 133);">
                                                <a href="hajiUmrah_personal.php" style="color:rgb(22, 160, 133);">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text text-uppercase mb-1" style="font-size: 18px;color:rgb(22, 160, 133);">
                                                                    Cuti Haji & Umrah</div>
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col-auto">
                                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $cuti_hajiUmrah_personal_count . " Hari"; ?></div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="progress progress-sm mr-2">
                                                                                <div class="progress-bar bg-success" role="progressbar"
                                                                                    style="width: <?php echo $cuti_hajiUmrah_personal_count; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                                                    aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-kaaba fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Cuti bersalin -->
                                        <div class="col-xl-3 col-md-6 mb-4">
                                            <div class="card" style="border-left: 4px solid #F227CD; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding:0.5rem;">
                                                <a href="bersalin_personal.php" style="color:#F227CD">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text text-uppercase mb-1" style="font-size: 18px;color:#F227CD;">
                                                                    Cuti Bersalin</div>
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col-auto">
                                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $cuti_bersalin_personal_count . " Hari"; ?></div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="progress progress-sm mr-2">
                                                                                <div class="progress-bar bg-dark" role="progressbar"
                                                                                    style="width: <?php echo $cuti_bersalin_personal_count; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                                                    aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-baby fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- cuti lain -->
                                        <div class="col-xl-3 col-md-6 mb-4">
                                            <div class="card" style="border-left: 4px solid #AF27F2; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding:0.5rem;">
                                                <a href="cutiLain_personal.php" style="color:#AF27F2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text text-uppercase mb-1" style="font-size: 18px;color:#AF27F2;">
                                                                    Cuti Lain</div>
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col-auto">
                                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $cuti_lain_personal_count . " Hari"; ?></div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="progress progress-sm mr-2">
                                                                                <div class="progress-bar bg-dark" role="progressbar"
                                                                                    style="width: <?php echo $cuti_lain_personal_count; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                                                    aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-layer-group fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
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

    <script>
        // Detect the back button click
        window.addEventListener("popstate", function(event) {
            // Redirect to the index page or any other desired page
            window.location.href = "index.php";
        });
    </script>

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

</body>
</html>