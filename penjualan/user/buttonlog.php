<?php
if (isset($_SESSION['SES_PELANGGAN'])) {
} else {
?>
    <!-- Menu jika belum login -->
    <li class="nav-item">
        <a class="nav-link" href="?open=Formlogin">
            <i class="fas fa-fw fa-sign-in-alt"></i>
            <span>Login</span>
        </a>
    </li>
<?php } ?>



    