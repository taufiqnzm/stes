<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['username']; // Retrieve the username from the session
    $pic = $_SESSION['pic']; // Retrieve the pic from the session
}
require_once "config.php"; // Use require_once to ensure it's included only once
date_default_timezone_set('Asia/Kuala_Lumpur');

$currentDate = date("Y-m-d");

// Create an array to map month numbers to month names
$monthNames = array(
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December'
);

// Parse the date and format it as "d-M-y" (day-monthName-year)
$dateParts = explode('-', $currentDate);
$formattedDate = $dateParts[2] . '-' . $monthNames[(int)$dateParts[1]] . '-' . substr($dateParts[0], -2);

// Fetch data from the "applicants" table where existence is "Absent"
$query = "SELECT COUNT(*) as absent_teacher_count
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'Absent' 
          AND :currentDate BETWEEN applicants.start_date AND applicants.final_date";

$stmt = $conn->prepare($query);
$stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$absent_teacher_count = $result['absent_teacher_count'];

// Fetch data from the "applicants" table where existence is "Official Business"
$query = "SELECT COUNT(*) as official_business_teacher_count
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'Official Business' 
          AND :currentDate BETWEEN applicants.start_date AND applicants.final_date";

$stmt = $conn->prepare($query);
$stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$official_business_teacher_count = $result['official_business_teacher_count'];

// Fetch data from the "applicants" table where existence is "Emergency"
$query = "SELECT COUNT(*) as emergency_teacher_count
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'Emergency' 
          AND :currentDate BETWEEN applicants.start_date AND applicants.final_date";

$stmt = $conn->prepare($query);
$stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$emergency_teacher_count = $result['emergency_teacher_count'];

// Fetch data from the "applicants" table where existence is "CRK"
$query = "SELECT COUNT(*) as crk_teacher_count
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'CRK' 
          AND :currentDate BETWEEN applicants.start_date AND applicants.final_date";

$stmt = $conn->prepare($query);
$stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$crk_teacher_count = $result['crk_teacher_count'];

// Fetch data from the "applicants" table where existence is "Cuti Lain"
$query = "SELECT COUNT(*) as cuti_lain_count
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'Cuti Lain' 
          AND :currentDate BETWEEN applicants.start_date AND applicants.final_date";

$stmt = $conn->prepare($query);
$stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$cuti_lain_count = $result['cuti_lain_count'];

// Fetch data from the "applicants" table where existence is "Cuti Bersalin"
$query = "SELECT COUNT(*) as cuti_bersalin_count
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'Bersalin' 
          AND :currentDate BETWEEN applicants.start_date AND applicants.final_date";

$stmt = $conn->prepare($query);
$stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$cuti_bersalin_count = $result['cuti_bersalin_count'];

// Fetch data from the "applicants" table where existence is "Cuti hajiUmrah"
$query = "SELECT COUNT(*) as cuti_hajiUmrah_count
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'Haji Umrah' 
          AND :currentDate BETWEEN applicants.start_date AND applicants.final_date";

$stmt = $conn->prepare($query);
$stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$cuti_hajiUmrah_count = $result['cuti_hajiUmrah_count'];

// Fetch data from the "applicants" table where existence is "keberadaan jam"
$query = "SELECT COUNT(*) as keberadaan_jam_count
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'Keberadaan Jam' 
          AND :currentDate BETWEEN applicants.start_date AND applicants.final_date";

$stmt = $conn->prepare($query);
$stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$keberadaan_jam_count = $result['keberadaan_jam_count'];

$total_person_count = $emergency_teacher_count + $official_business_teacher_count + $absent_teacher_count + $crk_teacher_count + $cuti_lain_count + $cuti_bersalin_count + $cuti_hajiUmrah_count + $keberadaan_jam_count;

// Check if a record for the current date already exists in the database
$checkQuery = "SELECT COUNT(*) as count FROM dashboard WHERE `date` = :currentDate";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
$checkStmt->execute();
$recordCount = $checkStmt->fetch(PDO::FETCH_ASSOC)['count'];

if ($recordCount > 0) {
    // Update the existing record for the current date
    $updateQuery = "UPDATE dashboard
                    SET absent_teacher_count = :absent_teacher_count,
                        official_business_teacher_count = :official_business_teacher_count,
                        emergency_teacher_count = :emergency_teacher_count,
                        crk_teacher_count = :crk_teacher_count,
                        cuti_lain_count = :cuti_lain_count,
                        cuti_bersalin_count = :cuti_bersalin_count,
                        cuti_hajiUmrah_count = :cuti_hajiUmrah_count,
                        keberadaan_jam_count = :keberadaan_jam_count,
                        total_person_count = :total_person_count,
                        last_updated = NOW()
                    WHERE `date` = :currentDate";

    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
    $updateStmt->bindParam(':absent_teacher_count', $absent_teacher_count, PDO::PARAM_INT);
    $updateStmt->bindParam(':official_business_teacher_count', $official_business_teacher_count, PDO::PARAM_INT);
    $updateStmt->bindParam(':emergency_teacher_count', $emergency_teacher_count, PDO::PARAM_INT);
    $updateStmt->bindParam(':crk_teacher_count', $crk_teacher_count, PDO::PARAM_INT);
    $updateStmt->bindParam(':cuti_lain_count', $cuti_lain_count, PDO::PARAM_INT);
    $updateStmt->bindParam(':cuti_bersalin_count', $cuti_bersalin_count, PDO::PARAM_INT);
    $updateStmt->bindParam(':cuti_hajiUmrah_count', $cuti_hajiUmrah_count, PDO::PARAM_INT);
    $updateStmt->bindParam(':keberadaan_jam_count', $keberadaan_jam_count, PDO::PARAM_INT);
    $updateStmt->bindParam(':total_person_count', $total_person_count, PDO::PARAM_INT);
    $updateStmt->execute();

} else {
    // Insert a new record for the current date
    $insertQuery = "INSERT INTO dashboard (`date`, absent_teacher_count, official_business_teacher_count, emergency_teacher_count, crk_teacher_count, cuti_lain_count, cuti_bersalin_count, cuti_hajiUmrah_count, keberadaan_jam_count, total_person_count, last_updated)
                    VALUES (:currentDate, :absent_teacher_count, :official_business_teacher_count, :emergency_teacher_count, :crk_teacher_count, :cuti_lain_count, :cuti_bersalin_count, :cuti_hajiUmrah_count, :keberadaan_jam_count, :total_person_count, NOW())";

    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
    $insertStmt->bindParam(':absent_teacher_count', $absent_teacher_count, PDO::PARAM_INT);
    $insertStmt->bindParam(':official_business_teacher_count', $official_business_teacher_count, PDO::PARAM_INT);
    $insertStmt->bindParam(':emergency_teacher_count', $emergency_teacher_count, PDO::PARAM_INT);
    $insertStmt->bindParam(':crk_teacher_count', $crk_teacher_count, PDO::PARAM_INT);
    $insertStmt->bindParam(':cuti_lain_count', $cuti_lain_count, PDO::PARAM_INT);
    $insertStmt->bindParam(':cuti_bersalin_count', $cuti_bersalin_count, PDO::PARAM_INT);
    $insertStmt->bindParam(':cuti_hajiUmrah_count', $cuti_hajiUmrah_count, PDO::PARAM_INT);
    $insertStmt->bindParam(':keberadaan_jam_count', $keberadaan_jam_count, PDO::PARAM_INT);
    $insertStmt->bindParam(':total_person_count', $total_person_count, PDO::PARAM_INT);
    $insertStmt->execute();
}


// Close the database connection
$conn = null;

echo "<script>";
echo "var absentCount = $absent_teacher_count;";
echo "var officialCount = $official_business_teacher_count;";
echo "var emergencyCount = $emergency_teacher_count;";
echo "var crkCount = $crk_teacher_count;";
echo "var cutiLainCount = $cuti_lain_count;";
echo "var cutiBersalinCount = $cuti_bersalin_count;";
echo "var cutihajiUmrahCount = $cuti_hajiUmrah_count;";
echo "var keberadaanJamCount = $keberadaan_jam_count;";
echo "</script>";
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

    <!-- Include FullCalendar CSS and JavaScript -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.9.0/main.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.9.0/main.min.js"></script>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion " id="accordionSidebar">

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
            <li class="nav-item active" >
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
                                <h6 class="dropdown-header"style="font-size: 18px;">
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
                        <li class="nav-item dropdown no-arrow" >
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small" style="font-size: 18px;"><?php if (isset($_SESSION['user_id'])) { echo $username; } ?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?php if (isset($_SESSION['user_id'])) { echo $pic; } else { echo 'img/userprofile.jpg'; } ?>">
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
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard <?php echo "(" . $formattedDate . ")" ?></h1>
                        <a href="user_manual.php" class="btn btn-primary">User Manual</a>
                    </div>

                    <!-- line list teacher -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-xl-6 mb-4 " style="margin-left: 25%">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <a href="list_teacher.php">
                                    <div class="card-body ">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: 18px;">
                                                Jumlah Ketiadaan Guru</div>
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto">
                                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_person_count; ?></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="progress progress-sm mr-2">
                                                                <div class="progress-bar bg-primary" role="progressbar"
                                                                    style="width: <?php echo $total_person_count; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-lg-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <a href="absent.php" style="color: burlywood;">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 18px;">
                                                    Ketidakhadiran</div>
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $absent_teacher_count; ?></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="progress progress-sm mr-2">
                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                    style="width: <?php echo $absent_teacher_count; ?>%" aria-valuenow="50" aria-valuemin="0"
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
                                <a href="official_business.php" style="color: rgb(14, 186, 189);">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: 18px;">Urusan Rasmi
                                                </div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $official_business_teacher_count; ?></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="progress progress-sm mr-2">
                                                                <div class="progress-bar bg-info" role="progressbar"
                                                                    style="width: <?php echo $official_business_teacher_count; ?>%" aria-valuenow="50" aria-valuemin="0"
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
                                <a href="emergency.php" style="color:rgb(197, 39, 39);">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-size: 18px;">
                                                    Kecemasan</div>
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $emergency_teacher_count; ?></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="progress progress-sm mr-2">
                                                                <div class="progress-bar bg-danger" role="progressbar"
                                                                    style="width: <?php echo $emergency_teacher_count; ?>%" aria-valuenow="50" aria-valuemin="0"
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
                                <a href="others.php" style="color:#C2187F">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text text-uppercase mb-1" style="font-size: 18px;color:#C2187F;">
                                                    Keberadaan 4 jam</div>
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $keberadaan_jam_count; ?></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="progress progress-sm mr-2">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: <?php echo $keberadaan_jam_count; ?>%; background-color: #C2187F;" aria-valuenow="50" aria-valuemin="0"
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
                                <a href="crk.php" style="color:#5a5c69">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text text-uppercase mb-1" style="font-size: 18px;color:#5a5c69;">
                                                    Cuti Rehat Khas - CRK</div>
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $crk_teacher_count; ?></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="progress progress-sm mr-2">
                                                                <div class="progress-bar bg-dark" role="progressbar"
                                                                    style="width: <?php echo $crk_teacher_count; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-home  fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- Haji & Umrah -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2" style="color:rgb(22, 160, 133);">
                                <a href="hajiUmrah.php" style="color:rgb(22, 160, 133);">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text text-uppercase mb-1" style="font-size: 18px;color:rgb(22, 160, 133);">
                                                    Cuti Haji & Umrah</div>
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $cuti_hajiUmrah_count; ?></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="progress progress-sm mr-2">
                                                                <div class="progress-bar bg-success" role="progressbar"
                                                                    style="width: <?php echo $cuti_hajiUmrah_count; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-kaaba  fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Cuti bersalin -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card" style="border-left: 4px solid #F227CD; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding:0.5rem;">
                                <a href="bersalin.php" style="color:#F227CD">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text text-uppercase mb-1" style="font-size: 18px;color:#F227CD;">
                                                    Cuti Bersalin</div>
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $cuti_bersalin_count; ?></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="progress progress-sm mr-2">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: <?php echo $cuti_bersalin_count; ?>%; background-color: #F227CD;" aria-valuenow="50" aria-valuemin="0"
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
                                <a href="cutiLain.php" style="color:#AF27F2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text text-uppercase mb-1" style="font-size: 18px;color:#AF27F2;">
                                                    Cuti Lain</div>
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $cuti_lain_count; ?></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="progress progress-sm mr-2">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: <?php echo $cuti_lain_count; ?>%; background-color: #AF27F2;" aria-valuenow="50" aria-valuemin="0"
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

                    <!-- chart -->
                    <div class="row">
                        <!-- Donut Chart -->
                        <div class="col-xl-4 col-xl-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary" style="font-size: 18px;">Daily Chart</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4">
                                        <!-- Enlarged Pie Chart Canvas -->
                                        <canvas id="myPieChart" width="400" height="400"></canvas>
                                    </div>
                                    <hr>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="calendar"></div>
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
