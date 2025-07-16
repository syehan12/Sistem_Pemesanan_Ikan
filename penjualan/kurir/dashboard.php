<?php 
// untuk cek session
include_once "session.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Kurir - Dashboard</title>
    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../assets/style/sb-admin-2.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div><img src="../../assets/img/logo2.png" alt=""></div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0"></hr>
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="dt_transaksi.php">
                    <i class="fas fa-fw fa-truck"></i>
                    <span>Data Pengiriman</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="dt_transaksi_selesai.php">
                    <i class="bi bi-check"></i>
                    <span>Pengiriman Selesai</span>
                </a>
            </li>
        </ul>
        <!-- End of Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Kurir</span>
                                <img class="img-profile rounded-circle" src="../../assets/img/kongo.jpg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid px-2 px-md-4">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard Kurir</h1>
                    </div>
                    <div class="alert alert-info mb-4" style="font-size:18px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                        Selamat datang, <b>Selamat Bertugas</b>! Semoga harimu menyenangkan 😊
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pengiriman</div>
                                            <?php
                                            $sql_1 = "SELECT * FROM pemesanan WHERE status_pesanan = 'Dikirim'";
                                            $qry_1 = mysqli_query($mysqli, $sql_1) or mysqli_error($mysqli);
                                            $num_1 = mysqli_num_rows($qry_1);
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $num_1 ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <a href="dt_transaksi.php" class="card-footer text-primary small">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pesanan Selesai</div>
                                            <?php
                                            $sql_2 = "SELECT * FROM pemesanan WHERE status_pesanan = 'Terkirim'";
                                            $qry_2 = mysqli_query($mysqli, $sql_2) or mysqli_error($mysqli);
                                            $num_2 = mysqli_num_rows($qry_2);
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $num_2 ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <a href="dt_transaksi_selesai.php" class="card-footer text-success small">Lihat Selesai <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../../assets/js/sb-admin-2.min.js"></script>
    <style>
    @media (max-width: 576px) {
        .card .card-body, .alert {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        .card {
            margin-bottom: 1rem !important;
        }
    }
    </style>
</body>

</html>