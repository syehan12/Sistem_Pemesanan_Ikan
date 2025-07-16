<?php
include_once "inc.session.php";
include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

// Baca Kode Pelanggan yang Login
$KodePelanggan	= $_SESSION['SES_PELANGGAN'];

# TOMBOL SIMPAN DIKLIK
if (isset($_POST['btnSimpan'])) {
	$arrData = count($_POST['txtJum']); 

	for ($i = 0; $i < $arrData; $i++) {
		$qtyBaru = ($_POST['txtJum'][$i] < 1) ? 1 : $_POST['txtJum'][$i];
		$KodeBrg = $_POST['txtKodeH'][$i];
		$tanggal = date('Y-m-d');
		$jam     = date('G:i:s');

		// Ambil stok saat ini dari tabel barang
		$sql_1 = "SELECT stok FROM barang WHERE kd_barang = '$KodeBrg'";
		$qry_1 = mysqli_query($mysqli, $sql_1) or die(mysqli_error($mysqli));
		$row_1 = mysqli_fetch_assoc($qry_1);
		$stokSaatIni = $row_1['stok'];

		// Ambil jumlah sebelumnya dari tmp_keranjang
		$sql_3 = "SELECT jumlah FROM tmp_keranjang WHERE kd_barang = '$KodeBrg' AND kd_pelanggan = '$KodePelanggan'";
		$qry_3 = mysqli_query($mysqli, $sql_3) or die(mysqli_error($mysqli));
		$row_3 = mysqli_fetch_assoc($qry_3);
		$jumlahLama = $row_3['jumlah'];

		// Hitung selisih perubahan jumlah
		$selisih = $qtyBaru - $jumlahLama;

		// Update stok hanya jika ada perubahan
		if ($selisih != 0) {
			$stokBaru = $stokSaatIni - $selisih;

			// Validasi stok tidak boleh negatif
			if ($stokBaru < 0) {
				echo "<script>alert('Stok tidak mencukupi untuk barang dengan kode $KodeBrg');</script>";
				continue; // Skip update
			}

			// Update stok barang
			$sql_2 = "UPDATE barang SET stok = '$stokBaru' WHERE kd_barang = '$KodeBrg'";
			mysqli_query($mysqli, $sql_2) or die(mysqli_error($mysqli));
		}

		// Update jumlah di keranjang
		$sql = "UPDATE tmp_keranjang SET jumlah = '$qtyBaru', tanggal = '$tanggal' WHERE kd_barang = '$KodeBrg' AND kd_pelanggan = '$KodePelanggan'";
		mysqli_query($mysqli, $sql) or die("Cek data barang: " . mysqli_error($mysqli));
	}

	// Refresh halaman
	echo "<meta http-equiv='refresh' content='0; url=?open=Keranjang-Belanja'>";
	exit;
}

# MENGHAPUS DATA BARANG YANG ADA DI KERANJANG
// Membaca Kode dari URL
if (isset($_GET['aksi']) and trim($_GET['aksi']) == "Hapus") { 
  $idHapus = $_GET['idHapus'];
  $kdbrg   = $_GET['kd_barang'];

  // Ambil data jumlah dari tmp_keranjang yang akan dihapus
  $sql_keranjang = "SELECT jumlah FROM tmp_keranjang WHERE id = '$idHapus' AND kd_barang = '$kdbrg' AND kd_pelanggan = '$KodePelanggan'";
  $qry_keranjang = mysqli_query($mysqli, $sql_keranjang) or die(mysqli_error($mysqli));
  $row_keranjang = mysqli_fetch_array($qry_keranjang, MYSQLI_ASSOC);
  $jumlahKeranjang = $row_keranjang['jumlah'];

  // Ambil stok barang sekarang
  $sql_barang = "SELECT stok FROM barang WHERE kd_barang = '$kdbrg'";
  $qry_barang = mysqli_query($mysqli, $sql_barang) or die(mysqli_error($mysqli));
  $row_barang = mysqli_fetch_array($qry_barang, MYSQLI_ASSOC);
  $stokSekarang = $row_barang['stok'];

  // Tambahkan kembali jumlah ke stok
  $stokBaru = $stokSekarang + $jumlahKeranjang;
  $sql_update_stok = "UPDATE barang SET stok = '$stokBaru' WHERE kd_barang = '$kdbrg'";
  mysqli_query($mysqli, $sql_update_stok) or die(mysqli_error($mysqli));

  // Hapus dari keranjang
  $sql_delete = "DELETE FROM tmp_keranjang WHERE id='$idHapus' AND kd_pelanggan='$KodePelanggan'";
  $qry_delete = mysqli_query($mysqli, $sql_delete) or die ("Eror hapus data".mysqli_error($mysqli));

  if ($qry_delete) {
    echo "<meta http-equiv='refresh' content='0; url=?open=Keranjang-Belanja'>";
  }
}

# MEMERIKSA DATA DALAM KERANJANG
$cekSql = "SELECT * FROM tmp_keranjang WHERE  kd_pelanggan='$KodePelanggan'";
$cekQry = mysqli_query($mysqli, $cekSql) or die (mysqli_error($mysqli));
$cekQty = mysqli_num_rows($cekQry);
if($cekQty < 1){
	echo '<div class="alert alert-warning text-center">';
	echo '<h4>Keranjang Belanja Kosong</h4>';
	echo '<p>Silakan pilih produk terlebih dahulu.</p>';
	echo '</div>';
	
	// Jika Keranjang masih Kosong, maka halaman Refresh ke data Barang
	echo "<meta http-equiv='refresh' content='3; url=?open=Barang'>";
	exit;
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th width="100" class="text-center">Gambar</th>
                                        <th>Nama Produk</th>
                                        <th width="120" class="text-end">Harga (Rp)</th>
                                        <th width="100" class="text-center">Jumlah</th>
                                        <th width="120" class="text-end">Total (Rp)</th>
                                        <th width="80" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Menampilkan data Barang dari tmp_keranjang (Keranjang Belanja)
                                    $mySql = "SELECT barang.nm_barang, barang.file_gambar, kategori.nm_kategori, tmp_keranjang.* FROM tmp_keranjang LEFT JOIN barang ON tmp_keranjang.kd_barang=barang.kd_barang LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori WHERE tmp_keranjang.kd_pelanggan='$KodePelanggan' ORDER BY tmp_keranjang.id";
                                    $myQry = mysqli_query($mysqli, $mySql) or die ("Gagal SQL".mysqli_error($mysqli));
                                    $total = 0; $grandTotal = 0;
                                    $no	= 0;
                                    while ($myData = mysqli_fetch_array($myQry)) {
                                        $no++;
                                        // Menghitung sub total harga
                                        $total 		= $myData['harga'] * $myData['jumlah'];
                                        $grandTotal	= $grandTotal + $total;
                                        
                                        // Menampilkan gambar
                                        if ($myData['file_gambar']=="") {
                                            $fileGambar = "../img-barang/noimage.jpg";
                                        } else {
                                            $fileGambar	= $myData['file_gambar'];
                                        }
                                        
                                        #Kode Barang
                                        $Kode = $myData['kd_barang'];
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <img src="../img-barang/<?php echo $fileGambar; ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <div>
                                                <a href="?open=Barang-Lihat&Kode=<?php echo $Kode; ?>" class="text-decoration-none">
                                                    <strong><?php echo $myData['nm_barang']; ?></strong>
                                                </a>
                                            </div>
                                            <small class="text-muted">Kategori: <?php echo $myData['nm_kategori']; ?></small>
                                        </td>
                                        <td class="text-end">
                                            Rp <?php echo format_angka($myData['harga']); ?>
                                        </td>
                                        <td class="text-center">
                                            <input name="txtJum[]" type="number" value="<?php echo $myData['jumlah']; ?>" class="form-control form-control-sm" min="1" maxlength="10">
                                            <input name="txtKodeH[]" type="hidden" value="<?php echo $myData['kd_barang']; ?>">
                                        </td>
                                        <td class="text-end">
                                            <strong>Rp <?php echo format_angka($total); ?></strong>
                                        </td>
                                        <td class="text-center">
                                            <a href="?open=Keranjang-Belanja&aksi=Hapus&idHapus=<?php echo $myData['id'];?>&kd_barang=<?= $Kode ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Yakin ingin menghapus produk ini dari keranjang?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Total Belanja:</strong></td>
                                        <td class="text-end"><strong class="text-primary fs-5">Rp <?php echo format_angka($grandTotal); ?></strong></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <div class="d-flex flex-column gap-2">
                                <button name="btnSimpan" type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-2"></i>Ubah
                                </button>
                                <a href="?open=Transaksi-Proses" class="btn btn-success">
                                    <i class="fas fa-arrow-right me-2"></i>Lanjutkan Pembayaran
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Keterangan -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Keterangan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><i class="fas fa-save text-warning me-2"></i>Klik tombol "Ubah" untuk menyimpan perubahan jumlah yang akan dibeli.</p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="fas fa-arrow-right text-success me-2"></i>Klik tombol "Lanjutkan Pembayaran" jika Anda sudah selesai memilih dan ingin melanjutkan transaksi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>