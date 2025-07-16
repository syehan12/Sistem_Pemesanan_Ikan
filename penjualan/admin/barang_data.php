<?php
include_once "../../library/inc.sesadmin.php";   // Validasi, mengakses halaman harus Login
include_once "../../library/inc.connection.php"; // Membuka koneksi
include_once "../../library/inc.library.php";    // Membuka librari peringah fungsi

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris = 30;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang";
$pageQry = mysqli_query($mysqli, $pageSql) or die ("error paging: ".mysqli_error($mysqli));
$jumlah	 = mysqli_num_rows($pageQry);
$maksData= ceil($jumlah/$baris);
?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
          <h4 class="m-0 font-weight-bold text-primary">Data Total Produk</h4>
          <a href="?open=Barang-Add" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah Produk</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="thead-light">
                <tr>
                  <th class="text-center" style="width:40px;">No</th>
                  <th>Kode</th>
                  <th>Nama Produk</th>
                  <th class="text-center">Stok</th>
                  <th class="text-right">Harga (Rp)</th>
                  <th class="text-center" colspan="2">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php	
                $mySql = "SELECT * FROM barang ORDER BY kd_barang ASC LIMIT $hal, $baris";
                $myQry = mysqli_query($mysqli, $mySql)  or die ("Query salah : ".mysqli_error($mysqli));
                $nomor = $hal; 
                while ($myData = mysqli_fetch_array($myQry)) {
                  $nomor++;
                  $Kode = $myData['kd_barang'];
                ?>
                <tr>
                  <td class="text-center"><?php echo $nomor; ?></td>
                  <td><?php echo $myData['kd_barang']; ?></td>
                  <td><?php echo $myData['nm_barang']; ?></td>
                  <td class="text-center"><span class="badge badge-info"><?php echo $myData['stok']; ?></span></td>
                  <td class="text-right"><?php echo format_angka($myData['harga_jual']); ?></td>
                  <td class="text-center">
                    <a href="?open=Barang-Edit&Kode=<?php echo $Kode; ?>" class="btn btn-warning btn-sm" title="Edit Data"><i class="fas fa-edit"></i></a>
                  </td>
                  <td class="text-center">
                    <a href="?open=Barang-Delete&Kode=<?php echo $Kode; ?>" class="btn btn-danger btn-sm" title="Hapus Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA INI ... ?')"><i class="fas fa-trash-alt"></i></a>
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
                echo " <a href='?open=Barang-Data&hal=$list[$h]' class='btn btn-outline-primary btn-sm mx-1'>$h</a> ";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
