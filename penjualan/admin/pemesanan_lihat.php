<?php
// ===============================
// Halaman Detail Pemesanan Admin
// Tampilan modern SB Admin 2
// ===============================

include_once "../../library/inc.sesadmin.php";   // Validasi halaman harus Login
include_once "../../library/inc.connection.php"; // Membuka koneksi database
include_once "../../library/inc.library.php";    // Fungsi-fungsi tambahan

if(isset($_GET['Kode'])) {
	// Ambil kode pemesanan dari URL
	$Kode = $_GET['Kode'];
	
	// Query utama: ambil data pemesanan dan pelanggan
	$mySql  = "SELECT pemesanan.*, pelanggan.nm_pelanggan FROM pemesanan, pelanggan WHERE pemesanan.kd_pelanggan=pelanggan.kd_pelanggan AND pemesanan.no_pemesanan ='$Kode'";
	$myQry  = mysqli_query($mysqli, $mySql) or die ("Gagal query".mysqli_error($mysqli));
	$myData = mysqli_fetch_array($myQry);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detail Pemesanan</title>
    <!-- SB Admin 2 & Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/style/sb-admin-2.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .table th, .table td { vertical-align: middle !important; }
        .card { margin-bottom: 1.5rem; }
        @media (max-width: 576px) {
            .card { margin-bottom: 1rem !important; }
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Detail Pemesanan</h3>
                </div>
                <div class="card-body p-4">
                    <!-- Informasi Transaksi & Penerima -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <div class="border rounded p-3 h-100">
                                <h5 class="text-primary mb-3"><i class="fas fa-receipt mr-2"></i>Transaksi</h5>
                                <div class="mb-2"><b>No. Pemesanan:</b> <?= $myData['no_pemesanan']; ?></div>
                                <div class="mb-2"><b>Tanggal:</b> <?= IndonesiaTgl($myData['tgl_pemesanan']); ?></div>
                                <div class="mb-2"><b>Kode Pelanggan:</b> <?= $myData['kd_pelanggan']; ?></div>
                                <div class="mb-2"><b>Nama Pelanggan:</b> <?= $myData['nm_pelanggan']; ?></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="border rounded p-3 h-100">
                                <h5 class="text-success mb-3"><i class="fas fa-user-check mr-2"></i>Penerima</h5>
                                <div class="mb-2"><b>Nama:</b> <?= $myData['nama_penerima']; ?></div>
                                <div class="mb-2"><b>Alamat:</b> <?= $myData['alamat_lengkap']; ?></div>
                                <div class="mb-2"><b>No. Telepon:</b> <?= $myData['no_telepon']; ?></div>
                            </div>
                        </div>
                    </div>
                    <!-- Status & Bukti Bayar -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="border rounded p-3">
                                <h5 class="text-warning mb-3"><i class="fas fa-info-circle mr-2"></i>Status</h5>
                                <div class="mb-2">
                                    <b>Status Pembayaran:</b> 
                                    <?php if ($myData['status_bayar'] == 'Lunas') { ?>
                                        <span class="badge badge-success"><?= $myData['status_bayar']; ?></span>
                                    <?php } else { ?>
                                        <span class="badge badge-warning"><?= $myData['status_bayar']; ?></span>
                                    <?php } ?>
                                </div>
                                <?php 
                
                                // TAMPILKAN BUKTI BAYAR
                         
                                if (!empty($myData['bukti_bayar'])): 
                                    $bukti_bayar = $myData['bukti_bayar'];
                                    $img_src = '../assets/images/bukti_bayar/'. $bukti_bayar;
                                ?>
                                <div class="my-3">
                                    <div class="card shadow mb-3" style="max-width:340px; margin:auto;">
                                        <div class="card-header bg-primary text-white text-center p-2" style="font-size:1rem;">Bukti Pembayaran</div>
                                        <div class="card-body text-center p-2">
                                            <!-- Gambar bukti bayar, klik untuk perbesar -->
                                            <a href="<?= htmlspecialchars($img_src) ?>" target="_blank">
                                                <img src="<?= htmlspecialchars($img_src) ?>" alt="Bukti Bayar" class="img-fluid rounded border" style="max-height:220px; object-fit:contain; background:#f8f9fa;" onerror="this.style.display='none';this.nextElementSibling.style.display='block';" />
                                                <span style="display:none;color:#888;">Bukti bayar tidak ditemukan.</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Daftar Pesanan -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="border rounded p-3">
                                <h5 class="text-info mb-3"><i class="fas fa-list mr-2"></i>Daftar Pesanan</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-center" style="width:40px;">No</th>
                                                <th>Kode</th>
                                                <th>Nama Barang</th>
                                                <th class="text-right">Harga (Rp)</th>
                                                <th class="text-center">Jumlah</th>
                                                <th class="text-right">Total (Rp)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        // Query daftar barang yang dipesan
                                        $subTotal = 0;
                                        $totalBarang = 0;
                                        $totalHarga = 0;
                                        $tampilSql = "SELECT barang.nm_barang, pemesanan_item.* FROM pemesanan, pemesanan_item LEFT JOIN barang ON pemesanan_item.kd_barang=barang.kd_barang WHERE pemesanan.no_pemesanan=pemesanan_item.no_pemesanan AND pemesanan.no_pemesanan='$Kode' ORDER BY pemesanan_item.kd_barang";
                                        $tampilQry = mysqli_query($mysqli, $tampilSql) or die ("Gagal SQL".mysqli_error($mysqli)); 
                                        $total = 0;
                                        $nomor = 0;
                                        while ($tampilData = mysqli_fetch_array($tampilQry, MYSQLI_ASSOC)) {
                                            $nomor++;
                                            $subTotal = $tampilData['harga'] * $tampilData['jumlah']; 
                                            $totalHarga = $totalHarga + $subTotal;  
                                            $totalBarang = $totalBarang + $tampilData['jumlah']; 
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $nomor; ?></td>
                                                <td><?= $tampilData['kd_barang']; ?></td>
                                                <td><?= $tampilData['nm_barang']; ?></td>
                                                <td class="text-right">Rp. <?= number_format($tampilData['harga']); ?></td>
                                                <td class="text-center"><?= $tampilData['jumlah']; ?></td>
                                                <td class="text-right">Rp.<?= format_angka($subTotal); ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-right font-weight-bold">Total Belanja (Rp):</td>
                                                <td class="text-right font-weight-bold">Rp. <?= format_angka($totalHarga); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-right">Total Biaya Kirim (Rp):</td>
                                                <td class="text-right">Rp. <?= isset($totalBiayaKirim) ? format_angka($totalBiayaKirim) : '0'; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-right font-weight-bold bg-light">GRAND TOTAL (Rp):</td>
                                                <td class="text-right font-weight-bold bg-light">Rp. <?= format_angka($totalHarga); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Keterangan Status -->
                    <div class="alert alert-info mt-4 mb-0">
                        <b>* Keterangan Status :</b><br>
                        Pastika jika status lunas, dokumen pembayaran sudah valid
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- JS Bootstrap & SB Admin 2 -->
<script src="../../vendor/jquery/jquery.min.js"></script>
<script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../../assets/js/sb-admin-2.min.js"></script>
</body>
</html>
<?php
} 
else {
	// Jika kode tidak ditemukan, redirect ke halaman utama transaksi
	echo "<meta http-equiv='refresh' content='0; url=?open=Transaksi-Tampil'>";
}
?>
