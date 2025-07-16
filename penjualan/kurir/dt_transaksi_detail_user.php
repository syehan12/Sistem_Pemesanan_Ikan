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
    <title>Kurir - Detail Transaksi</title>
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
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Detail Transaksi</h1>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Pemesanan</h6>
                        </div>
                        <div class="card-body">
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Kategori Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $kd = $_GET['Kode'];
                                    $no = 1;
                                    $total = 0;

                                    $sql_i = "SELECT pemesanan_item.kd_barang, kategori.nm_kategori, barang.nm_barang, pemesanan_item.jumlah, barang.harga_jual, (pemesanan_item.harga * pemesanan_item.jumlah) AS sub_total FROM pemesanan, pemesanan_item LEFT JOIN barang ON pemesanan_item.kd_barang = barang.kd_barang LEFT JOIN kategori ON barang.kd_kategori = kategori.kd_kategori WHERE pemesanan.no_pemesanan = pemesanan_item.no_pemesanan AND pemesanan.no_pemesanan = '$kd' ORDER BY pemesanan_item.kd_barang";
                                    $qry_i = mysqli_query($mysqli, $sql_i) or die ("MySQL salah! ".mysqli_error($mysqli));
                                    ?>
                                    <?php while ($rows = mysqli_fetch_array($qry_i, MYSQLI_ASSOC)) : ?>
                                        <?php $total += $rows['sub_total']; ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $rows['kd_barang'] ?></td>
                                            <td><?= $rows['nm_kategori'] ?></td>
                                            <td><?= $rows['nm_barang'] ?></td>
                                            <td><?= $rows['jumlah'] ?></td>
                                            <td>Rp. <?= number_format($rows['harga_jual']) ?> </td>
                                            <td>Rp. <?= number_format($rows['sub_total']) ?> </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" align="center">
                                            <p style="margin: 0;">Total</p>
                                        </td>
                                        <td>Rp. <?= number_format($total) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Pelanggan</h6>
                        </div>
                        <div class="card-body">
                            <?php 
                            $sql_1 = "SELECT pemesanan.*, pelanggan.nm_pelanggan FROM pemesanan, pelanggan WHERE pemesanan.kd_pelanggan=pelanggan.kd_pelanggan AND pemesanan.no_pemesanan ='$kd'";
                            $qry_1 = mysqli_query($mysqli, $sql_1) or die ("MySQL salah! ".mysqli_error($mysqli));
                            $row_1 = mysqli_fetch_array($qry_1, MYSQLI_ASSOC);
                            ?>
                            <form class="form-horizontal" method="post" role="form">
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-lg-2 control-label">No Pemesanan</label>
                                    <div class="col-xs-10 col-sm-10 col-lg-10">
                                        <input type="text" class="form-control" value="<?= $kd ?>" readonly="readonly" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-lg-2 control-label">Tanggal</label>
                                    <div class="col-xs-10 col-sm-10 col-lg-10">
                                        <input type="text" class="form-control" value="<?= IndonesiaTgl($row_1['tgl_pemesanan']) ?>" readonly="readonly" required="required" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-lg-2 control-label">Kode Pelanggan</label>
                                    <div class="col-xs-10 col-sm-10 col-lg-10">
                                        <input type="text" class="form-control" value="<?= $row_1['kd_pelanggan'] ?>" readonly="readonly" required="required" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-lg-2 control-label">Nama Pelanggan</label>
                                    <div class="col-xs-10 col-sm-10 col-lg-10">
                                        <input type="text" class="form-control" value="<?= $row_1['nm_pelanggan'] ?>" readonly="readonly" required="required" />
                                    </div>
                                </div>
                                
                                <hr />

                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-lg-2 control-label">Nama Penerima</label>
                                    <div class="col-xs-10 col-sm-10 col-lg-10">
                                        <input type="text" class="form-control" value="<?= $row_1['nama_penerima'] ?>" readonly="readonly" required="required" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-lg-2 control-label">Alamat Penerima</label>
                                    <div class="col-xs-10 col-sm-10 col-lg-10">
                                        <input type="text" class="form-control" value="<?= $row_1['alamat_lengkap'] ?>" readonly="readonly" required="required" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-lg-2 control-label">No, Telepon</label>
                                    <div class="col-xs-10 col-sm-10 col-lg-10">
                                        <input type="text" class="form-control" value="<?= $row_1['no_telepon'] ?>" readonly="readonly" required="required" />
                                    </div>
                                </div>

                                <hr />
                            
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-lg-2 control-label">Status</label>
                                    <div class="col-xs-10 col-sm-10 col-lg-10">
                                        <input type="text" class="form-control" value="<?= $row_1['status_bayar'] ?>" readonly="readonly" required="required" />
                                    </div>
                                </div>
                                <a href="dt_transaksi.php" class="btn btn-primary">Kembali</a>
                                <a href="dt_transaksi_cetak_user.php?kode=<?= $kd ?>" class="btn btn-success" target="_blank">Cetak</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/kurir/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/kurir/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/kurir/vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../assets/kurir/dist/js/sb-admin-2.js"></script>

</body>

</html>