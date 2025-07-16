<?php
include_once "../../library/inc.sesadmin.php";
include_once "../../library/inc.library.php";

$SqlPeriode = ""; $awalTgl = ""; $akhirTgl = ""; $tglAwal = ""; $tglAkhir = "";

# Set Tanggal skrg
$awalTgl = isset($_GET['awalTgl']) ? $_GET['awalTgl'] : "01-".date('m-Y');
$tglAwal = isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : $awalTgl ;

$akhirTgl = isset($_GET['akhirTgl']) ? $_GET['akhirTgl'] : date('d-m-Y');
$tglAkhir = isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : $akhirTgl;

# Jika Tombol Tampilkan diklik
if (isset($_POST['btnTampil'])) {
	$SqlPeriode = " tgl_pemesanan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."'";
}
else {
	$SqlPeriode = " tgl_pemesanan BETWEEN '".InggrisTgl($awalTgl)."' AND '".InggrisTgl($akhirTgl)."'";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris    = 50;
$hal      = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql  = "SELECT * FROM pemesanan WHERE $SqlPeriode";
$pageQry  = mysqli_query($mysqli, $pageSql) or die ("error paging: ".mysqli_error($mysqli));
$jml      = mysqli_num_rows($pageQry);
$maksData = ceil($jml/$baris);
?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
          <h4 class="m-0 font-weight-bold text-primary">Daftar Transaksi Pelanggan</h4>
          <a href="?open=Penjadwalan_Prioritas" class="btn btn-danger btn-sm mt-2 mt-md-0"><i class="fas fa-calendar-alt"></i> Penjadwalan Prioritas Pesanan</a>
        </div>
        <div class="card-body">
          <form class="form-inline mb-3" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
            <div class="form-group mr-2 mb-2 mb-md-0">
              <label class="mr-2 font-weight-bold">Periode</label>
              <input name="txtTglAwal" type="text" class="form-control form-control-sm mr-1" value="<?php echo $tglAwal; ?>" placeholder="Tgl Awal" />
              <span class="mx-1">s/d</span>
              <input name="txtTglAkhir" type="text" class="form-control form-control-sm ml-1" value="<?php echo $tglAkhir; ?>" placeholder="Tgl Akhir" />
            </div>
            <button name="btnTampil" type="submit" class="btn btn-primary btn-sm ml-2"><i class="fas fa-search"></i> Tampilkan</button>
          </form>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="thead-light">
                <tr>
                  <th class="text-center">No</th>
                  <th>No Pesan</th>
                  <th>Tanggal</th>
                  <th>Waktu Pemesanan</th>
                  <th>Nama Pelanggan</th>
                  <th>Total Jumlah</th>
                  <th class="text-right">Total Harga (Rp)</th>
                  <th class="text-center">Status Bayar</th>
                  <th class="text-center">Status Pesanan</th>
                  <th class="text-center">Detail</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $mySql = "SELECT pemesanan.*, pelanggan.nm_pelanggan FROM pelanggan, pemesanan WHERE pelanggan.kd_pelanggan = pemesanan.kd_pelanggan AND $SqlPeriode ORDER BY RIGHT(pemesanan.no_pemesanan, 5) DESC";
                $myQry = mysqli_query($mysqli, $mySql) or die ("Gagal query".mysqli_error($mysqli));
                $nomor = 0;
                while ($myData =mysqli_fetch_array($myQry)) {
                  $nomor++;
                  $Kode    = $myData['no_pemesanan'];
                  $my2Sql  = "SELECT SUM(harga * jumlah) As total_bayar, SUM(jumlah) As total_barang FROM pemesanan_item WHERE no_pemesanan='$Kode'";
                  $my2Qry  = mysqli_query($mysqli, $my2Sql) or die ("Gagal query".mysqli_error($mysqli));
                  $my2Data = mysqli_fetch_array($my2Qry);
                  $totalBayar   = $my2Data['total_bayar'];
                  $statusBayar = $myData['status_bayar'];
                  $statusPesanan = isset($myData['status_pesanan']) ? $myData['status_pesanan'] : 'Menunggu';
                  $warnaStatus = '';
                  $badgeStatus = '';
                  switch($statusPesanan) {
                    case 'Menunggu':
                      $warnaStatus = 'secondary';
                      $badgeStatus = 'Menunggu';
                      break;
                    case 'Diproses':
                      $warnaStatus = 'success';
                      $badgeStatus = 'Diproses';
                      break;
                    case 'Dikirim':
                      $warnaStatus = 'warning';
                      $badgeStatus = 'Dikirim';
                      break;
                    case 'Terkirim':
                      $warnaStatus = 'info';
                      $badgeStatus = 'Terkirim';
                      break;
                    default:
                      $warnaStatus = 'secondary';
                      $badgeStatus = $statusPesanan;
                  }

                  $warnaBayar = '';
                  switch($statusBayar){
                    case 'Belum Lunas':
                      $warnaBayar = 'warning';
                      break;
                    case 'Lunas':
                      $warnaBayar = 'success';
                      break;
                  }
                ?>
                <tr>
                  <td class="text-center"><?php echo $nomor; ?></td>
                  <td><?php echo $myData['no_pemesanan']; ?></td>
                  <td><?php echo IndonesiaTgl($myData['tgl_pemesanan']); ?></td>
                  <td><?php echo $myData['waktu_pemesanan']; ?></td>
                  <td><?php echo $myData['nm_pelanggan']; ?></td>
                  <td><?php echo $my2Data['total_barang']; ?></td>
                  <td class="text-right">Rp. <b><?php echo format_angka($totalBayar); ?></b></td>
                  <td class="text-center"><span class="badge badge-<?php echo $warnaBayar; ?>"><?php echo $myData['status_bayar']; ?></span></td>
                  <td class="text-center"><span class="badge badge-<?php echo $warnaStatus; ?> font-weight-bold"><?php echo $badgeStatus; ?></span></td>
                  <td class="text-center">
                    <a href="?open=Pemesanan-Lihat&Kode=<?php echo $Kode; ?>" target="_blank" class="btn btn-info btn-sm" title="Detail"><i class="fas fa-search"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
