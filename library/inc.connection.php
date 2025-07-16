<?php
$my['host']	= "localhost";
$my['user']	= "root";
$my['pass']	= "";
$my['dbs']	= "si_pemesanan";

$mysqli = mysqli_connect($my['host'], $my['user'], $my['pass'], $my['dbs']);

if ($mysqli->connect_error) {
    die('Failed Connection !' . $mysqli->connect_error);
}