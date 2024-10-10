<?php
session_start();
include 'D:\xampp\htdocs\NofuAutoCar\connection\koneksi.php'; // Pastikan file koneksi ke database sudah ada dan berfungsi dengan benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form login
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    
    // Query untuk mencari user berdasarkan username atau email
    $query = "SELECT * FROM user WHERE (username = '$username' OR email = '$email') LIMIT 1";
    $result = mysqli_query($koneksi, $query);

    // Jika hasil query lebih dari 0, berarti user ditemukan
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Cek apakah password yang dimasukkan sesuai dengan password di database
        if ($user['password'] === $password) {
            // Jika password benar, set session dan redirect ke home.php
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $user['id_user']; // Menyimpan id_user dalam session
            $_SESSION['username'] = $user['username'];

            echo "<script>alert('Login berhasil!'); window.location.href='home/home-user.php';</script>";
        } else {
            // Jika password salah
            echo "<script>alert('Password salah!'); window.location.href='login.php';</script>";
        }
    } else {
        // Jika username atau email tidak ditemukan
        echo "<script>alert('Username atau email tidak ditemukan!'); window.location.href='login.php';</script>";
    }
}
?>
