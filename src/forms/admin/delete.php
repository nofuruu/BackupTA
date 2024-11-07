<?php
include '../../../koneksi.php';
session_start();

$message = ''; // Inisialisasi variabel pesan

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_kendaraan'])) {
    $id_kendaraan = $_POST['id_kendaraan'];

    // Hapus kendaraan dari tabel garasi terlebih dahulu
    $queryGarage = "DELETE FROM garasi WHERE id_kendaraan = ?";
    $stmtGarage = $koneksi->prepare($queryGarage);
    $stmtGarage->bind_param("i", $id_kendaraan);

    if ($stmtGarage->execute()) {
        // Setelah berhasil menghapus dari garasi, hapus dari tabel kendaraan
        $queryKendaraan = "DELETE FROM kendaraan WHERE id_kendaraan = ?";
        $stmtKendaraan = $koneksi->prepare($queryKendaraan);
        $stmtKendaraan->bind_param("i", $id_kendaraan);

        if ($stmtKendaraan->execute()) {
            $message = "Kendaraan berhasil dihapus!";
        } else {
            $message = "Gagal menghapus kendaraan dari tabel kendaraan: " . $koneksi->error;
        }

        $stmtKendaraan->close();
    } else {
        $message = "Gagal menghapus kendaraan dari garasi: " . $koneksi->error;
    }

    $stmtGarage->close();

    // Redirect ke halaman admin dengan pesan notifikasi
    header("Location: ../admin/admin.php?message=" . urlencode($message));
    exit();
}
?>
