<?php
include_once "session.php";
include_once "../../library/inc.connection.php";
$kode = $_GET['Kode'];
mysqli_query($mysqli, "UPDATE pemesanan SET status_pesanan='Terkirim' WHERE no_pemesanan='$kode'");
header("Location: dt_transaksi.php");
exit; 