<?php
// Membaca Kode dari URL
if(isset($_GET['Kode'])){

  $Kode	= $_GET['Kode'];
	
	// Menampilkan data sesuai Kode dari URL
	$lihatSql = "SELECT barang.*, kategori.nm_kategori FROM barang LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori WHERE barang.kd_barang='$Kode'";
	
	$lihatQry = mysqli_query($mysqli, $lihatSql) or die ("Data Gagal Ditampilkan ..!");
	$no=0;
	$lihatData = mysqli_fetch_array($lihatQry);
	  $no++;
	  $KodeBarang= $lihatData['kd_barang'];
	  $KodeKategori = $lihatData['kd_kategori'];
	  	  
	  // Membaca gambar utama
	  if ($lihatData['file_gambar']=="") {
			$fileGambar = "noimage.jpg";
	  }
	  else {
			$fileGambar	= $lihatData['file_gambar'];
	  }
} else {
	// Jika variabel Kode tidak ada di URL
	echo "Kode barang tidak ada ";
	
	// Refresh
	echo "<meta http-equiv='refresh' content='2; url=index.php'>";
	exit;
}
?>

<div class="container-fluid">
    <div class="row">
        <!-- Gambar Produk -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="../img-barang/<?php echo $fileGambar; ?>" class="card-img-top" style="height: 300px; object-fit: cover;" alt="<?php echo $lihatData['nm_barang']; ?>" />
                <div class="card-body text-center">
                    <h4 class="text-primary mb-3">Rp <?php echo format_angka($lihatData['harga_jual']); ?></h4>
                    <?php if($lihatData['stok'] > 0): ?>
                    <a href="?open=Barang-Beli&Kode=<?php echo $KodeBarang; ?>" class="btn btn-success btn-lg w-100">
                        <i class="fas fa-shopping-cart me-2"></i>Beli Sekarang
                    </a>
                    <?php else: ?>
                    <button class="btn btn-secondary btn-lg w-100" disabled>
                        <i class="fas fa-times-circle me-2"></i>Stok Habis
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Detail Produk -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0"><?php echo $lihatData['nm_barang']; ?></h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Kategori:</strong></td>
                            <td>
                                <a href="?open=Barang-Kategori&Kode=<?php echo $KodeKategori; ?>" class="badge bg-primary text-white text-decoration-none">
                                    <?php echo $lihatData['nm_kategori']; ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Stok:</strong></td>
                            <td>
                                <span class="badge <?= ($lihatData['stok'] <= 0) ? 'bg-danger text-white' : 'bg-success text-white' ?>">
                                    <?= ($lihatData['stok'] <= 0) ? 'Stok Habis' : $lihatData['stok'] . ' Unit' ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Harga:</strong></td>
                            <td><strong class="text-success fs-5">Rp <?php echo format_angka($lihatData['harga_jual']); ?></strong></td>
                        </tr>
                        <tr>
                            <td><strong>Kode:</strong></td>
                            <td><code><?php echo $KodeBarang; ?></code></td>
                        </tr>
                    </table>
                    
                    <hr>
                    
                    <h5>Deskripsi Produk:</h5>
                    <p class="text-muted">
                        <?php echo nl2br($lihatData['keterangan']); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Produk Terkait -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-th-large me-2"></i>Produk Terkait
                    </h5>
                </div>
                <div class="card-body">
                    <?php include "barang_lainnya.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>
