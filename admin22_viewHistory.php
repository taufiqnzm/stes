<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
$username = $_SESSION['username'];
$pic = $_SESSION['pic'];
require_once "config.php"; // Use require_once to ensure it's included only once
include "restricted.php";

$current_date = date('d-m-Y');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $form_id = intval($_POST['form_id']);
    $existence = $_POST['existence'];
    $start_date = $_POST['start_date'];
    $final_date = $_POST['final_date'];
    $time_leave = $_POST['time_leave'];
    $time_back = $_POST['time_back'];
    $reason = $_POST['reason'];
    $program_name = $_POST['program_name'];
    $location = $_POST['location'];
    $organizer = $_POST['organizer'];

    // Update the database
    $updateQuery = "UPDATE applicants 
                    SET existence = :existence, start_date = :start_date, final_date = :final_date, 
                        time_leave = :time_leave, time_back = :time_back, reason = :reason, 
                        program_name = :program_name, location = :location, organizer = :organizer 
                    WHERE form_id = :form_id";

    $stmt = $conn->prepare($updateQuery);
    $stmt->bindParam(':form_id', $form_id, PDO::PARAM_INT);
    $stmt->bindParam(':existence', $existence, PDO::PARAM_STR);
    $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
    $stmt->bindParam(':final_date', $final_date, PDO::PARAM_STR);
    $stmt->bindParam(':time_leave', $time_leave, PDO::PARAM_STR);
    $stmt->bindParam(':time_back', $time_back, PDO::PARAM_STR);
    $stmt->bindParam(':reason', $reason, PDO::PARAM_STR);
    $stmt->bindParam(':program_name', $program_name, PDO::PARAM_STR);
    $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    $stmt->bindParam(':organizer', $organizer, PDO::PARAM_STR);
    $stmt->execute();

    // Redirect to avoid form resubmission
    header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$_GET['user_id']."&username=".$_GET['username']);
    exit;
}

// Retrieve user ID from the URL
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$personal_username = isset($_GET['username']) ? $_GET['username'] : null;

echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
echo '<input type="hidden" name="username" value="' . $personal_username . '">';

// Main showQuery to fetch data for absent teachers
$showQuery = "SELECT applicants.form_id, applicants.name, DATE_FORMAT(applicants.start_date, '%d-%m-%Y') AS start_date, 
                 DATE_FORMAT(applicants.final_date, '%d-%m-%Y') AS final_date,
                 applicants.time_leave, applicants.time_back, applicants.reason, applicants.existence, 
                 applicants.program_name, applicants.location, applicants.organizer
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.user_id = :user_id
          ORDER BY applicants.start_date DESC, applicants.time_leave DESC";

// Execute the main showQuery
$stmt = $conn->prepare($showQuery);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$teachers = array();

foreach ($result as $row) {
    $teachers[] = $row;
}

// Get the number of rows
$personal_history_count = $stmt->rowCount();

// Close the database connection
$conn = null;
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
                            </div> -->
                        <!-- </li> -->

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
                        <h1 class="h3 mb-0 text-gray-900"><?php echo $personal_username . '`s '; ?>Personal History</h1>
                        <!-- <a href="#" id="list_absent" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: 18px;">
                                                Personal History</div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $personal_history_count . " Hari"; ?></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="progress progress-sm mr-2">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                style="width: <?php echo $personal_history_count; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-xl-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary" style="font-size: 18px;">Recent updates</h6>
                                    <div class="col-sm-4">
                                        <!-- <input type="date" class="form-control" id="inputStartDate" name="start_date"> -->
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body" style="font-size: 20px;">
                                    <div class="table-responsive">
                                        <table id="teachers" class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Existence</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Time</th>
                                                <th scope="col">Reason</th>
                                                <th scope="col">Program Name</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Organizer</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($teachers as $index => $teacher): ?>
                                                <tr>
                                                    <td><?php echo $index + 1; ?></td>
                                                    <td><?php echo $teacher['name']; ?></td>
                                                    <td><?php echo $teacher['existence']; ?></td>                                                
                                                    <td><?php echo $teacher['start_date'] . ' - ' . $teacher['final_date']; ?></td>
                                                    <td><?php echo $teacher['time_leave'] . ' - ' . $teacher['time_back']; ?></td>
                                                    <td><?php echo $teacher['reason']; ?></td>
                                                    <td><?php echo $teacher['program_name']; ?></td>
                                                    <td><?php echo $teacher['location']; ?></td>
                                                    <td><?php echo $teacher['organizer']; ?></td>
                                                    <td>
                                                        <?php if ($teacher['start_date'] == $current_date): ?>
                                                            <!-- Edit button triggers the modal -->
                                                            <button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#editModal<?php echo $index; ?>">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>

                                                <!-- Modal for this specific row -->
                                                <div class="modal fade" id="editModal<?php echo $index; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $index; ?>" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form method="post" action="">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel<?php echo $index; ?>">Edit Information</h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="form_id" value="<?php echo $teacher['form_id']; ?>">
                                                                    <div class="form-group">
                                                                        <label for="editName<?php echo $index; ?>">Name</label>
                                                                        <input type="text" class="form-control" id="editName<?php echo $index; ?>" name="name" value="<?php echo htmlspecialchars($teacher['name']); ?>" readonly>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="inputExistences<?php echo $index; ?>" class="col-sm-4 col-form-label">Existences <span class="required"></span></label>
                                                                        <div class="col-sm-12">
                                                                            <select class="custom-select inputExistences" id="inputExistences<?php echo $index; ?>" name="existence">
                                                                                <option hidden selected>Select Existence</option>
                                                                                <option value="Absent" <?php if ($teacher['existence'] === 'Absent') echo 'selected'; ?>>Ketidakhadiran</option>
                                                                                <option value="Official Business" <?php if ($teacher['existence'] === 'Official Business') echo 'selected'; ?>>Urusan Rasmi</option>
                                                                                <option value="Emergency" <?php if ($teacher['existence'] === 'Emergency') echo 'selected'; ?>>Kecemasan</option>
                                                                                <option value="Keberadaan Jam" <?php if ($teacher['existence'] === 'Keberadaan Jam') echo 'selected'; ?>>Keberadaan Jam</option>
                                                                                <option value="CRK" <?php if ($teacher['existence'] === 'CRK') echo 'selected'; ?>>Cuti Rehat Khas</option>
                                                                                <option value="Haji Umrah" <?php if ($teacher['existence'] === 'Haji Umrah') echo 'selected'; ?>>Cuti Haji & Umrah</option>
                                                                                <option value="Cuti Bersalin" <?php if ($teacher['existence'] === 'Cuti Bersalin') echo 'selected'; ?>>Cuti Bersalin</option>
                                                                                <option value="Cuti Lain" <?php if ($teacher['existence'] === 'Cuti Lain') echo 'selected'; ?>>Cuti Lain</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <?php
                                                                            $startDate = isset($teacher['start_date']) ? date('Y-m-d', strtotime($teacher['start_date'])) : '';
                                                                            $finalDate = isset($teacher['final_date']) ? date('Y-m-d', strtotime($teacher['final_date'])) : '';
                                                                        ?>
                                                                        <label for="inputStartDate<?php echo $index; ?>" class="col-sm-6 col-form-label">Start Date<span class="required"></span></label>
                                                                        <label for="inputFinalDate<?php echo $index; ?>" class="col-sm-6 col-form-label">Final Date<span class="required"></span></label>
                                                                        <div class="col-sm-6">
                                                                            <input type="date" class="form-control" id="inputStartDate<?php echo $index; ?>" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>" required>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <input type="date" class="form-control" id="inputFinalDate<?php echo $index; ?>" name="final_date" value="<?php echo htmlspecialchars($finalDate); ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="inputStartTime<?php echo $index; ?>" class="col-sm-6 col-form-label">Time Out<span class="required">*</span></label>
                                                                        <label for="inputFinalTime<?php echo $index; ?>" class="col-sm-6 col-form-label">Time In<span class="required">*</span></label>
                                                                        <div class="col-sm-6">
                                                                            <input type="time" class="form-control" id="inputStartTime<?php echo $index; ?>" name="time_leave" value="<?php echo htmlspecialchars($teacher['time_leave']); ?>" required>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <input type="time" class="form-control" id="inputFinalTime<?php echo $index; ?>" name="time_back" value="<?php echo htmlspecialchars($teacher['time_back']); ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="editReason<?php echo $index; ?>">Reason</label>
                                                                        <input type="text" class="form-control" id="editReason<?php echo $index; ?>" name="reason" value="<?php echo htmlspecialchars($teacher['reason']); ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="editProgramName<?php echo $index; ?>">Program Name</label>
                                                                        <input type="text" class="form-control" id="editProgramName<?php echo $index; ?>" name="program_name" value="<?php echo htmlspecialchars($teacher['program_name']); ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="editLocation<?php echo $index; ?>">Location</label>
                                                                        <input type="text" class="form-control" id="editLocation<?php echo $index; ?>" name="location" value="<?php echo htmlspecialchars($teacher['location']); ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="editOrganizer<?php echo $index; ?>">Organizer</label>
                                                                        <input type="text" class="form-control" id="editOrganizer<?php echo $index; ?>" name="organizer" value="<?php echo htmlspecialchars($teacher['organizer']); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
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
    // Event listener for all inputExistences elements
    document.querySelectorAll('.inputExistences').forEach(function(selectElement) {
        selectElement.addEventListener('change', function() {
            var index = this.id.replace('inputExistences', ''); // Extract the index from the element ID
            var selectedExistence = this.value;

            // Hide all condition-specific fields
            document.querySelector('.programFields' + index).style.display = 'none';
            document.querySelector('.reasonFields' + index).style.display = 'none';

            // Show fields based on selected existence
            if (selectedExistence === 'Official Business') {
                document.querySelector('.programFields' + index).style.display = 'block';
            } else if (selectedExistence === 'Absent' || selectedExistence === 'Emergency') {
                document.querySelector('.reasonFields' + index).style.display = 'block';
            }
            // Add more conditions as needed
        });
    });
</script>

    <!-- Bootstrap CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

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