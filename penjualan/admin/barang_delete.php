<?php
# Validasi: halaman ini boleh diakses hanya yang sudah Login
include_once "../../library/inc.sesadmin.php";

// Periksa data Kode pada URL
if(empty($_GET['Kode'])){
	echo "<b>Data yang dihapus tidak ada</b>";
}
else {
	// Membaca Kode Barang dari URL
	$Kode	= $_GET['Kode'];
	
	// Membaca file gambar dari Database
	$mySql = "SELECT * FROM barang WHERE kd_barang='$Kode'";
	$myQry = mysqli_query($mysqli, $mySql)  or die ("Query 1 salah : ".mysqli_error($mysqli));
	$myData= mysqli_fetch_array($myQry);
	
	// Memeriksa data Gambar dari database
	if(! $myData['file_gambar']=="") {
		if(file_exists("../img-barang/".$myData['file_gambar'])) {
			// Jika file gambarnya ada pada folder, maka file gambar dihapus
			unlink("../img-barang/".$myData['file_gambar']); 
		}
	}
	
	// Menghapus data dari database
	$mySql = "DELETE FROM barang WHERE kd_barang='$Kode'";
	$myQry = mysqli_query($mysqli, $mySql) or die ("Query 2 salah".mysqli_error($mysqli));
	if($myQry){
		echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
	}
}
?>