<?php
include_once "../../library/inc.sesadmin.php";

// Periksa data Kode pada URL
if(empty($_GET['Kode'])){
	echo "<b>Data yang dihapus tidak ada</b>";
}
else {
	// Hapus item pemesanan terlebih dahulu
	$Kode = $_GET['Kode'];
	$mySql1 = "DELETE FROM pemesanan_item WHERE no_pemesanan='$Kode'";
	$myQry1 = mysqli_query($mysqli, $mySql1) or die ("Eror hapus data item: ".mysqli_error($mysqli));

	// Hapus data pemesanan utama
	$mySql2 = "DELETE FROM pemesanan WHERE no_pemesanan='$Kode'";
	$myQry2 = mysqli_query($mysqli, $mySql2) or die ("Eror hapus data pemesanan: ".mysqli_error($mysqli));

	if($myQry1 && $myQry2){
		echo "<meta http-equiv='refresh' content='0; url=?open=Penjadwalan_Prioritas'>";
	}
}


?>