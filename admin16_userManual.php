<?php
session_start();
$username = $_SESSION['username'];
$pic = $_SESSION['pic'];
include "restricted.php";
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
                                <a class="dropdown-item" href="admin7_users.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="admin12_setting.php">
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
                        <h1 class="h3 mb-0 text-gray-800">SETTINGS</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <section style="background-color: #eee; width: 100%;">
                            <div class="container py-5">
                                <div class="col-lg-12">
                                    <div class="card mb-4">
                                    <div class="card-body">
                                            <!-- Slider Section -->
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div id="imageSlider" class="carousel slide" data-ride="carousel">
                                                        <div class="carousel-inner">
                                                            <div class="carousel-item active">
                                                                <img src="img/manual1.jpg" class="d-block w-100" alt="Image 1">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual2.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual3.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual4.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual5.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual6.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual7.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual8.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual9.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual10.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual11.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual12.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual13.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual14.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual15.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="img/manual16.jpg" class="d-block w-100" alt="Image 2">
                                                            </div>
                                                            
                                                            <!-- Add more carousel items as needed -->
                                                        </div>
                                                        <a class="carousel-control-prev" href="#imageSlider" role="button" data-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#imageSlider" role="button" data-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Download PDF Button -->
                                            <div class="row mt-4">
                                                <div class="col-lg-12 text-center">
                                                    <a href="uploads/User Manual STES.pdf" class="btn btn-primary" download>Download User Manual PDF</a>
                                                </div>
                                            </div>
                                            <hr>
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
                    <a class="btn btn-primary" href="index.php">Logout</a>
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