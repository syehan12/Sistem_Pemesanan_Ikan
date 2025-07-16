<?php
// memanggil phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// menload vendor autoload
include_once '../../vendor/autoload.php';
// mengambil koneksi database
include_once "inc.connection.php";

function buatKode($tabel, $inisial, $mysqli){
	$struktur = mysqli_query($mysqli, "SELECT * FROM $tabel");
	$field    = mysqli_fetch_field_direct($struktur, 0)->name;
	$panjang  = mysqli_num_rows($struktur);

 	$qry	= mysqli_query($mysqli, "SELECT MAX(".$field.") FROM ".$tabel);
	$row	= mysqli_fetch_array($qry, MYSQLI_NUM); 
	 
 	if ($row[0] == "") {
 		$angka = 0;
	} else {
 		$angka = substr($row[0], strlen($inisial));
	}
	
 	$angka++;
 	$angka = strval($angka); 
	$tmp   = "";
	
 	for($i=1; $i <= 3; $i++) {
		$tmp=$tmp."0";
	}
 	return $inisial.sprintf("%04s", $angka);
}

function form_tanggal($nama,$value=''){
	echo" <input type='text' name='$nama' id='$nama' size='9' maxlength='20' value='$value' readonly/>&nbsp;
	<img src='../images/calendar-add-icon.png' align='top' style='cursor:pointer; margin-top:7px;' alt='kalender'onclick=\"displayCalendar(document.getElementById('$nama'),'dd-mm-yyyy',this)\"/>			
	";
}


// config.php
$base_url = "http://localhost/SI-Pemesanan-Ikan/";



function InggrisTgl($tanggal){
	$tgl=substr($tanggal,0,2);
	$bln=substr($tanggal,3,2);
	$thn=substr($tanggal,6,4);
	$awal="$thn-$bln-$tgl";
	return $awal;
}

function IndonesiaTgl($tanggal){
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$awal="$tgl-$bln-$thn";
	return $awal;
}
 
function lastday($month = '', $year = '') {
   if (empty($month)) {
      $month = date('m');
   }
   if (empty($year)) {
      $year = date('Y');
   }
   $result = strtotime("{$year}-{$month}-01");
   $result = strtotime('-1 second', strtotime('+1 month', $result));
   return date('d', $result);
}

function lastmonth($month = '', $year = '') {
   if (empty($month)) {
      $month = date('m');
   }
   if (empty($year)) {
      $year = date('Y');
   }
   $result = strtotime("{$year}-{$month}-01");
   $result = strtotime('-1 second', strtotime('+1 month', $result));
   return date('m', $result);
}

function format_angka($angka) {
	if ($angka > 1) {
		$hasil =  number_format($angka,0, ",",".");
	}
	else {
		$hasil = 0; 
	}
	return $hasil;
}

// untuk validasi email
function kirim_email($to, $pesan)
{
	try {
		// class phpmailer
		$mail = new PHPMailer(true);
		// konfigurasi server dengan menggunakan akun gmail
		// $mail->SMTPDebug = true; // untuk mengetahui bugnya
		$mail->isSMTP(); // untuk melakukan proses pengiriman
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'akunbaruu0094@gmail.com';
		$mail->Password   = 'Indomaret123';
		$mail->SMTPSecure = 'tls';
		$mail->Port       = 587; // port ssl dan 465
		// pengirim dari email
		$mail->setFrom('akunbaruu0094@gmail.com', 'Administrator !');
		// email yang akan dikirim
		$mail->addAddress($to);
		$mail->addCC('akunbaruu0094@gmail.com');
		$mail->addBCC('akunbaruu0094@gmail.com');
		// isi email yang akan dikirim
		$mail->isHTML(true);
		$mail->Subject = 'Aktivasi akun Anda !';
		// penyimpanan isi pesan
		$mail->Body    = $pesan;
		$mail->AltBody = strip_tags($pesan);
		$mail->send();
	} catch (Exception $e) {
		echo "Gagal: {$mail->ErrorInfo}";
	}
}