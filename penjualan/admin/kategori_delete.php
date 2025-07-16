<?php
include_once "../../library/inc.sesadmin.php";

// Periksa data Kode pada URL
if(empty($_GET['Kode'])){
	echo "<b>Data yang dihapus tidak ada</b>";
}
else {
	// Hapus data sesuai Kode yang dikirim di URL
	$Kode	= $_GET['Kode'];
	$mySql 	= "DELETE FROM kategori WHERE kd_kategori='$Kode'";
	$myQry 	= mysqli_query($mysqli, $mySql) or die ("Eror hapus data".mysqli_error($mysqli));
	if($myQry){
		echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Data'>";
	}
}
?>