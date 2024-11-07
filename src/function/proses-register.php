<?php
include '../../koneksi.php'; // Menghubungkan dengan file koneksi

// Mendapatkan input dari form
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$verpass = $_POST['verpass'];

// Cek apakah username atau email sudah terdaftar
$query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
$result = mysqli_query($koneksi, $query);

// Jika username atau email sudah ada
if (mysqli_num_rows($result) > 0) {
    // Redirect ke halaman register dengan parameter error dan modal muncul
    header("Location: ../forms/register.php?error=exists");
    exit;
}

// Proses pengecekan dan simpan data jika verifikasi password sesuai
if ($password === $verpass) {
    // Enkripsi password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk menyimpan user baru dengan peran "user"
    $insert_query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', 'user')";
    
    if (mysqli_query($koneksi, $insert_query)) {
        // Redirect ke halaman login dengan parameter success
        header("Location: ../forms/register.php?register=success");
        exit;
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($koneksi);
    }
} else {
    // Redirect jika password dan verifikasi password tidak sesuai
    header("Location: ../forms/register.php?error=password_mismatch");
    exit;
}

mysqli_close($koneksi);
?>
