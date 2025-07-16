<?php
include_once "../../library/inc.sesadmin.php";
include_once "../../library/inc.library.php";
include_once "../../library/inc.connection.php";
// Fungsi normalisasi
function normalisasiJP($jumlah) {
    if ($jumlah <= 200) return 1;
    if ($jumlah <= 400) return 2;
    if ($jumlah <= 600) return 3;
    if ($jumlah <= 800) return 4;
    if ($jumlah <= 1000) return 5;
    if ($jumlah <= 1500) return 6;
    if ($jumlah <= 2000) return 7;
    if ($jumlah <= 2500) return 8;
    if ($jumlah <= 3000) return 9;
    return 10;
}
function normalisasiSP($status) {
    return strtolower($status) == "lunas" ? 5 : 3;
}
function normalisasiWP($waktu) {
    // $waktu format: HH:MM:SS
    $jam = (int)substr($waktu, 0, 2);
    $menit = (int)substr($waktu, 3, 2);
    $totalMenit = $jam * 60 + $menit;
    if ($totalMenit >= 8*60 && $totalMenit < 10*60) { // 08:00 - 09:59
        return 5;
    } elseif ($totalMenit >= 10*60 && $totalMenit < 13*60) { // 10:00 - 12:59
        return 4;
    } elseif ($totalMenit >= 13*60 && $totalMenit < 14*60) { // 13:00 - 13:59
        return 3;
    } elseif ($totalMenit >= 14*60 && $totalMenit < 15*60) { // 14:00 - 14:59
        return 2;
    } elseif ($totalMenit >= 15*60 && $totalMenit < 17*60) { // 15:00 - 16:59
        return 1;
    } else {
        return 1;
    }
}
function hitungPrioritas($jumlah, $status, $waktu) {
    $w1 = 0.5; // Bobot jumlah pesanan
    $w2 = 0.3; // Bobot status bayar
    $w3 = 0.2; // Bobot waktu pemesanan
    $jp = normalisasiJP($jumlah);
    $sp = normalisasiSP($status);
    $wp = normalisasiWP($waktu);
    return ($w1 * $jp) + ($w2 * $sp) + ($w3 * $wp);
}

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
          <h4 class="m-0 font-weight-bold text-primary">Penjadwalan Prioritas Pesanan</h4>
          <form class="form-inline mt-2 mt-md-0" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
            <div class="form-group mr-2 mb-2 mb-md-0">
              <label class="mr-2 font-weight-bold">Periode</label>
              <input name="txtTglAwal" type="text" class="form-control form-control-sm mr-1" value="<?php echo $tglAwal; ?>" placeholder="Tgl Awal" />
              <span class="mx-1">s/d</span>
              <input name="txtTglAkhir" type="text" class="form-control form-control-sm ml-1" value="<?php echo $tglAkhir; ?>" placeholder="Tgl Akhir" />
            </div>
            <button name="btnTampil" type="submit" class="btn btn-primary btn-sm ml-2"><i class="fas fa-search"></i> Tampilkan</button>
          </form>
        </div>
        <div class="card-body">
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
                  <th class="text-center">Nilai Prioritas</th>
                  <th class="text-center">Status Pesanan</th>
                  <th class="text-center">Reject Pesanan</th>
                  <th class="text-center">Detail Pesanan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Deklrasi variabel angka
                $totalBayar = 0;

                // Menampilkan daftar transaksi dengan perhitungan prioritas
                $mySql = "SELECT pemesanan.*, pelanggan.nm_pelanggan FROM pelanggan, pemesanan WHERE pelanggan.kd_pelanggan = pemesanan.kd_pelanggan AND $SqlPeriode ORDER BY RIGHT(pemesanan.no_pemesanan, 5) DESC";
                $myQry = mysqli_query($mysqli, $mySql) or die ("Gagal query".mysqli_error($mysqli));
                
                // Array untuk menyimpan data dan prioritas
                $dataPesanan = array();
                
                while ($myData = mysqli_fetch_array($myQry)) {
                    $Kode    = $myData['no_pemesanan'];
                    
                    # MENGHITUNG TOTAL BAYAR, TOTAL JUMLAH BARANG dengan perintah SQL
                    $my2Sql  = "SELECT SUM(harga * jumlah) As total_bayar, SUM(jumlah) As total_barang FROM pemesanan_item WHERE no_pemesanan='$Kode'";
                    $my2Qry  = mysqli_query($mysqli, $my2Sql) or die ("Gagal query".mysqli_error($mysqli));
                    $my2Data = mysqli_fetch_array($my2Qry);
                    
                    # MENGHITUNG TOTAL BAYAR, TOTAL JUMLAH BARANG dengan perintah SQL dan juga menambahkan variabel untuk warna tampilan status bayar
                    $totalBayar   = $my2Data['total_bayar'];
                    $totalBarang  = $my2Data['total_barang'];
                    $statusBayar = $myData['status_bayar'];
                    $warnaBayar = '';

                    switch($statusBayar){
                    case 'Belum Lunas':
                      $warnaBayar = 'warning';
                      break;
                    case 'Lunas':
                      $warnaBayar = 'success';
                      break;
                    }
                    
                    
                    // Status pesanan default jika belum ada
                    $statusPesanan = isset($myData['status_pesanan']) ? $myData['status_pesanan'] : 'Menunggu';
                    
                    // Skip pesanan dengan status "Terkirim"
                    if ($statusPesanan == 'Terkirim') {
                        continue;
                    }
                    
                    // Hitung nilai prioritas
                    $nilaiPrioritas = hitungPrioritas($totalBarang, $myData['status_bayar'], $myData['waktu_pemesanan']);
                    
                    // Simpan data ke array
                    $dataPesanan[] = array(
                        'data' => $myData,
                        'total_bayar' => $totalBayar,
                        'total_barang' => $totalBarang,
                        'status_pesanan' => $statusPesanan,
                        'nilai_prioritas' => $nilaiPrioritas,
                        'warna_bayar' => $warnaBayar
                    );
                }
                
                // Urutkan berdasarkan prioritas tertinggi
                usort($dataPesanan, function($a, $b) {
                    return $b['nilai_prioritas'] <=> $a['nilai_prioritas'];
                });
                
                $nomor = 0;
                foreach ($dataPesanan as $item) {
                    $nomor++;
                    $myData = $item['data'];
                    $totalBayar = $item['total_bayar'];
                    $totalBarang = $item['total_barang'];
                    $statusPesanan = $item['status_pesanan'];
                    $nilaiPrioritas = $item['nilai_prioritas'];
                    $Kode = $myData['no_pemesanan'];
                    $warnaBayar = $item['warna_bayar'];
                    
                    
                    // Tentukan warna berdasarkan nilai prioritas
                    $warnaPrioritas = '';
                    $badgePrioritas = '';
                    if ($nilaiPrioritas >= 4.0) {
                        $warnaPrioritas = 'danger'; // Merah - Prioritas Tinggi
                        $badgePrioritas = 'Prioritas Tinggi';
                    } elseif ($nilaiPrioritas >= 3.0) {
                        $warnaPrioritas = 'warning'; // Kuning - Prioritas Sedang
                        $badgePrioritas = 'Prioritas Sedang';
                    } else {
                        $warnaPrioritas = 'success'; // Hijau - Prioritas Rendah
                        $badgePrioritas = 'Prioritas Rendah';
                    }
                ?>
                <tr>
                    <td class="text-center"><?php echo $nomor; ?></td>
                    <td><?php echo $myData['no_pemesanan']; ?></td>
                    <td><?php echo IndonesiaTgl($myData['tgl_pemesanan']); ?></td>
                    <td><?php echo $myData['waktu_pemesanan']; ?></td>
                    <td><?php echo $myData['nm_pelanggan']; ?></td>
                    <td><?php echo $totalBarang; ?></td>
                    <td class="text-right">Rp. <b><?php echo format_angka($totalBayar); ?></b></td>
                    <td class="text-center"><span class="badge badge-<?php echo $warnaBayar; ?>"><?php echo $myData['status_bayar']; ?></span></td>
                    <td class="text-center">
                        <span class="badge badge-<?php echo $warnaPrioritas; ?> font-weight-bold" style="font-size: 1em;">
                            <?php echo number_format($nilaiPrioritas, 2); ?> <br><small><?php echo $badgePrioritas; ?></small>
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm mb-1" role="group">
                            <a href="?open=Update-Status&Kode=<?php echo $Kode; ?>&status=Diproses" class="btn <?php echo ($statusPesanan == 'Diproses') ? 'btn-success' : 'btn-outline-success'; ?>  onclick="return confirm('Ubah status pesanan menjadi Diproses?')">Diproses</a>
                            <a href="?open=Update-Status&Kode=<?php echo $Kode; ?>&status=Dikirim" class="btn <?php echo ($statusPesanan == 'Dikirim') ? 'btn-warning' : 'btn-outline-warning'; ?> onclick="return confirm('Ubah status pesanan menjadi Dikirim?')">Dikirim</a>
                            <a href="?open=Update-Status&Kode=<?php echo $Kode; ?>&status=Terkirim" class="btn <?php echo ($statusPesanan == 'Terkirim') ? 'btn-info' : 'btn-outline-info'; ?> onclick="return confirm('Ubah status pesanan menjadi Terkirim?')">Terkirim</a>
                        </div>
                        <div class="mt-1 font-weight-bold text-secondary">
                            <?php echo $statusPesanan; ?>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="?open=Hapus-Pemesanan&Kode=<?php echo $Kode; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Reject pesanan?')">Reject</a>
                    </td>
                  <td class="text-center">
                    <a href="?open=Pemesanan-Lihat&Kode=<?php echo $Kode; ?>" style="align-self: center;" class="btn btn-info btn-sm" ><i class="fas fa-search"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="alert alert-info mt-4">
            <b>Keterangan:</b><br>
            Prioritas dihitung berdasarkan: (0.5 × JP) + (0.2 × SP) + (0.3 × WP)<br>
            JP = Jumlah Pesanan (skala 1-10), SP = Status Pembayaran (skala 1-5), WP = Waktu Pemesanan (skala 1-5)<br>
            <b>Warna Prioritas:</b> <span class="badge badge-danger">Merah (Tinggi ≥4.0)</span>, <span class="badge badge-warning">Kuning (Sedang 3.0-3.9)</span>, <span class="badge badge-success">Hijau (Rendah &lt;3.0)</span><br>
            <b>Urutan:</b> Daftar diurutkan berdasarkan prioritas tertinggi ke terendah<br>
            <b>Catatan:</b> Pesanan dengan status "Terkirim" tidak ditampilkan di tabel ini karena sudah selesai diproses
          </div>
        </div>
      </div>
    </div>
  </div>
</div> 