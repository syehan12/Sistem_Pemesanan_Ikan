<?php
include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

# Nomor Halaman 
$baris   = 8;
$hal     = isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql = "SELECT * FROM barang";
$pageQry = mysqli_query($mysqli, $pageSql) or die ("error paging: ".mysqli_error($mysqli));
$jml     = mysqli_num_rows($pageQry);
$maks    = ceil($jml/$baris);
$mulai   = $baris * ($hal-1);
?>

<div class="row">
    <?php
    // Menampilkan daftar barang
    $barangSql = "SELECT barang.*, kategori.nm_kategori FROM barang LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori ORDER BY barang.kd_barang ASC LIMIT $mulai, $baris";
    $barangQry = mysqli_query($mysqli, $barangSql) or die ("Gagal Query".mysqli_error($mysqli)); 
    
    while ($barangData = mysqli_fetch_array($barangQry)) {
        $KodeBarang = $barangData['kd_barang'];
        $KodeKategori = $barangData['kd_kategori'];
        
        // Membaca file gambar
        ($barangData['file_gambar'] == "") ? $fileGambar = "noimage.jpg" : $fileGambar = $barangData['file_gambar'];
    ?>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
        <div class="card h-100">
            <img src="../img-barang/<?php echo $fileGambar; ?>" class="card-img-top" style="height: 150px; object-fit: cover;" alt="<?php echo $barangData['nm_barang']; ?>">
            <div class="card-body">
                <h6 class="card-title">
                    <a href="?open=Barang-Lihat&Kode=<?php echo $KodeBarang; ?>" class="text-decoration-none">
                        <?php echo $barangData['nm_barang']; ?>
                    </a>
                </h6>
                <p class="card-text small text-muted">
                    <?php echo substr($barangData['keterangan'], 0, 80); ?>...
                </p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-primary fw-bold">Rp <?php echo format_angka($barangData['harga_jual']); ?></span>
                    <span class="badge <?= ($barangData['stok'] <= 0) ? 'bg-danger text-white' : 'bg-success text-white' ?>">
                        <?= ($barangData['stok'] <= 0) ? 'Habis' : $barangData['stok'] ?>
                    </span>
                </div>
                <div class="mt-2">
                    <a href="?open=Barang-Lihat&Kode=<?php echo $KodeBarang; ?>" class="btn btn-sm btn-outline-primary">Detail</a>
                    <?php if($barangData['stok'] > 0): ?>
                    <a href="?open=Barang-Beli&Kode=<?php echo $KodeBarang; ?>" class="btn btn-sm btn-success">Beli</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<!-- Per halaman -->
<?php if($maks > 1): ?>
<nav class="mt-3">
    <ul class="pagination justify-content-center">
        <?php if($hal > 1): ?>
        <li class="page-item">
            <a class="page-link" href="?hal=<?php echo $hal-1; ?>">Sebelumnya</a>
        </li>
        <?php endif; ?>
        
        <?php
        for ($h = 1; $h <= $maks; $h++) {
            if($h == $hal) {
                echo '<li class="page-item active"><span class="page-link">'.$h.'</span></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="?hal='.$h.'">'.$h.'</a></li>';
            }
        }
        ?>
        
        <?php if($hal < $maks): ?>
        <li class="page-item">
            <a class="page-link" href="?hal=<?php echo $hal+1; ?>">Selanjutnya</a>
        </li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>