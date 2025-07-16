<?php
include_once "../../library/inc.sesadmin.php";
include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

if(isset($_GET['Kode']) && isset($_GET['status'])){
    $Kode = $_GET['Kode'];
    $status = $_GET['status'];

    // Update status pesanan
    $mySql = "UPDATE pemesanan SET status_pesanan = '$status' WHERE no_pemesanan = '$Kode'";
    $myQry = mysqli_query($mysqli, $mySql) or die ("Gagal query".mysqli_error($mysqli));

    if($myQry){
        echo "<script>alert('Status pesanan berhasil diubah menjadi: $status');</script>";
        echo "<meta http-equiv='refresh' content='0; url=?open=Penjadwalan_Prioritas'>";
    }
} else {
    echo "<b>Data tidak valid</b>";
}
?> 