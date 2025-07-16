<?php
// Validasi Login : yang boleh mengakses halaman ini hanya yang sudah Login admin
include_once "../../library/inc.sesadmin.php";

# Jika tombol SAVE diklik, proses penyimpanan hasil perubahan
if(isset($_POST['btnSimpan'])){	
	// Baca variabel form
	$txtNama = $_POST['txtNama'];
	$txtNama = str_replace("'","&acute;",$txtNama);
	$txtNama = ucwords(strtolower($txtNama));
	
	$txtHrgJual = $_POST['txtHrgJual'];
	$txtHrgJual = str_replace("'","&acute;",$txtHrgJual);
	
	$txtStok = $_POST['txtStok'];
	$txtStok = str_replace("'","&acute;",$txtStok);
	
	$txtKeterangan = $_POST['txtKeterangan'];
	$txtKeterangan = str_replace("'","&acute;",$txtKeterangan);
	
	$cmbKategori = $_POST['cmbKategori'];
	
	// Validasi form
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Produk</b> tidak boleh kosong !";		
	}	
	if (trim($txtHrgJual)==""  or ! is_numeric(trim($txtHrgJual))) {
		$pesanError[] = "Data <b>Harga Jual (Rp)</b> tidak boleh kosong !";		
	}
	if (trim($txtStok)=="" or ! is_numeric(trim($txtStok))) {
		$pesanError[] = "Data <b>Stok</b>  tidak boleh kosong !";		
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";		
	}
	if (trim($cmbKategori)=="KOSONG") {
		$pesanError[] = "Data <b>Kategori</b> belum dipilih !";		
	}
		
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='alert alert-danger'><ul class='mb-0'>";
			foreach ($pesanError as $pesan_tampil) {
				echo "<li>$pesan_tampil</li>";
			}
		echo "</ul></div>";
	}
	else {
		# SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database
		// Membaca Kode dari form
		$Kode	= $_POST['txtKode'];
		// Mengkopi file gambar
		if (trim($_FILES['namaFile']['name']) =="") {
			$nama_file = $_POST['txtNamaFileH'];
		}
		else {
			if(file_exists("../img-barang/".$_POST['txtNamaFileH'])) {
				unlink("../img-barang/".$_POST['txtNamaFileH']);	
			}
			$nama_file = $_FILES['namaFile']['name'];
			$nama_file = stripslashes($nama_file);
			$nama_file = str_replace("'","",$nama_file);
			$nama_file = $Kode.".".$nama_file;
			copy($_FILES['namaFile']['tmp_name'],"../img-barang/".$nama_file);		
		}
		$mySql	= "UPDATE barang SET nm_barang = '$txtNama', harga_jual = '$txtHrgJual', stok = '$txtStok', keterangan = '$txtKeterangan', file_gambar = '$nama_file', kd_kategori = '$cmbKategori' WHERE kd_barang = '$Kode'";
		$myQry	= mysqli_query($mysqli, $mySql)  or die ("Query salah : ".mysqli_error($mysqli));
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
		}
	}	
} 

# ======================================================================
# MEMBACA DATA DARI FORM / DATABASE, UNTUK DITAMPILKAN KEMBALI PADA FORM
$Kode   = isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode'];
$mySql  = "SELECT * FROM barang WHERE kd_barang='$Kode'";
$myQry  = mysqli_query($mysqli, $mySql)  or die ("Query ambil data salah : ".mysqli_error($mysqli));
$myData = mysqli_fetch_array($myQry);

$dataKode       = $myData['kd_barang'];
$dataNama       = isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_barang'];
$dataHrgJual    = isset($_POST['txtHrgJual']) ? $_POST['txtHrgJual'] : $myData['harga_jual'];
$dataStok       = isset($_POST['txtStok']) ? $_POST['txtStok'] : $myData['stok'];
$dataKeterangan = isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];
$dataKategori   = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $myData['kd_kategori'];
?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-0 font-weight-bold text-primary">Edit Data Produk</h4>
        </div>
        <div class="card-body">
          <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="frmedit">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">Kode</label>
              <div class="col-sm-9">
                <input name="textfield" value="<?php echo $dataKode; ?>" class="form-control" size="12" maxlength="12" readonly />
                <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">Nama Produk</label>
              <div class="col-sm-9">
                <input name="txtNama" value="<?php echo $dataNama; ?>" class="form-control" maxlength="200" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">Harga Jual (Rp)</label>
              <div class="col-sm-9">
                <input name="txtHrgJual" type="text" value="<?php echo $dataHrgJual; ?>" class="form-control" maxlength="12" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">Jumlah Stok</label>
              <div class="col-sm-9">
                <input name="txtStok" type="text" value="<?php echo $dataStok; ?>" class="form-control" maxlength="6" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">File Gambar</label>
              <div class="col-sm-9">
                <input name="namaFile" type="file" class="form-control-file" />
                <input name="txtNamaFileH" type="hidden" value="<?php echo $myData['file_gambar']; ?>" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">Keterangan</label>
              <div class="col-sm-9">
                <textarea name="txtKeterangan" class="form-control" rows="4"><?php echo $dataKeterangan; ?></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">Kategori</label>
              <div class="col-sm-9">
                <select name="cmbKategori" class="form-control">
                  <option value="KOSONG">Pilih Kategori...</option>
                  <?php
                    $mySql = "SELECT * FROM kategori ORDER BY nm_kategori";
                    $myQry = mysqli_query($mysqli, $mySql) or die ("Gagal Query".mysqli_error($mysqli));
                    while ($myData = mysqli_fetch_array($myQry)) {
                      $cek = ($myData['kd_kategori']== $dataKategori) ? " selected" : "";
                      echo "<option value='$myData[kd_kategori]' $cek> $myData[nm_kategori] </option>";
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-9 offset-sm-3">
                <button type="submit" name="btnSimpan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

