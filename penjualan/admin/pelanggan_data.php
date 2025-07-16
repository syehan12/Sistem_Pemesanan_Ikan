<?php
include_once "../../library/inc.sesadmin.php";
include_once "../../library/inc.library.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris    = 50;
$hal      = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql  = "SELECT * FROM pelanggan";
$pageQry  = mysqli_query($mysqli, $pageSql) or die ("error paging: ".mysqli_error($mysqli));
$jumlah   = mysqli_num_rows($pageQry);
$maksData = ceil($jumlah/$baris);

// Membaca data form cari
$dataCari = isset($_POST['txtCari']) ? $_POST['txtCari'] : '';
?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
          <h4 class="m-0 font-weight-bold text-primary">Data Pelanggan</h4>
          <form class="form-inline" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
            <input name="txtCari" type="text" value="<?php echo $dataCari; ?>" class="form-control form-control-sm mr-2" placeholder="Cari Nama..." size="30" maxlength="100" />
            <button name="btnCari" type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
          </form>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="thead-light">
                <tr>
                  <th class="text-center" style="width:40px;">No</th>
                  <th>Kode</th>
                  <th>Nama Pelanggan</th>
                  <th>No. Telepon</th>
                  <th>Username</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(isset($_POST['btnCari'])){
                  $mySql = "SELECT * FROM pelanggan WHERE nm_pelanggan LIKE '%$dataCari%' ORDER BY kd_pelanggan DESC LIMIT $hal, $baris";
                }
                else {
                  $mySql = "SELECT * FROM pelanggan ORDER BY kd_pelanggan DESC LIMIT $hal, $baris";
                }
                $myQry = mysqli_query($mysqli, $mySql)  or die ("Query salah : ".mysqli_error($mysqli));
                $nomor  = $hal;
                while ($myData = mysqli_fetch_array($myQry)) {
                  $nomor++;
                  $Kode = $myData['kd_pelanggan'];
                ?>
                <tr>
                  <td class="text-center"><?php echo $nomor; ?></td>
                  <td><?php echo $myData['kd_pelanggan']; ?></td>
                  <td><?php echo $myData['nm_pelanggan']; ?></td>
                  <td><?php echo $myData['no_telepon']; ?></td>
                  <td><?php echo $myData['username']; ?></td>
                  <td class="text-center">
                    <a href="?open=Pelanggan-Delete&Kode=<?php echo $Kode; ?>" class="btn btn-danger btn-sm" title="Hapus Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PELANGGAN INI ... ?')"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="row mt-3">
            <div class="col-md-6">
              <span class="text-primary font-weight-bold">Jumlah Data :</span> <?php echo $jumlah; ?>
            </div>
            <div class="col-md-6 text-right">
              <span class="text-primary font-weight-bold">Halaman ke :</span>
              <?php
              for ($h = 1; $h <= $maksData; $h++) {
                $list[$h] = $baris * $h - $baris;
                echo " <a href='?open=Pelanggan-Data&hal=$list[$h]' class='btn btn-outline-primary btn-sm mx-1'>$h</a> ";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
