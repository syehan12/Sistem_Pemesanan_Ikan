<?php
// Membaca Kode barang pada URL
$Kode = $_GET['Kode'];

// Menampilkan daftar barang terkait
$barang3Sql = "SELECT barang.*, kategori.nm_kategori FROM barang LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori WHERE barang.kd_kategori='$KodeKategori' AND barang.kd_barang != '$Kode' ORDER BY barang.kd_barang DESC LIMIT 4";
$barang3Qry = mysqli_query($mysqli, $barang3Sql) or die ("Gagal Query".mysqli_error($mysqli)); 

if(mysqli_num_rows($barang3Qry) > 0) {
?>
<div class="row">
    <?php
    while ($barang3Data = mysqli_fetch_array($barang3Qry)) {
        $KodeBarang = $barang3Data['kd_barang'];
        $KodeKategori = $barang3Data['kd_kategori'];

        // Menampilkan gambar utama
        if ($barang3Data['file_gambar']=="") {
            $fileGambar = "noimage.jpg";
        } else {
            $fileGambar = $barang3Data['file_gambar'];
        }
    ?>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card h-100">
            <img src="../img-barang/<?php echo $fileGambar; ?>" class="card-img-top" style="height: 120px; object-fit: cover;" alt="<?php echo $barang3Data['nm_barang']; ?>">
            <div class="card-body">
                <h6 class="card-title">
                    <a href="?open=Barang-Lihat&Kode=<?php echo $KodeBarang; ?>" class="text-decoration-none">
                        <?php echo $barang3Data['nm_barang']; ?>
                    </a>
                </h6>
                <p class="card-text small text-muted">
                    <?php echo substr($barang3Data['keterangan'], 0, 60); ?>...
                </p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-primary fw-bold">Rp <?php echo format_angka($barang3Data['harga_jual']); ?></span>
                    <span class="badge <?= ($barang3Data['stok'] <= 0) ? 'bg-danger text-white' : 'bg-success text-white' ?>">
                        <?= ($barang3Data['stok'] <= 0) ? 'Habis' : $barang3Data['stok'] ?>
                    </span>
                </div>
                <div class="mt-2">
                    <a href="?open=Barang-Lihat&Kode=<?php echo $KodeBarang; ?>" class="btn btn-sm btn-outline-primary">Detail</a>
                    <?php if($barang3Data['stok'] > 0): ?>
                    <a href="?open=Barang-Beli&Kode=<?php echo $KodeBarang; ?>" class="btn btn-sm btn-success">Beli</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php
} else {
    echo '<div class="alert alert-info">Tidak ada produk terkait lainnya.</div>';
}
?>