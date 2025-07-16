<?php
// Validasi : Halaman ini hanya untuk yang sudah login
include_once "../../library/inc.sesadmin.php";

# MEMBACA TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca form
	$txtNama = $_POST['txtNama'];
	$txtNama = str_replace("'","&acute;",$txtNama);  // Membuang karakter petik
	
	// Validasi form
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Kategori</b> tidak boleh kosong !";		
	}
	
	// Validasi Nama Kategori, tidak boleh ada yang kembar (namanya sama)
	$cekSql ="SELECT * FROM kategori WHERE nm_kategori='$txtNama'";
	$cekQry =mysqli_query($mysqli, $cekSql) or die ("Eror Query".mysqli_error($mysqli)); 
	if(mysqli_num_rows($cekQry)>=1){
		$pesanError[] = "Maaf, Kategori <b> $txtNama </b> sudah ada, ganti dengan yang nama berbeda";
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
		$kodeBaru = buatKode("kategori", "K", $mysqli);
		$mySql    = "INSERT INTO kategori SET kd_kategori='$kodeBaru', nm_kategori='$txtNama'";
		$myQry    = mysqli_query($mysqli, $mySql) or die ("Query salah : ".mysqli_error($mysqli));
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Add'>";
		}
	}
} // End if($_POST) 

# Membuat nilai data pada form input
$dataKode = buatKode("kategori", "K", $mysqli);
$dataKategori = isset($_POST['txtNama']) ?  $_POST['txtNama'] : '';
?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-0 font-weight-bold text-primary">Tambah Data Kategori</h4>
        </div>
        <div class="card-body">
          <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd" target="_self">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label font-weight-bold">Kode</label>
              <div class="col-sm-8">
                <input name="textfield" value="<?php echo $dataKode; ?>" class="form-control" maxlength="10" readonly />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label font-weight-bold">Nama Kategori</label>
              <div class="col-sm-8">
                <input name="txtNama" value="<?php echo $dataKategori; ?>" class="form-control" maxlength="100" />
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-8 offset-sm-4">
                <button type="submit" name="btnSimpan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
