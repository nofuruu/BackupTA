<?php
include '../connection/koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_kendaraan'])) {
    $id_kendaraan = $_POST['id_kendaraan'];

    // Delete the vehicle from the database
    $query = "DELETE FROM kendaraan WHERE id_kendaraan = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_kendaraan);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Kendaraan berhasil dihapus!";
    } else {
        $_SESSION['message'] = "Gagal menghapus kendaraan: " . $koneksi->error;
    }

    $stmt->close();
    header('Location: admin.php'); // Redirect back to admin page
    exit();
}
