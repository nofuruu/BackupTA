<?php
include '../connection/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];
$verpass = $_POST['verpass'];
$email = $_POST['email'];

// Validasi: Pastikan password dan konfirmasi password cocok
if ($password !== $verpass) {
    echo "<div class='alert alert-danger' role='alert'>Password dan konfirmasi password tidak cocok.</div>";
    exit; // Menghentikan eksekusi jika password tidak cocok
}

// Cek apakah username atau email sudah terdaftar
$query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
$result = mysqli_query($koneksi, $query);

// Memeriksa apakah ada hasil yang dikembalikan
if (mysqli_num_rows($result) > 0) {
    echo "<div class='alert alert-danger' role='alert'>Username atau email sudah terdaftar. Silakan gunakan yang lain.</div>";
    exit; // Menghentikan eksekusi jika username atau email sudah ada
}

//memasukan ke database
$sql = "INSERT INTO users (username, password, email, bergabung_sejak) VALUES ('$username', '$password', '$email', NOW())";

// Eksekusi query
if (mysqli_query($koneksi, $sql)) {
    // Menampilkan animasi loading
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Loading...</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background-color: rgb(30, 63, 87);
                color: white;
                font-family: Arial, sans-serif;
            }
            .loader {
                border: 8px solid rgba(255, 255, 255, 0.2);
                border-top: 8px solid #ffffff;
                border-radius: 50%;
                width: 60px;
                height: 60px;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    </head>
    <body>
        <div class='loader'></div>
        <script>
            setTimeout(function() {
                window.location.href = '../login/login.php';
            }, 2000);
        </script>
    </body>
    </html>";
} else {
    echo "<div class='alert alert-danger' role='alert'>Error: " . mysqli_error($koneksi) . "</div>";
}
?>
