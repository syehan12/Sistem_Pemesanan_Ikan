<?php
// include_once "../../library/inc.sesadmin.php";
include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

function bulan_biasa($bulan)
{
    $bulan_biasa = array(
        1 => "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
        );
    $result_bulan = $bulan_biasa[$bulan];
    return $result_bulan;
}

$sql_1 = "SELECT DISTINCT MONTH( tgl_pemesanan ) AS bulan_pemesanan FROM pemesanan";
$qry_1 = mysqli_query($mysqli, $sql_1);

$data = [];
while ($row_1 = mysqli_fetch_array($qry_1, MYSQLI_ASSOC)) {
    $bulan = $row_1['bulan_pemesanan'];
    // untuk user
    $sql_2 = "SELECT pemesanan.tgl_pemesanan, SUM(pemesanan_item.jumlah) * SUM( pemesanan_item.harga ) AS pemasukan FROM pemesanan LEFT JOIN pemesanan_item ON pemesanan.no_pemesanan = pemesanan_item.no_pemesanan WHERE MONTH ( tgl_pemesanan ) = '$bulan' GROUP BY tgl_pemesanan";
    $qry_2 = mysqli_query($mysqli, $sql_2);
    while ($row_2 = mysqli_fetch_array($qry_2)) {
        $data[$bulan][] = $row_2['pemasukan'];
    }
}

foreach ($data as $key => $value) {
    $data[$key] = array_sum($value);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <div id="printtableArea">
    <h2><b>
        <font color="#FF0066">LAPORAN BULANAN</font>
    </b></h2>

        <table border="1" class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
            <thead>
                <tr>
                    <th><font color="#FF0066">No</font></th>
                    <th><font color="#FF0066">Bulan</font></th>
                    <th><font color="#FF0066">Pemasukan</font></th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php $no = 1; foreach ($data as $key => $value) : ?>
                <?php $total += $value; ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= bulan_biasa($key) ?></td>
                    <td>Rp.<?= format_angka($value) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td>Rp.<?= format_angka($total) ?></td>
            </tr>
        </tfoot>
    </table>  
    <tr>
    <td width="800">
        </td>
        <td style="position: absolute;top:400; left: 300;"> 
          <button onclick="printDiv('printtableArea')" class="btn btn-danger">Cetak Laporan</button>
      </td>
  </tr>
</div>


<script> 
    function printDiv(divName) {
      var printContents = document.getElementById(divName).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
  }
</script>

</body>
</html>