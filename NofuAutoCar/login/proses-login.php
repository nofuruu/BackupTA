<?php
session_start();
include '../connection/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form login
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    
    // Query untuk mencari user berdasarkan username atau email
    $queryUser = "SELECT * FROM users WHERE (username = '$username' OR email = '$username') LIMIT 1";
    $resultUser = mysqli_query($koneksi, $queryUser);

    // Query untuk mencari admin berdasarkan username
    $queryAdmin = "SELECT * FROM admin WHERE (username = '$username') LIMIT 1";
    $resultAdmin = mysqli_query($koneksi, $queryAdmin);

    // Jika hasil query admin lebih dari 0, berarti admin ditemukan
    if ($resultAdmin && mysqli_num_rows($resultAdmin) > 0) {
        $admin = mysqli_fetch_assoc($resultAdmin);

        // Cek apakah password yang dimasukkan sesuai dengan password di tabel admin
        if ($admin['password'] === $password) {
            // Jika login sebagai admin, set session dan redirect ke home-admin.php
            $_SESSION['login'] = true;
            $_SESSION['id_admin'] = $admin['id_admin'];
            $_SESSION['username'] = $admin['username'];

            echo "<script>alert('Login sebagai admin berhasil!'); window.location.href='../home/admin.php';</script>";
        } else {
            echo "<script>alert('Password admin salah!'); window.location.href='../login/login.php';</script>";
        }
    }
    // Jika user biasa yang login
    elseif ($resultUser && mysqli_num_rows($resultUser) > 0) {
        $user = mysqli_fetch_assoc($resultUser);

        // Cek apakah password yang dimasukkan sesuai dengan password di database users
        if ($user['password'] === $password) {
            // Jika password benar, set session dan redirect ke home.php
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];

            echo "<script>alert('Login berhasil!'); window.location.href='../home/home.php';</script>";
        } else {
            echo "<script>alert('Password salah!'); window.location.href='../login/login.php';</script>";
        }
    } else {
        echo "<script>alert('Username atau email tidak ditemukan!'); window.location.href='../login/login.php';</script>";
    }
}
?>
