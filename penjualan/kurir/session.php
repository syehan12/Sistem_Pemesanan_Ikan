<?php
// untuk memulai session
session_start();
// untuk koneksi
include_once "../../library/inc.connection.php";
// untuk library
include_once "../../library/inc.library.php";
// untuk cek session
if(empty($_SESSION['SES_PELANGGAN'])) {
	header('location: index.php');
	exit;
}
?>