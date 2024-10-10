<?php
session_start(); // Memulai session

// Menghapus semua session
session_unset(); // Menghapus semua variabel session
session_destroy(); // Menghancurkan session

// Mengarahkan pengguna kembali ke halaman login
echo "<script>alert('Anda telah logout!'); window.location.href='login/login.php';</script>";
?>
