<?php
include_once "../../library/inc.sesadmin.php";
include_once "../../library/inc.library.php";

// Keterangan : Skrip ini untuk menjalankan Aksi dari file program pemesanan_lihat.php dan pemesanan_tampil.php

# Membaca Kode dari URL
if(empty($_GET['Kode'])){
	echo "<b>Data yang diubah tidak ada</b>";
}
else {
	# MEMBACA KODE
	$Kode	= $_GET['Kode'];
	
	# JIKA KLIK TOMBOL LUNAS, maka status Pemesanan jadi Lunas
	if($_GET['Aksi']=="Lunas") {
		$editSql = "UPDATE pemesanan SET status_bayar='Sedang Pengantaran' WHERE no_pemesanan='$Kode'";
		$editQry = mysqli_query($mysqli, $editSql) or die ("Eror Query Edit".mysqli_error($mysqli));
		if($editQry){
			# Pindahkan data dari pemesanan Item (belum dibayar) ke Penjualan Item (sudah dibayar)
			$itemSql = "SELECT * FROM pemesanan_item WHERE no_pemesanan='$Kode'";
			$itemQry = mysqli_query($mysqli, $itemSql) or die ("Gagal query ambil data".mysqli_error($mysqli));
			while ($itemRow = mysqli_fetch_array($itemQry)) {
				$jumlahBrg 	= $itemRow['jumlah'];
				$kodeBrg	= $itemRow['kd_barang'];
				
				# Update stok
				$mySql = "UPDATE barang SET stok=stok- $jumlahBrg WHERE kd_barang='$kodeBrg'";
				mysqli_query($mysqli, $mySql) or die ("Gagal query update stok".mysqli_error($mysqli));
			}
			
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open=Pemesanan-Barang'>";
		}
	}
	
	// JIKA KLIK TOMBOL PESAN, maka status Pemesanan jadi Pesan 
	if($_GET['Aksi']=="Pesan") {
		# Jika sudah terlanjur di Set Lunas (sudah bayar), ternyata salah
		# Ternyata belum bayar (pembayaran batal, atau mungkin uangnya tidak sampai/kembali)
		$editSql = "UPDATE pemesanan SET status_bayar='Pesan' WHERE no_pemesanan='$Kode'";
		$editQry = mysqli_query($mysqli, $editSql) or die ("Eror Query Edit".mysqli_error($mysqli));
		if($editQry){
			# Pindahkan data dari pemesanan Item (belum dibayar) ke Penjualan Item (sudah dibayar)
			$itemSql = "SELECT * FROM pemesanan_item WHERE no_pemesanan='$Kode'";
			$itemQry = mysqli_query($mysqli, $itemSql) or die ("Gagal query ambil data".mysqli_error($mysqli));
			while ($itemRow = mysqli_fetch_array($itemQry)) {
				$jumlahBrg 	= $itemRow['jumlah'];
				$kodeBrg	= $itemRow['kd_barang'];

				# Update stok
				$mySql = "UPDATE barang SET stok=stok + $jumlahBrg WHERE kd_barang='$kodeBrg'";
				mysqli_query($mysqli, $mySql) or die ("Gagal query update stok".mysqli_error($mysqli));
			}
			
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open=Pemesanan-Barang'>";
		}
	}
}
?>