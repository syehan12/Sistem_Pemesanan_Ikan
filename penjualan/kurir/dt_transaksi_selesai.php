<?php 
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
    <title>Kurir - Pesanan Selesai</title>
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="../assets/style/sb-admin-2.css" rel="stylesheet">
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div><img src="../../assets/img/logo2.png" alt=""></div>
            </a>
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
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
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
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Kurir</span>
                                <img class="img-profile rounded-circle" src="../../assets/img/kongo.jpg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Pesanan Selesai (Terkirim)</h1>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Pesanan Selesai</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-responsive-sm">
                                <table width="100%" class="table table-bordered table-hover" id="data-transaksi-selesai">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Transaksi</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Tanggal Pemesanan</th>
                                            <th>Total Beli (Rp)</th>
                                            <th>Status Pembayaran</th>
                                            <th style="min-width:90px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        $sql_1 = "SELECT pemesanan.*, SUM(pemesanan_item.harga * pemesanan_item.jumlah) AS total_bayar FROM pemesanan INNER JOIN pemesanan_item ON pemesanan.no_pemesanan = pemesanan_item.no_pemesanan WHERE status_pesanan = 'Terkirim' GROUP BY no_pemesanan";
                                        $qry_1 = mysqli_query($mysqli, $sql_1) or die("MySQL salah! ".mysqli_error($mysqli));
                                        while ($row_1 = mysqli_fetch_array($qry_1, MYSQLI_ASSOC)) :
                                            $totalbayar = $row_1['total_bayar'];
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row_1['no_pemesanan'] ?></td>
                                            <td><?= $row_1['nama_penerima'] ?></td>
                                            <td><?= IndonesiaTgl($row_1['tgl_pemesanan']) ?></td>
                                            <td><?= format_angka($totalbayar); ?></td>
                                            <td><?= $row_1['status_bayar'] ?></td>
                                            <td align="center">
                                                <a href="dt_transaksi_detail_user.php?Kode=<?= $row_1['no_pemesanan'] ?>" class="btn btn-info btn-sm mx-1" title="Detail">
                                                    <i class="fas fa-info-circle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../assets/js/sb-admin-2.min.js"></script>
    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#data-transaksi-selesai').DataTable({
                responsive: true
            });
        });
    </script>
    <style>
    @media (max-width: 576px) {
        .table-responsive-sm {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        .table th, .table td {
            font-size: 13px !important;
            padding: 0.3rem 0.3rem !important;
        }
    }
    </style>
</body>
</html> 