<?php
include '../../../koneksi.php';

$message = ''; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $nm_kendaraan = $_POST['nm_kendaraan'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $tahun = $_POST['tahun'];
    $warna = $_POST['warna'];
    $status = $_POST['status'];
    $harga = $_POST['harga'];

    // Handle file upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = file_get_contents($_FILES['foto']['tmp_name']); // Get image data

        // Prepare and execute the insert statement
        $stmt = $koneksi->prepare("INSERT INTO kendaraan (nm_kendaraan, jenis_kendaraan, tahun, warna, status, harga, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissis", $nm_kendaraan, $jenis_kendaraan, $tahun, $warna, $status, $harga, $foto);

        if ($stmt->execute()) {
            $message = "Kendaraan berhasil diupload!";
            // Redirect to admin.php with message
            header("Location: ../admin/admin.php?message=" . urlencode($message));
            exit();
        } else {
            $message = "Terjadi kesalahan saat menyimpan data kendaraan.";
        }

        $stmt->close();
    } else {
        $message = "Terjadi kesalahan saat mengupload foto.";
    }
}
?>
