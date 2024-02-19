<?php
session_start();
$username = $_SESSION['username'];
$pic = $_SESSION['pic'];
// $teacher_session = $_SESSION['teacher_session'];
require_once('config.php'); // Include your database configuration file
include "restricted.php";
date_default_timezone_set('Asia/Kuala_Lumpur');

// // Check if the user's session is 'Sesi Pagi' and the current time is between 7am-1pm
// if ($teacher_session === 'Sesi Pagi' && (date('H') >= 7 && date('H') < 13)) {
//     header("Location: limit_session.html");
//     exit;
// }

// // Check if the user's session is 'Sesi Malam' and the current time is between 1pm-7pm
// if ($teacher_session === 'Sesi Malam' && (date('H') >= 13 && date('H') < 19)) {
//     header("Location: limit_session.html");
//     exit;
// }

// Check if a login status message is set in the session
if (isset($_SESSION['login_status'])) {
    $login_status = $_SESSION['login_status'];
    unset($_SESSION['login_status']); // Remove the login status message
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $existence = $_POST['existence'];
    $start_date = $_POST['start_date'];
    $final_date = $_POST['final_date'];
    $location = $_POST['location'];
    $program_name = $_POST['program_name'];
    $organizer = $_POST['organizer'];
    $time_leave = $_POST['time_leave'];
    $time_back = $_POST['time_back'];
    $reason = $_POST['reason'];
    $selected_users = $_POST['selected_users'];
    $leave_type = $_POST['leave_type'];

    $insert_sql = "";

        // Prepare the INSERT statement based on the existence type
        if ($existence === 'Official Business') {
                $evidence = $_FILES['evidence'];
                $target_directory = "uploads/";
                $target_file = $target_directory . basename($evidence["name"]);

                if (!is_dir($target_directory)) {
                    mkdir($target_directory, 0777, true);
                }

                if (move_uploaded_file($evidence["tmp_name"], $target_file)) {
                    $insert_sql = "INSERT INTO applicants (user_id, existence, program_name, location, organizer, start_date, final_date, time_leave, time_back, evidence, name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                } else {
                    echo "<script>alert('File upload failed');</script>";
                }
                
        } else if ($existence === 'Absent' || $existence === 'Emergency') {
            // For Absent, Emergency and Cuti Lain
            $insert_sql = "INSERT INTO applicants (user_id, existence, start_date, final_date, time_leave, time_back, location, reason, name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        } else if ($existence === 'Cuti Lain') {
            // For Absent, Emergency and Cuti Lain
            $insert_sql = "INSERT INTO applicants (user_id, existence, start_date, final_date, time_leave, time_back, location, leave_type, name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        } else {
            $insert_sql = "INSERT INTO applicants (user_id, existence, start_date, final_date, time_leave, time_back, location, name) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        }

        try {
            foreach ($selected_users as $selected_user_id) {
                // Fetch the user name from the Users table
                $fetch_user_name_query = "SELECT name FROM users WHERE user_id = ?";
                $fetch_user_name_stmt = $conn->prepare($fetch_user_name_query);
                $fetch_user_name_stmt->bindParam(1, $selected_user_id);
                $fetch_user_name_stmt->execute();
                $result = $fetch_user_name_stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $selected_user_name = $result['name'];
                } else {
                    // Handle the case where user name is not found
                    $selected_user_name = "Unknown"; // You can set a default value or handle it according to your requirements
                }

                $stmt = $conn->prepare($insert_sql);

                if ($existence === 'Official Business') {
                    $stmt->bindParam(1, $selected_user_id);
                    $stmt->bindParam(2, $existence);
                    $stmt->bindParam(3, $program_name);
                    $stmt->bindParam(4, $location);
                    $stmt->bindParam(5, $organizer);
                    $stmt->bindParam(6, $start_date);
                    $stmt->bindParam(7, $final_date);
                    $stmt->bindParam(8, $time_leave);
                    $stmt->bindParam(9, $time_back);
                    $stmt->bindParam(10, $target_file);
                    $stmt->bindParam(11, $selected_user_name); 
                } else if ($existence === 'Absent' || $existence === 'Emergency'){
                    $stmt->bindParam(1, $selected_user_id);
                    $stmt->bindParam(2, $existence);
                    $stmt->bindParam(3, $start_date);
                    $stmt->bindParam(4, $final_date);
                    $stmt->bindParam(5, $time_leave);
                    $stmt->bindParam(6, $time_back);
                    $stmt->bindParam(7, $location);
                    $stmt->bindParam(8, $reason);
                    $stmt->bindParam(9, $selected_user_name); 
                } else if ($existence === 'Cuti Lain'){
                    $stmt->bindParam(1, $selected_user_id);
                    $stmt->bindParam(2, $existence);
                    $stmt->bindParam(3, $start_date);
                    $stmt->bindParam(4, $final_date);
                    $stmt->bindParam(5, $time_leave);
                    $stmt->bindParam(6, $time_back);
                    $stmt->bindParam(7, $location);
                    $stmt->bindParam(8, $leave_type);
                    $stmt->bindParam(9, $selected_user_name); 
                } else {
                    $stmt->bindParam(1, $selected_user_id);
                    $stmt->bindParam(2, $existence);
                    $stmt->bindParam(3, $start_date);
                    $stmt->bindParam(4, $final_date);
                    $stmt->bindParam(5, $time_leave);
                    $stmt->bindParam(6, $time_back);
                    $stmt->bindParam(7, $location);
                    $stmt->bindParam(8, $selected_user_name);
                }

                if ($stmt->execute()) {
                    echo "<script>alert('Application Submitted Successfully for User ID : {$selected_user_id}');</script>";
                } else {
                    echo "<script>alert('Application Submitted Failed for User ID : {$selected_user_id}');</script>";
                }
            }
        } catch (PDOException $e) {
            echo "<script>alert('Database Error: ');</script>" . $e->getMessage();
        }
    }

// Display the login status message (if set)
if (isset($login_status)) {
    echo $login_status;
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
        .required {
            color: red;
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
    
            </li>
            <hr class="sidebar-divider">
            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="users.php" data-toggle="collapse" data-target="#collapseUsers"
                    aria-expanded="true" aria-controls="collapseUsers">
                    <i class="fas fa-fw fa-clock"></i>
                    <span>History Personal</span>
                </a>
                <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Types</h6>
                        <a class="collapse-item" href="admin8_absentPersonal.php">Absent</a>
                        <a class="collapse-item" href="admin9_OfficialBusinessPersonal.php">Official Business</a>
                        <a class="collapse-item" href="admin10_emergencyPersonal.php">Emergency</a>
                    </div>
                </div>
            </li> -->

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
                <a class="nav-link" href="logout.php" data-toggle="modal" data-target="#logoutModal">
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
            <!-- <div class="sidebar-card d-none d-lg-flex">
                
            </div> -->

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
                                <a class="dropdown-item" href="admin12_settingAdmin.php">
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
                        <h1 class="h3 mb-0 text-gray-900">UPDATING EXISTENCES FORM</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <form class="user" action="admin8_stesForm.php" id="eventForm" method="post" enctype="multipart/form-data">
                                    <!-- <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>"> -->
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="inputUsers" class="col-sm-2 col-form-label">Select Users <span class="required">*</span></label>
                                            <div class="col-sm-10">
                                                <div class="scrollable-container" style="max-height: 150px; overflow-y: auto;">
                                                    <?php
                                                    $sql = "SELECT user_id, name, email_verified_at FROM users";
                                                    $result = $conn->query($sql);

                                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                                        // Check if email_verified_at is not NULL
                                                        if ($row['email_verified_at'] !== null) {
                                                            echo "<div class='form-check'>";
                                                            echo "<input class='form-check-input' type='checkbox' id='user{$row['user_id']}' name='selected_users[]' value='{$row['user_id']}'>";
                                                            echo "<label class='form-check-label' for='user{$row['user_id']}'>{$row['name']}</label>";
                                                            echo "</div>";
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputExistences" class="col-sm-2 col-form-label">Existences <span class="required">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="custom-select" id="inputExistences" name="existence">
                                                    <option hidden selected>Choose...</option>
                                                    <option value="Absent">Ketidakhadiran</option>
                                                    <option value="Official Business">Urusan Rasmi</option>
                                                    <option value="Emergency">Kecemasan</option>
                                                    <option value="Keberadaan Jam">Keberadaan Jam</option> 
                                                    <option value="CRK">Cuti Rehat Khas</option>
                                                    <option value="Haji Umrah">Cuti Haji & Umrah</option>
                                                    <option value="Cuti Bersalin">Cuti Bersalin</option>
                                                    <option value="Cuti Lain">Cuti Lain</option>   
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row" id="hajiUmrahFields" style="display: none;">
                                            <label for="inputHajiUmrahDuration" class="col-sm-2 col-form-label">Haji & Umrah Duration <span class="required">*</span></label>
                                            <div class="col-sm-10">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="haji_umrah_duration" id="radio40Days" value="40">
                                                    <label class="form-check-label" for="radio40Days">
                                                        40 days
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="haji_umrah_duration" id="radio2Weeks" value="14">
                                                    <label class="form-check-label" for="radio2Weeks">
                                                        2 weeks
                                                    </label>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="form-group row" id="programFields" style="display: none;">
                                            <label for="inputProgram" class="col-sm-2 col-form-label">Programme Name <span class="required">*</span></label>
                                            <div class="col-sm-10" style="float: right;">
                                                <input type="text" class="form-control" id="inputProgram" name="program_name" placeholder="Programme Name">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="locationFields" style="display: none;">
                                            <label for="inputLocation" class="col-sm-2 col-form-label">Location <span class="required">*</span></label>
                                            <div class="col-sm-10" style="float: right;">
                                                <input type="text" class="form-control" id="inputLocation" name="location" placeholder="Location">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="organizingFields" style="display: none;">
                                            <label for="inputOrganizing" class="col-sm-2 col-form-label">Organizing <span class="required">*</span></label>
                                            <div class="col-sm-10" style="float: right;">
                                                <input type="text" class="form-control" id="inputOrganizing" name="organizer" placeholder="Organizing">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="reasonFields" style="display: none;">
                                            <label for="inputReason" class="col-sm-2 col-form-label">Reason <span class="required">*</span></label>
                                            <div class="col-sm-10" style="float: right;">
                                                <input type="text" class="form-control" id="inputReason" name="reason" placeholder="Reason">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="typeFields" style="display: none;">
                                            <label for="inputType" class="col-sm-2 col-form-label">Cuti Lain <span class="required">*</span></label>
                                            <div class="col-sm-10" style="float: right;">
                                                <input type="text" class="form-control" id="inputType" name="leave_type" placeholder="Specify holiday">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputDate" class="col-sm-2 col-form-label">Start Date - Final Date <span class="required">*</span></label>
                                            <div class="col-sm-5">
                                                <input type="date" class="form-control" id="inputStartDate" name="start_date" min="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="date" class="form-control" id="inputFinalDate" name="final_date" min="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputtime" class="col-sm-2 col-form-label">Time Out - Time In <span class="required">*</span></label>
                                            <div class="col-sm-5">
                                                <input type="time" class="form-control" id="inputStartTime" name="time_leave">
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="time" class="form-control" id="inputFinalTime" name="time_back">
                                            </div>
                                        </div>

                                        <div class="form-group row" id="evidenceFields" style="display: none;">
                                            <label for="formFileMultiple" class="col-sm-2 col-form-label">Evidences </label>
                                            <div class="col-sm-10" style="float: right;">
                                                <input class="form-control" type="file" id="formFileMultiple" name="evidence" multiple>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <input type="submit" class="btn btn-primary" name="Submit" value="Submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>                       
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto" >
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



    <script>
        document.getElementById('inputExistences').addEventListener('change', function() {
            var selectedExistence = this.value;
            var programFields = document.getElementById('programFields');
            var locationFields = document.getElementById('locationFields');
            var organizingFields = document.getElementById('organizingFields');
            var reasonFields = document.getElementById('reasonFields');
            var evidenceFields = document.getElementById('evidenceFields');
            var typeFields = document.getElementById('typeFields');
            // var hajiUmrahFields = document.getElementById("hajiUmrahFields"); // Ganti variabel ini

            // Hide all fields first
            programFields.style.display = 'none';
            locationFields.style.display = 'none';
            organizingFields.style.display = 'none';
            reasonFields.style.display = 'none';
            evidenceFields.style.display = 'none';
            typeFields.style.display = 'none';
            
            // hajiUmrahFields.style.display = 'none'; // Ganti variabel ini

            // Show fields based on selected existence
            if (selectedExistence === 'Official Business') {
                programFields.style.display = 'block';
                locationFields.style.display = 'block';
                organizingFields.style.display = 'block';
                evidenceFields.style.display = 'block';
            } else if (selectedExistence === 'Absent' || selectedExistence === 'Emergency') {
                reasonFields.style.display = 'block';
            } else if (selectedExistence === 'Cuti Lain') {
                typeFields.style.display = 'block';
            }
        });
    </script>

</body>

</html>