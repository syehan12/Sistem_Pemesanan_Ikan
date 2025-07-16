<?php
include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

# JIKA PENYIMPANAN SUKSES
if(isset($_GET['Aksi']) and $_GET['Aksi']=="Sukses"){
	echo "<br><br><center> <b>SELAMAT, PENAFTARAN ANDA SUDAH KAMI TERIMA </b><br> Sekarang, Anda dapat login untuk melakukan pemesanan </center>";
	echo "<meta http-equiv='refresh' content='2; url='?open=Barang'>";
	exit;
}

# BACA VARIABEL FORM
$dataNama      = isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataEmail     = isset($_POST['txtEmail']) ? $_POST['txtEmail'] : '';
$dataNoTelepon = isset($_POST['txtNoTelepon']) ? $_POST['txtNoTelepon'] : '';
$dataUsername  = isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Pendaftaran Pelanggan</h1>
                            </div>
                            <form class="user" name="form1" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" target="_self">
                                <div class="form-group">
                                     <input class="form-control form-control-user" name="txtNama" type="text" size="60" maxlength="60" placeholder="Nama Pelanggan" value="<?php echo $dataNama; ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control form-control-user"  name="txtEmail" type="text" size="60" placeholder="Email Address" maxlength="40" value="<?php echo $dataEmail; ?>" />
                                </div>
                                <div class="form-group">
                                    <input class="form-control form-control-user"  name="txtNoTelepon" type="number" size="30" placeholder="No Telepone" maxlength="20" value="<?php echo $dataNoTelepon; ?>" />
                                </div>
                                <div class="form-group">
                                    <input class="form-control form-control-user" name="txtAlamatLengkap" placeholder="Masukkan Alamat Lengkap Anda!">
                                </div>
                                  <hr>
                                <div class="text-center">
                                  <h1 class="h4 text-gray-900 mb-4">Data Login</h1>
                                </div>
                                <div class="form-group">
                                  <input class="form-control form-control-user" placeholder="Username" name="txtUsername" type="text" size="25" maxlength="40" value="<?php echo $dataUsername; ?>">  
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="txtPassword_1" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="txtPassword_2" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <button type="submit" name="btnDaftar" value="Daftar" class="btn btn-primary btn-user btn-block">
                                    <span style="color: white;">Register Account</span>
                                </button>
                                <hr>
                            </form>
                            <div class="text-center">
                                <a class="small" href="?open=Formlogin">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>


<?php
  if(isset($_POST['btnDaftar'])){
	// Baca Variabel Form
	$txtNama       = $_POST['txtNama'];
	$txtNama       = str_replace("'","&acute;",$txtNama);
	$txtNoTelepon  = $_POST['txtNoTelepon'];
	$txtUsername   = $_POST['txtUsername'];
	$txtPassword_1 = $_POST['txtPassword_1'];
	$txtPassword_2 = $_POST['txtPassword_2'];
	$txtAlamatLeng = $_POST['txtAlamatLengkap'];

	// untuk email
	$txtEmail = $_POST['txtEmail'];
	$txtPesan = "Selamat email Anda telah aktif!";

	// Validasi, jika data kosong kirimkan pesan error
	$pesanError = array();
	if (trim($txtNama) =="") {
		$pesanError[] = "Data <b>Nama Pelanggan</b> masih kosong";
	}
	if (trim($txtEmail) =="") {
		$pesanError[] = "Data <b>Alamat Email</b> masih kosong";
	}
	if (trim($txtNoTelepon) =="") {
		$pesanError[] = "Data <b>No. Telepon</b> masih kosong";
	}
	if (trim($txtUsername) =="") {
		$pesanError[] = "Data <b>Username</b> masih kosong";
	}
	if (trim($txtPassword_1) =="") {
		$pesanError[] = "Data <b>Password</b> masih kosong";
	}
	if (trim($txtPassword_1) != trim($txtPassword_2)) {
		$pesanError[] = "Data <b>Password Ke 2</b> tidak sama dengan sebelumnya";
	}
	
	// Valiasii Username, tidak boleh ada yang kembar
	$sqlCek = "SELECT * FROM pelanggan WHERE username='$txtUsername'";
	$qryCek = mysqli_query($mysqli, $sqlCek);
	$adaCek = mysqli_num_rows($qryCek);
	if($adaCek >= 1) {	
			$pesanError[] = "Errrrrrooorrrr...!!, User <b> $txtUsername </b> sudah ada yang menggunakan.";
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
		echo "<br>"; 
	} else {

		// untuk mengirim email
		if (kirim_email($txtEmail, $txtPesan) == '') {
			// untuk menyimpan data kedatabase dan mengirim validasi email aktif
			$kodeBaru = buatKode("pelanggan","P", $mysqli);
			$tanggal  = date('Y-m-d');
			$mySql    = "INSERT INTO pelanggan (kd_pelanggan, nm_pelanggan, email, alamat_lengkap, no_telepon, username, password, tgl_daftar) VALUES ('$kodeBaru', '$txtNama', '$txtEmail', '$txtAlamatLeng', '$txtNoTelepon', '$txtUsername', MD5('$txtPassword_1'), '$tanggal')";
			$myQry    = mysqli_query($mysqli, $mySql);

			if($myQry) {
				echo "<meta http-equiv='refresh' content='0; url='?open=Barang'>";
			}
		} else {
			echo "<div class='pesanError' align='left'> Maaf Gagal diproses! </div>";
		}

	  }	
  }
  ?>