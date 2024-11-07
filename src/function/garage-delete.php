<?php
// Mulai session untuk memastikan pengguna sudah login
session_start();

// Include file koneksi database
include '../../koneksi.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo '<script>alert("Anda harus login terlebih dahulu!");</script>';
    echo '<script>window.location.href = "../login.php";</script>';
    exit();
}

// Periksa apakah parameter id_kendaraan ada
if (isset($_GET['id_kendaraan'])) {
    $id_kendaraan = $_GET['id_kendaraan'];
    $id_user = $_SESSION['id_user'];

    // Hapus kendaraan dari tabel 'garasi' berdasarkan id_kendaraan dan id_user
    $query = "DELETE FROM garasi WHERE id_kendaraan = ? AND id_user = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ii", $id_kendaraan, $id_user);

    if ($stmt->execute()) {
        // Hapus sukses
        echo '<script>alert("Kendaraan berhasil dihapus dari garasi.");</script>';
        echo '<script>window.location.href = "../forms/user/garage.php";</script>';
    } else {
        // Hapus gagal
        echo '<script>alert("Gagal menghapus kendaraan.");</script>';
        echo '<script>window.location.href = "../forms/user/garage.php";</script>';
    }

    $stmt->close();
} else {
    // Jika id_kendaraan tidak ada, kembali ke halaman garasi
    echo '<script>alert("ID kendaraan tidak ditemukan.");</script>';
    echo '<script>window.location.href = "../forms/user/garage.php";</script>';
}

// Tutup koneksi database
$koneksi->close();
?>
