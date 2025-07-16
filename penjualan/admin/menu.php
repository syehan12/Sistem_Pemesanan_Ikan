<?php
if (isset($_SESSION['SES_ADMIN'])) {
?>
    <!-- Menu untuk Admin -->
    <li class="nav-item">
        <a class="nav-link" href="?open">
            <i class="fas fa-fw fa-home"></i>
            <span>Home</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">DATA MASTER</div>
    <li class="nav-item">
        <a class="nav-link" href="?open=Kategori-Data">
            <i class="fas fa-fw fa-tags"></i>
            <span>Data Kategori</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?open=Barang-Data">
            <i class="fas fa-shopping-bag"></i>
            <span>Data Produk</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?open=Pelanggan-Data">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Pelanggan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?open=Data-Kurir">
            <i class="fas fa-fw fa-truck"></i>
            <span>Data Kurir</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">DATA PEMESANAN</div>
    <li class="nav-item">
        <a class="nav-link" href="?open=Pemesanan-Barang">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Data Transaksi Pelanggan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?open=Penjadwalan_Prioritas">
            <i class="bi bi-calendar"></i>
            <span>Penjadwalan Pesanan</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">REKAP KESELURUHAN</div>
    <li class="nav-item">
        <a class="nav-link" href="?open=Laporan">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Laporan</span>
        </a>
    </li>
<?php
} else {
?>
    <!-- Menu jika belum login -->
     <li class="nav-item">
        <a class="nav-link" href="../../index.php">
            <i class="fas fa-home fa-fw"></i>
            <span>Home</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?open=Login">
            <i class="fas fa-fw fa-sign-in-alt"></i>
            <span>Login</span>
        </a>
    </li>
<?php } ?>
