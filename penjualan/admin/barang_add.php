<?php
// Validasi Login : yang boleh mengakses halaman ini hanya yang sudah Login admin
include_once "../../library/inc.sesadmin.php";
include_once "../../library/inc.library.php";

# TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca form
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
		$pesanError[] = "Data <b>Nama Barang</b> tidak boleh kosong !";		
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
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "<li>$pesan_tampil</li>";	
			} 
		echo "</ul></div>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database
		// Membuat kode baru
		$kodeBaru	= buatKode("barang", "B", $mysqli);

		// Mengkopi file gambar
		if (! empty($_FILES['namaFile']['tmp_name'])) {
			$nama_file = $_FILES['namaFile']['name'];
			$nama_file = stripslashes($nama_file);
			$nama_file = str_replace("'","",$nama_file);
			$nama_file = str_replace(" ","-",$nama_file);
			$nama_file = $kodeBaru.".".$nama_file;
			copy($_FILES['namaFile']['tmp_name'],"../img-barang/".$nama_file);
		}
		else {
			$nama_file = "";
		}
		
		// Simpan data dari form ke database
		$mySql	= "INSERT INTO barang (kd_barang, nm_barang, harga_jual, stok, keterangan, file_gambar,  kd_kategori) VALUES('$kodeBaru', '$txtNama', '$txtHrgJual', '$txtStok', '$txtKeterangan', '$nama_file', '$cmbKategori')";
		$myQry	= mysqli_query($mysqli, $mySql)  or die ("Query salah : ".mysqli_error($mysqli));
		if($myQry){				
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
		}
	}	
} 

# MEMBUAT NILAI DATA PADA FORM
# SIMPAN DATA PADA FORM, Jika saat Sumbit ada yang kosong (lupa belum diisi)
$dataKode		= buatKode("barang", "B", $mysqli);
$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataHrgJual	= isset($_POST['txtHrgJual']) ? $_POST['txtHrgJual'] : '';
$dataStok		= isset($_POST['txtStok']) ? $_POST['txtStok'] : '';  
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : ''; 
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-0 font-weight-bold text-primary">Tambah Data Produk</h4>
        </div>
        <div class="card-body">
          <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="frmadd">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">Kode</label>
              <div class="col-sm-9">
                <input name="textfield" value="<?php echo $dataKode; ?>" class="form-control" size="10" maxlength="10" readonly />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">Nama Barang</label>
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
                <input name="txtStok" type="text" value="<?php echo $dataStok; ?>" class="form-control" maxlength="10" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">File Gambar</label>
              <div class="col-sm-9">
                <input name="namaFile" type="file" class="form-control-file" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">Keterangan</label>
              <div class="col-sm-9">
                <textarea id="elm1" name="txtKeterangan" class="form-control" rows="4"><?php echo $dataKeterangan; ?></textarea>
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
