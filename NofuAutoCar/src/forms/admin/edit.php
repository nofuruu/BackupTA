<?php
include '../connection/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kendaraan = $_POST['id_kendaraan'];
    $nm_kendaraan = $_POST['nm_kendaraan'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $tahun = $_POST['tahun'];
    $warna = $_POST['warna'];
    $status = $_POST['status'];
    $harga = $_POST['harga'];

    // Prepare SQL statement
    $stmt = $koneksi->prepare("UPDATE kendaraan SET nm_kendaraan=?, jenis_kendaraan=?, tahun=?, warna=?, status=?, harga=? WHERE id_kendaraan=?");
    $stmt->bind_param("ssisssi", $nm_kendaraan, $jenis_kendaraan, $tahun, $warna, $status, $harga, $id_kendaraan);

    // Execute the statement
    if ($stmt->execute()) {
        // Check if an image was uploaded
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $foto = file_get_contents($_FILES['foto']['tmp_name']);
            $updatePhotoStmt = $koneksi->prepare("UPDATE kendaraan SET foto=? WHERE id_kendaraan=?");
            $updatePhotoStmt->bind_param("bi", $foto, $id_kendaraan);
            $updatePhotoStmt->execute();
        }

        $message = "Kendaraan berhasil diperbarui!";
    } else {
        $message = "Gagal memperbarui kendaraan: " . $stmt->error;
    }

    $stmt->close();
    $koneksi->close();

    // Redirect back to the management page with a message
    header("Location: admin.php?message=" . urlencode($message));
    exit();
}
?>
