<?php
// Validasi supaya yang mengakses hanya Admin (yang sudah login)
include_once "../../library/inc.sesadmin.php";
?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
          <h4 class="m-0 font-weight-bold text-primary">Data Kategori</h4>
          <a href="?open=Kategori-Add" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah Kategori</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="thead-light">
                <tr>
                  <th class="text-center" style="width:40px;">No</th>
                  <th>Nama Kategori</th>
                  <th class="text-center" colspan="2">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $mySql = "SELECT * FROM kategori ORDER BY nm_kategori ASC";
                $myQry = mysqli_query($mysqli, $mySql)  or die ("Query salah : ".mysqli_error($mysqli));
                $nomor = 1;
                while ($myData = mysqli_fetch_array($myQry)) {
                  $Kode = $myData['kd_kategori'];
                ?>
                <tr>
                  <td class="text-center"><?php echo $nomor++; ?></td>
                  <td><?php echo $myData['nm_kategori']; ?></td>
                  <td class="text-center">
                    <a href="?open=Kategori-Edit&Kode=<?php echo $Kode; ?>" class="btn btn-warning btn-sm" title="Edit Data"><i class="fas fa-edit"></i></a>
                  </td>
                  <td class="text-center">
                    <a href="?open=Kategori-Delete&Kode=<?php echo $Kode; ?>" class="btn btn-danger btn-sm" title="Hapus Data" onclick="return confirm('ANDA YAKIN INGIN MENGHAPUS DATA KATEGORI INI ... ?')"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
