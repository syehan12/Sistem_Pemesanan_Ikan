<?php
include_once "inc.session.php";
include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

// Program ini akan Dijalankan ketika Tombol BELI diklik, tombol BELI ada di halaman Produk Barang

// Baca Kode Pelanggan yang Login
$KodePelanggan	= $_SESSION['SES_PELANGGAN'];

if(isset($_GET['Kode'])) {

	// Baca Kode Barang yang dipilih
	$Kode = $_GET['Kode'];

	$sql = "SELECT * FROM barang WHERE kd_barang='$Kode'";
	$qry = mysqli_query($mysqli, $sql) or mysqli_error($mysqli);
	$row = mysqli_fetch_array($qry, MYSQLI_ASSOC);

	if ($row['stok'] <= 0) {
		echo "<script>window.alert('Maaf stok abis!')</script>";
		echo "<script>window.location.href='?open=Barang'</script>";
	} else {
		// Baca data di dalam Keranjang Belanja	
		$cekSql = "SELECT * FROM tmp_keranjang WHERE kd_barang='$Kode' AND kd_pelanggan='$KodePelanggan'";
		$cekQry = mysqli_query($mysqli,$cekSql) or die ("Cek data barang".mysqli_error($mysqli));

		if (mysqli_num_rows($cekQry) >= 1) {
			$mySql = "UPDATE tmp_keranjang SET jumlah=jumlah + 1 WHERE kd_barang='$Kode' AND kd_pelanggan='$KodePelanggan'";

		} else {
			$mySql = "SELECT * FROM barang WHERE kd_barang='$Kode'";
			$myQry = mysqli_query($mysqli, $mySql) or die ("Gagal ambil data barang".mysqli_error($mysqli));
			$myData = mysqli_fetch_array($myQry);
			
			$hargaJual	= $myData['harga_jual'];
			$tanggal	= date('Y-m-d');
			
			$mySql	= "INSERT INTO tmp_keranjang (kd_barang, harga, jumlah, tanggal, kd_pelanggan) VALUES('$Kode', '$hargaJual', '1', '$tanggal', '$KodePelanggan')";
			$myQry = mysqli_query($mysqli, $mySql) or die ("Error".mysqli_error($mysqli));
		}
		
		if ($myQry) {
			echo "<meta http-equiv='refresh' content='0; url=?open=Keranjang-Belanja'>";
		}
	}
}

?>
