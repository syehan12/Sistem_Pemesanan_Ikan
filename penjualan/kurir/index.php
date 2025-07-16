<?php 
// untuk koneksi
include_once "../../library/inc.connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login Kurir</title>

  <link href="../assets/kurir/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/kurir/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
  <link href="../assets/kurir/dist/css/sb-admin-2.css" rel="stylesheet">
  <link href="../assets/kurir/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Silahkan Masuk</h3>
          </div>
          <div class="panel-body">

            <?php if (isset($_GET['validasi'])) : ?>
              <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  Username atau Password Anda salah !
              </div>
            <?php endif; ?>

            <form role="form" method="post">
              <fieldset>
                <div class="form-group">
                  <input class="form-control" placeholder="Username" name="username" type="text" required />
                </div>
                <div class="form-group">
                  <input class="form-control" placeholder="Password" name="password" type="password" required />
                </div>
                <input type="submit" name="login" value="Login" class="btn btn-lg btn-success btn-block" />
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../assets/kurir/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/kurir/vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/kurir/vendor/metisMenu/metisMenu.min.js"></script>
  <script src="../assets/kurir/dist/js/sb-admin-2.js"></script>

</body>

</html>

<?php 
if (isset($_POST['login'])) {

  $user = $_POST['username'];
  $pass = $_POST['password'];

  $sql = "SELECT * FROM tb_kurir WHERE username = '$user' AND password = MD5('$pass')";
  $qry = mysqli_query($mysqli, $sql) or die ("MySQL salah !".mysqli_error($mysqli));
  $row = mysqli_fetch_array($qry, MYSQLI_ASSOC);
  $sum = mysqli_num_rows($qry);

  if($sum >= 1) {
    
    // untuk memulai session
    session_start();
    // membuat session
    $_SESSION['SES_PELANGGAN'] = $row['id_kurir'];
    $_SESSION['SES_USERNAME']  = $row['username'];
    // redirect ke halaman dashboard
    header('location: dashboard.php');

	}	else {
    header('location: index.php?validasi');
  }

}
?>