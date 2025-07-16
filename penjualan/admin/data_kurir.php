<?php
include_once "../../library/inc.sesadmin.php";
?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-0 font-weight-bold text-primary">Data Kurir</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="thead-light">
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>Email</th>
                  <th>No. Hp</th>
                  <th>Username</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $nomor = 1;
                $mySql = "SELECT * FROM tb_kurir";
                $myQry = mysqli_query($mysqli, $mySql)  or die ("Query salah : ".mysqli_error($mysqli));
                ?>
                <?php if(mysqli_num_rows($myQry) > 0): ?>
                  <?php while ($myData = mysqli_fetch_array($myQry)) : ?>
                  <tr>
                    <td><?= $nomor++; ?></td>
                    <td><?= $myData['nama'] ?></td>
                    <td><?= ($myData['kelamin'] != 'P') ? 'Laki - laki' : 'Perempuan' ?></td>
                    <td><?= $myData['email'] ?></td>
                    <td><?= $myData['nohp'] ?></td>
                    <td><?= $myData['username'] ?></td>
                  </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center"><b>Data Kurir tidak ada !</b></td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>