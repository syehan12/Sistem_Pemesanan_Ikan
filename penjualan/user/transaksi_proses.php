<?php
// ===============================
// Halaman Proses Transaksi User
// Tampilan modern SB Admin 2
// ===============================
date_default_timezone_set('Asia/Jakarta');
include_once "inc.session.php";
include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

// Baca Kode Pelanggan yang Login
$KodePelanggan = $_SESSION['SES_PELANGGAN'];

# MEMERIKSA DATA DALAM KERANJANG
$cekSql  = "SELECT * FROM tmp_keranjang WHERE  kd_pelanggan='$KodePelanggan'";
$cekQry  = mysqli_query($mysqli, $cekSql) or die (mysqli_error($mysqli));
$cekQty  = mysqli_num_rows($cekQry);
$harga_k = mysqli_fetch_assoc($cekQry);
$cekhrg = $harga_k ? $harga_k['harga'] : 0;

$total_bayar  = "SELECT * FROM total_bayar WHERE kd_pelanggan='$KodePelanggan'";
$total_bayar2 = mysqli_query($mysqli, $total_bayar) or die ("Gagal query hapus keranjang".mysqli_error($mysqli));
$tt           = mysqli_fetch_assoc($total_bayar2);
$total_bayar1 = isset($tt['total']) ? $tt['total'] : 0;




// untuk data user
$sql_user = "SELECT * FROM pelanggan WHERE kd_pelanggan = '$KodePelanggan'";
$qry_user = mysqli_query($mysqli, $sql_user) or die("Gagal! ".mysqli_error($mysqli));
$row_user = mysqli_fetch_array($qry_user, MYSQLI_ASSOC);

if($cekQty < 1){
	echo "<br><br>";
	echo "<center>";
	echo "<b> BELUM ADA TRANSAKSI </b>";
	echo "<center>";
	// Jika Keranjang masih Kosong, maka halaman Refresh ke data Barang
	echo "<meta http-equiv='refresh' content='2; url=?page=Barang'>";
	exit;
}

# MEMBACA DATA DARI FORM, untuk ditampilkan kembali pada form
$dataNama     = isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataAlamat   = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataNoTelp   = isset($_POST['txtNoTelp']) ? $_POST['txtNoTelp'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Proses Transaksi</title>
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/style/sb-admin-2.css" rel="stylesheet">
    <style>
        .card { margin-bottom: 1.5rem; }
        .table th, .table td { vertical-align: middle !important; }
        @media (max-width: 576px) {
            .card { margin-bottom: 1rem !important; }
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Proses Transaksi</h3>
                </div>
                <div class="card-body p-4">
                    <!-- Data Belanja -->
                    <h5 class="mb-3 text-primary"><i class="fas fa-shopping-cart mr-2"></i>Data Belanja</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-hover table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width:40px;">No</th>
                                    <th>Nama Produk</th>
                                    <th class="text-right">Harga (Rp)</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-right">Total (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            // buat variabel data
                            $subTotal	= 0;
                            $totalHarga	= 0;
                            $totalBarang = 0;
                            
                            // Menampilkan daftar barang yang sudah dipilih (ada d Keranjang)
                            $mySql = "SELECT barang.nm_barang, tmp_keranjang.* FROM tmp_keranjang LEFT JOIN barang ON tmp_keranjang.kd_barang=barang.kd_barang WHERE barang.kd_barang=tmp_keranjang.kd_barang AND tmp_keranjang.kd_pelanggan='$KodePelanggan' ORDER BY tmp_keranjang.id";
                            $myQry = mysqli_query($mysqli, $mySql) or die ("Gagal SQL".mysqli_error($mysqli));
                            $nomor	= 0;
                            while ($myData = mysqli_fetch_array($myQry)) {
                                $nomor++;
                                // Mendapatkan total harga (harga * jumlah)
                                $subTotal= $myData['harga'] * $myData['jumlah']; 

                                // Mendapatkan total harga  dari seluruh  barang
                                $totalHarga = $totalHarga + $subTotal; 

                                // Mendapatkan total barang
                                $totalBarang = $totalBarang + $myData['jumlah']; 
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $nomor; ?></td>
                                    <td><a href="?open=Barang-Lihat&amp;Kode=<?php echo $myData['kd_barang']; ?>" target="_blank"><?php echo $myData['nm_barang']; ?></a></td>
                                    <td class="text-right">Rp.<?php echo format_angka($myData['harga']); ?></td>
                                    <td class="text-center"><?php echo $myData['jumlah']; ?></td>
                                    <td class="text-right">Rp. <?php echo format_angka($subTotal); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right font-weight-bold">TOTAL BELANJA :</td>
                                    <td class="text-center font-weight-bold"><?php echo $totalBarang; ?></td>
                                    <td class="text-right font-weight-bold"><span class="badge badge-success" style="font-size:1rem;">Rp. <?php echo format_angka($totalHarga); ?></span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Form Alamat & Pembayaran -->
                    <form name="form1" method="post" id="form_transaksi" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                        <div class="card mb-3">
                            <div class="card-header bg-info text-white"><b>Alamat Tujuan Pengiriman</b></div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label font-weight-bold">Nama Penerima</label>
                                    <div class="col-md-9">
                                        <input name="txtNama" type="text" class="form-control" value="<?php echo $dataNama; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label font-weight-bold">Alamat</label>
                                    <div class="col-md-9">
                                        <textarea name="txtAlamat" id="txtAlamat" class="form-control" rows="2" readonly><?= $row_user['alamat_lengkap'] ?></textarea>
                                        <div class="form-check form-check-inline mt-2">
                                            <input class="form-check-input" type="radio" name="cek_alamat" id="iya" value="iya">
                                            <label class="form-check-label" for="iya">Iya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="cek_alamat" id="tidak" value="tidak">
                                            <label class="form-check-label" for="tidak">Tidak</label>
                                        </div>
                                        <small class="form-text text-muted">Apakah sesuai dengan alamat pemesanan?</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label font-weight-bold">No. Telepon</label>
                                    <div class="col-md-9">
                                        <input name="txtNoTelp" type="text" class="form-control" value="<?php echo $dataNoTelp; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header bg-info text-white"><b>Pilih Metode Pembayaran</b></div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label font-weight-bold">Metode Pembayaran</label>
                                    <div class="col-md-9">
                                        <select name="inpmetodetransfer" id="inpmetodetransfer" class="form-control">
                                            <option value="-">Pilih Metode</option>
                                            <option value="transfer">Transfer</option>
                                            <option value="cod">COD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" id="bank">
                                    <label class="col-md-3 col-form-label font-weight-bold">Bank</label>
                                    <div class="col-md-9">
                                        <select name="inpbank" id="inpbank" class="form-control">
                                            <option value="-">Pilih Bank</option>
                                            <option value="bri">BRI</option>
                                            <option value="bni">BNI</option>
                                        </select>
                                        <div id="bank-info" style="display:none; margin-top:15px;">
                                            <img id="bank-logo" src="" alt="Logo Bank" style="max-width:120px; display:block; margin-bottom:8px;">
                                            <div id="bank-details" style="font-size:1rem;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" id="norek">
                                    <label class="col-md-3 col-form-label font-weight-bold">Nomor Rekening Anda</label>
                                    <div class="col-md-9">
                                        <input type="text" name="inpnorek" id="inpnorek" class="form-control" value="-" />
                                    </div>
                                </div>
                                <div class="form-group row" id="bukti_bayar_row" style="display:none;">
                                    <label class="col-md-3 col-form-label font-weight-bold">Upload Bukti Pembayaran</label>
                                    <div class="col-md-9">
                                        <input type="file" name="bukti_bayar" id="bukti_bayar" class="form-control-file" accept="image/*,application/pdf">
                                        <small class="form-text text-muted">Hanya untuk pembayaran transfer. File gambar (JPG, PNG) atau PDF, max 2MB.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button name="btnSimpan" type="submit" class="btn btn-success px-4"><i class="fas fa-save mr-1"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
var untukCekAlamat = function () {
    $('#form_transaksi input').on('change', function () {
        var value = $('input[name=cek_alamat]:checked', '#form_transaksi').val();
        if (value != 'iya') {
            $('#txtAlamat').removeAttr('readonly');
        } else {
            $('#txtAlamat').attr('readonly', 'readonly');
        }
    });
}();
var untukMetodePembayaran = function () {
    $('#bank').css('display', 'none');
    $('#norek').css('display', 'none');
    $('#bukti_bayar_row').css('display', 'none');
    $('#inpmetodetransfer').change(function () {
        var value_tf = $(this).val();
        if (value_tf == 'transfer') {
            $("#bank").show();
            $("#bukti_bayar_row").show();
        } else {
            $("#bank").hide();
            $("#bukti_bayar_row").hide();
        }
    });
    $('#inpbank').change(function () {
        var value_bank = $(this).val();
        if (value_bank != '-') {
            $("#norek").show();
            // Show bank info
            var logo = '';
            var details = '';
            if (value_bank === 'bri') {
                logo = 'logoBRI.png';
                details = '<b>Bank BRI</b><br>An. Peternakan Ikan Mawar III<br>No. Rek: 7092929229';
                $('#inpnorek').val('');
            } else if (value_bank === 'bni') {
                logo = 'logoBNIpng.png';
                details = '<b>Bank BNI</b><br>An. Peternakan Ikan Mawar III<br>No. Rek: 612321363216';
                $('#inpnorek').val('');
            } else {
                logo = '';
                details = '';
                $('#inpnorek').val('-');
            }
            if (logo !== '') {
                $('#bank-logo').attr('src', logo);
                $('#bank-info').show();
            } else {
                $('#bank-info').hide();
            }
            $('#bank-details').html(details);
        } else {
            $("#norek").hide();
            $('#bank-info').hide();
            $('#inpnorek').val('-');
        }
    });
}();
jQuery(document).ready(function () {
    untukCekAlamat;
    untukMetodePembayaran;
});
</script>
<?php
# SAAT TOMBOL SIMPAN DIKLIK, Masuk ke proses simpan data
if(isset($_POST['btnSimpan'])){
    # Baca Variabel Form
    $txtNama	= $_POST['txtNama'];
    $txtNama	= str_replace("'","&acute;",$txtNama);

    $txtAlamat	= $_POST['txtAlamat'];
    $txtAlamat	= str_replace("'","&acute;",$txtAlamat);

    $txtNoTelp	= $_POST['txtNoTelp'];
    $txtNoTelp	= str_replace("'","&acute;",$txtNoTelp);

    // metode pembayaran
    $txtMetodetf = $_POST['inpmetodetransfer'];
    $txtBank     = $_POST['inpbank'];
    $txtNorek    = $_POST['inpnorek'];

    // Validasi, jika data kosong kirimkan pemesanan error
    $pesanError = array();
    if (trim($txtNama) =="") {
        $pesanError[] = "Data <b>Nama Penerima</b> masih kosong";
    }
    if (trim($txtAlamat) =="") {
        $pesanError[] = "Data <b>Alamat Tujuan Pengiriman</b> masih kosong";
    }
    if (trim($txtNoTelp) =="") {
        $pesanError[] = "Data <b>No. Telepon</b> masih kosong";
    }

    // Proses upload bukti bayar jika transfer
    $buktiBayarFile = '';
    if ($txtMetodetf == 'transfer') {
        if (isset($_FILES['bukti_bayar']) && $_FILES['bukti_bayar']['error'] == 0) {
            $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
            $maxSize = 2 * 1024 * 1024; // 2MB
            $fileType = $_FILES['bukti_bayar']['type'];
            $fileSize = $_FILES['bukti_bayar']['size'];
            $fileTmp  = $_FILES['bukti_bayar']['tmp_name'];
            $fileExt  = strtolower(pathinfo($_FILES['bukti_bayar']['name'], PATHINFO_EXTENSION));
            $newFileName = 'bukti_' . date('YmdHis') . '_' . rand(100,999) . '.' . $fileExt;
            $uploadDir = '../../penjualan/assets/images/bukti_bayar/';
            if (!in_array($fileType, $allowedTypes)) {
                $pesanError[] = "Tipe file bukti pembayaran tidak valid. Hanya JPG, PNG, atau PDF.";
            } elseif ($fileSize > $maxSize) {
                $pesanError[] = "Ukuran file bukti pembayaran maksimal 2MB.";
            } else {
                if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }
                if (move_uploaded_file($fileTmp, $uploadDir . $newFileName)) {
                    $buktiBayarFile = $newFileName;
                } else {
                    $pesanError[] = "Gagal upload file bukti pembayaran.";
                }
            }
        } else {
            $pesanError[] = "Bukti pembayaran harus diupload untuk metode transfer.";
        }
    }

    # JIKA ADA PESAN ERROR DARI VALIDASI
    if (count($pesanError)>=1 ){
        echo "<div class='pesanError' align='left'>";
        echo "<img src='../assets/images/attention.png'> <br><hr>";
        $noPesan=0;
        foreach ($pesanError as $indeks=>$pesan_tampil) { 
            $noPesan++;
            echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
        } 
        echo " <br>"; 
    }
    else {
        # SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database
        $KodePemesanan	= buatKode("pemesanan", "PS", $mysqli);
        $tanggal		= date('Y-m-d');
        $waktu_pemesanan = date('H:i:s');
        // Tentukan status_bayar otomatis
        $status_bayar = ($txtMetodetf == 'transfer') ? 'Lunas' : 'Belum Lunas';
        if ($txtMetodetf == 'transfer') {
            $mySql  = "INSERT INTO pemesanan (no_pemesanan, tgl_pemesanan, kd_pelanggan, nama_penerima, alamat_lengkap, no_telepon, metode_pembayaran, bank, norek, waktu_pemesanan, status_bayar, bukti_bayar) VALUES('$KodePemesanan', '$tanggal', '$KodePelanggan', '$txtNama', '$txtAlamat', '$txtNoTelp', '$txtMetodetf', '$txtBank', '$txtNorek', '$waktu_pemesanan', '$status_bayar', '$buktiBayarFile')";
        } else {
            $mySql  = "INSERT INTO pemesanan (no_pemesanan, tgl_pemesanan, kd_pelanggan, nama_penerima, alamat_lengkap, no_telepon, metode_pembayaran, bank, norek, waktu_pemesanan, status_bayar, bukti_bayar) VALUES('$KodePemesanan', '$tanggal', '$KodePelanggan', '$txtNama', '$txtAlamat', '$txtNoTelp', '$txtMetodetf', '$txtBank', '$txtNorek', '$waktu_pemesanan', '$status_bayar', '')";
        }
        $myQry  = mysqli_query($mysqli, $mySql) or die ("Gagal query 1".mysqli_error($mysqli));

        if($myQry){
            // Membaca data dari TMP (Kantong belanja)
            $bacaSql	= "SELECT * FROM tmp_keranjang WHERE kd_pelanggan='$KodePelanggan'";
            $bacaQry	= mysqli_query($mysqli, $bacaSql) or die ("Gagal query 2".mysqli_error($mysqli));
            while ($bacaData = mysqli_fetch_array($bacaQry)) {
                // Simpan data dari Keranjang belanja ke Pemesanan_Item
                $Kode 	= $bacaData['kd_barang'];
                $Harga	= $bacaData['harga'];
                $Jumlah	= $bacaData['jumlah'];
                
                $simpanSql="INSERT INTO pemesanan_item(no_pemesanan, kd_barang, harga, jumlah) VALUES('$KodePemesanan', '$Kode', '$Harga', '$Jumlah')";
                mysqli_query($mysqli, $simpanSql) or die ("Gagal query simpan".mysqli_error($mysqli));
            }
            
            
            // Kosongkan data Keranjang milik Pelanggan 
            $hapusSql	= "DELETE FROM tmp_keranjang WHERE kd_pelanggan='$KodePelanggan'";
            mysqli_query($mysqli, $hapusSql) or die ("Gagal query hapus keranjang".mysqli_error($mysqli));
            $hapusSqlT	= "DELETE FROM total_bayar WHERE kd_pelanggan='$KodePelanggan'";
            mysqli_query($mysqli, $hapusSqlT) or die ("Gagal query hapus keranjang".mysqli_error($mysqli));

            // Refresh
            echo "<meta http-equiv='refresh' content='0; url=?open=Transaksi-Tampil&Act=Sukses'>";
        }
        exit;
    }	
}
?>
</body>
</html>