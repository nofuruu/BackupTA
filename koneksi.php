<?php
$host ="localhost";
$username="root";
$password="";
$dbname="nofuauto";
$koneksi = mysqli_connect($host, $username, $password, $dbname,);

if(!$koneksi){
    die("Gagal Terhubung ".mysqli_connect_error());
}else{
    //  echo 'berhasil';
}
?>