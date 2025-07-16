<?php
session_start();
include_once "inc.session.php";
include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

// Baca Kode Pelanggan yang Login
$KodePelanggan	= $_SESSION['SES_PELANGGAN'];

// data Kode di URL harus ada
if(isset($_GET['Kode'])) {
	// Membaca Kode (No Pemesanan)
	$Kode	= $_GET['Kode'];
	
	// Sql membaca data Pemesanan utama sesuai Kode yang dipilih
	$mySql  = "SELECT pemesanan.*, pelanggan.nm_pelanggan FROM pemesanan LEFT JOIN pelanggan ON pemesanan.kd_pelanggan= pelanggan.kd_pelanggan WHERE pemesanan.kd_pelanggan='$KodePelanggan' AND pemesanan.no_pemesanan ='$Kode'";
	$myQry  = mysqli_query($mysqli, $mySql) or die ("Gagal query".mysqli_error($mysqli));
	$myData = mysqli_fetch_array($myQry);
} 
else {
	// Jika data Kode di URL tidak terbaca
	echo "<meta http-equiv='refresh' content='0; url=?open=Transaksi-Tampil'>";
}
?>
<html>
<head>
<title>Cetak Lengkap Transaksi Pemesanan</title>
<link href="../assets/style/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.print()">
<h1> CETAK LENGKAP PEMESANAN BARANG </h1>
<table width="600" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="30%"><strong>No. Pemesanan</strong></td>
    <td width="3%"><strong>:</strong></td>
    <td width="67%"> <?php echo $myData['no_pemesanan']; ?> </td>
  </tr>
  <tr>
    <td><strong>Tgl. Pemesanan </strong></td>
    <td><strong>:</strong></td>
    <td> <?php echo IndonesiaTgl($myData['tgl_pemesanan']); ?> </td>
  </tr>
  <tr>
    <td><strong>Kode Pelanggan</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['kd_pelanggan']; ?></td>
  </tr>
  <tr>
    <td><strong>Nama Pelanggan</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['nm_pelanggan']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Nama Penerima</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['nama_penerima']; ?></td>
  </tr>
  <tr>
    <td><strong>Alamat Penerima</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['alamat_lengkap']; ?></td>
  </tr>
  <tr>
    <td><strong>No. Telepon </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['no_telepon']; ?></td>
  </tr>
  <tr>
    <td><strong>No Rek Transfer </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['norek']; ?></td>
  </tr>
  <tr>
    <td><strong>Bank Transfer </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['bank']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Status Bayar </strong></td>
    <td><strong>:</strong></td>
    <td><strong><?php echo $myData['status_bayar']; ?></strong></td>
  </tr>
  <tr>
    <td><strong>Status Pesanan</strong></td>
    <td><strong>:</strong></td>
    <td><strong>
        <?php 
            $statusPesanan = isset($myData['status_pesanan']) ? $myData['status_pesanan'] : 'Menunggu';
            $statusColor = '';
            switch($statusPesanan) {
                case 'Diproses':
                    $statusColor = '#28a745';
                    break;
                case 'Dikirim':
                    $statusColor = '#ffc107';
                    break;
                case 'Terkirim':
                    $statusColor = '#17a2b8';
                    break;
                default:
                    $statusColor = '#6c757d';
            }
        ?>
        <span style="padding: 5px 10px; background-color: <?php echo $statusColor; ?>; color: white; border-radius: 5px; font-size: 14px;">
            <?php echo $statusPesanan; ?>
        </span>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="761" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="76" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="324" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
    <td width="132" align="right" bgcolor="#CCCCCC"><strong>Harga (Rp)</strong></td>
    <td width="60" align="center" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
    <td width="122" align="right" bgcolor="#CCCCCC"><strong>Total (Rp)</strong></td>
    <td width="23" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
  </tr>
  <?php 
	  // Deklarasi variabel
	  $subTotal	= 0;
	  $totalBarang = 0;
	  $totalBiayaKirim = 0;
	  $totalHarga = 0;
	  $totalBayar =0;
	  $unik_transfer =0;
	  
	  // SQL Menampilkan data Barang yang dipesan
	$tampilSql = "SELECT barang.nm_barang, pemesanan_item.* FROM pemesanan, pemesanan_item LEFT JOIN barang ON pemesanan_item.kd_barang=barang.kd_barang WHERE pemesanan.no_pemesanan=pemesanan_item.no_pemesanan AND pemesanan.no_pemesanan='$Kode' ORDER BY pemesanan_item.kd_barang";
	$tampilQry = mysqli_query($mysqli, $tampilSql) or die ("Gagal SQL".mysqli_error($mysqli));
	$no	= 0; 
	while ($tampilData = mysqli_fetch_array($tampilQry)) {
	  $no++;
	  // Menghitung subtotal harga (harga  * jumlah)
	  $subTotal		= $tampilData['harga'] * $tampilData['jumlah'];
	  
	  // Menjumlah total semua harga 
	  $totalHarga 	= $totalHarga + $subTotal;  
	  
	  // Menjumlah item barang
    $totalBarang	= $totalBarang + $tampilData['jumlah'];    
  ?>
  <tr>
    <td align="center"><?php echo $no; ?></td>
    <td><?php echo $tampilData['kd_barang']; ?></td>
    <td><?php echo $tampilData['nm_barang']; ?></td>
    <td align="right">Rp. <?php echo format_angka($tampilData['harga']); ?></td>
    <td align="right"><?php echo $tampilData['jumlah']; ?></td>
    <td align="right">Rp. <?php echo format_angka($subTotal); ?></td>
    <td align="center">
        <a href="transaksi_lihat.php?Kode=<?php echo $Kode; ?>" target="_blank" alt="Lihat Data" ><img src="../assets/images/btn_print.png"></a>
    </td>
  </tr>
  <?php } 
  	// Menghitung
		// Total biaya Kirim = Biaya kirim x Total barang
		
		$totalBayar = $totalHarga + $totalBiayaKirim;  
		
		$digitHp 	= substr($myData['no_telepon'],-3); // ambil 3 digit terakhir no HP
		$unik_transfer = substr($totalBayar,0,-3).$digitHp;
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="right" bgcolor="#F5F5F5"><strong>Total Belanja (Rp) : </strong></td>
    <td align="right" bgcolor="#F5F5F5">Rp. <?php echo format_angka($totalHarga); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="right"><strong>Total Biaya Kirim  (Rp) : </strong></td>
    <td align="right">Rp. <?php echo format_angka($totalBiayaKirim); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL  (Rp) : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><?php echo format_angka($totalBayar); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" align="right">Nominal pembayarannya adalah <b>Rp. <?php echo format_angka($totalBayar); ?></b> </td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
