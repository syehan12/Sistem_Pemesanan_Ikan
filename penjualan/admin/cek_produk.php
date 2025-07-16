<?php 
// untuk koneksi
include_once "../../library/inc.connection.php";
// untuk id
$id  = $_GET['idkategori'];
$sql = "SELECT * FROM barang WHERE kd_kategori = '$id'";
$qry = mysqli_query($mysqli, $sql);

$response = array();
if (mysqli_num_rows($qry) > 0) {
    while ($row = mysqli_fetch_array($qry, MYSQLI_ASSOC)) {
        array_push($response, $row);
    }
}
// mengembalikan data dalam bentuk json
echo json_encode($response);