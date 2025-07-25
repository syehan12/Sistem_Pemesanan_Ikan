<?php
session_start();
include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";
?>
<html>

<head>
  <title>Peternakan Ikan Mawar III </title>
  <meta name="robots" content="index, follow">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

  <link href="../assets/style/styles_user.css" rel="stylesheet" type="text/css">
  <link href="../assets/style/button.css" rel="stylesheet" type="text/css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../penjualan/assets/style/sb-admin-2.css" rel="stylesheet">
    <style type="text/css">

    .butpink {
      background-color: rgb(255, 204, 204);
      border-radius: 10px;
      font-family: auto;
    }

    .butpink:hover {
      background-color: rgb(255, 0, 102);
      cursor: pointer;
      font-family: fantasy;
    }

    .gm:hover {
      box-shadow: 2px;
    }
   </style>
    </head>

    <body id="page-top">

      <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div><img src="../../assets/img/logo2.png" alt=""></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0"></hr>
            
            
            <?php
            if (isset($_SESSION['SES_PELANGGAN'])) {
            ?>
            <!-- Maka Ketika login home tidak muncul-->
            <?php
            } else {
            ?>
            <li class="nav-item">
              <a class="nav-link" href="../../index.php">
                <i class="fas fa-home fa-fw"></i>
                <span>Home</span>
              </a>
            </li>

            <?php } ?>
             <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Produk</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Kategori Produk :</h6>
                    <?php
                      $mySql = "SELECT * FROM kategori ORDER BY nm_kategori";
                      $myQry = mysqli_query($mysqli, $mySql);
                      while($myData = mysqli_fetch_array($myQry, MYSQLI_ASSOC)) { 
                    ?>
                      <a class="collapse-item" href="?open=Barang-Kategori&Kode=<?= $myData['kd_kategori'] ?>">
                        <?= $myData['nm_kategori'] ?>
                      </a>
                    <?php } ?>
                  </div>
                </div>

                <tr>
              </li>
              <hr class="sidebar-divider">
              <div class="sidebar-heading">TRANSAKSI</div>
                <li class="nav-item">
                  <a class="nav-link" href="?open=Keranjang-Belanja" target="_self">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Keranjang Belanja</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="?open=Transaksi-Tampil" target="_self">
                    <i class="bi bi-receipt"></i>
                    <span>Tampil Transaksi</span>
                  </a>
                </li>     
                <li class="nav-item">
                    <span><?php include "buttonlog.php";?></span>
                </li>
        </ul>
          
         <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
              <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto ">

                        <li class="nav-item mx-2">
                            <a class="nav-link text-pink font-weight-bold small " href="?open=Home">HOME</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-pink font-weight-bold small" href="?open=Profil">PROFIL</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-pink font-weight-bold small" href="?open=Barang">PRODUK</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-pink font-weight-bold small" href="?open=Panduan">PANDUAN</a>
                        </li>

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <?php
                        if (isset($_SESSION['SES_PELANGGAN'])) {
                        ?>
                        <!-- Nav Item INFO LOGIN ADA ALERTS, PESAN, DAN LOGO - Alerts -->
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>
                        
                        
                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>
                        
                     
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">         
                              <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php include "inc.login_status.php"; ?></span>
                              <img class="img-profile rounded-circle" src="../../assets/img/kongo.jpg">
                           
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="login_out.php" target="_self" >
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                          <?php
                        } else {
                        ?>
                        <!-- Maka Ketika belum login belum muncul PP di pojok kanan atas-->
                         
                        <?php } ?>
                    </ul>
                </nav>
              <?php include "buka_file.php";?>
              
            </div> 
        </div>
   </div>
        
   <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../assets/js/demo/chart-area-demo.js"></script>
    <script src="../../assets/js/demo/chart-pie-demo.js"></script>
</body>

</html>