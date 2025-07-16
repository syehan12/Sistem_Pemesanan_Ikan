<?php
// Validasi Login : yang boleh mengakses halaman ini hanya yang sudah Login admin
include_once "../../library/inc.sesadmin.php";

# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	// Baca form
	$txtPassBaru= $_POST['txtPassBaru'];
	$txtPassLama= $_POST['txtPassLama'];
	
	// Validasi form
	$pesanError = array();
	if (trim($txtPassBaru)=="") {
		$pesanError[] = "Data <b> Password baru </b> belum diisi !";		
	}
	
	// Validasi Password lama (harus benar)
	$sqlCek = "SELECT * FROM admin WHERE username='admin' AND password ='".md5($txtPassLama)."'";
	$qryCek = mysqli_query($mysqli, $sqlCek)  or die ("Query Periksa Password Salah : ".mysqli_error($mysqli));
	if(mysqli_num_rows($qryCek) <1){
		$pesanError[] = "Maaf, <b> Password Anda Salah</b>....silahkan ulangi";
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
		$mySql	= "UPDATE admin SET password='".md5($txtPassBaru)."'";
		$myQry	= mysqli_query($mysqli, $mySql);
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Logout&Info=Password Berhasil Diganti'>";
		}
	}	
}  

# Membaca Data Login untuk diedit
$mySql = "SELECT * FROM admin";
$myQry = mysqli_query($mysqli, $mySql)  or die ("Query salah : ".mysqli_error($mysqli));
$myData= mysqli_fetch_array($myQry);
?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-0 font-weight-bold text-primary">Ganti Password Admin</h4>
        </div>
        <div class="card-body">
          <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label font-weight-bold">Username</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" value="<?php echo $myData['username']; ?>" readonly />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label font-weight-bold">Password Lama</label>
              <div class="col-sm-8">
                <input name="txtPassLama" type="password" class="form-control" maxlength="30" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label font-weight-bold">Password Baru</label>
              <div class="col-sm-8">
                <input name="txtPassBaru" type="password" class="form-control" maxlength="30" />
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-8 offset-sm-4">
                <button type="submit" name="btnSimpan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
              </div>
            </div>
          </form>
          <div class="alert alert-warning mt-3 mb-0">
            Anda juga dapat merubah Password lewat tools <strong>phpMyAdmin</strong>, gunakan tipe enkripsi data <strong>MD5</strong> untuk Password.
          </div>
        </div>
      </div>
    </div>
  </div>
</div>