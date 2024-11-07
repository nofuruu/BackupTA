<?php
include '../../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kendaraan = $_POST['id_kendaraan'];
    $nm_kendaraan = $_POST['nm_kendaraan'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $tahun = $_POST['tahun'];
    $warna = $_POST['warna'];
    $status = $_POST['status'];
    $harga = $_POST['harga'];

    // Get the current photo before updating
    $currentFotoQuery = "SELECT foto FROM kendaraan WHERE id_kendaraan=?";
    $stmt = $koneksi->prepare($currentFotoQuery);
    $stmt->bind_param("i", $id_kendaraan);
    $stmt->execute();
    $stmt->bind_result($currentFoto);
    $stmt->fetch();
    $stmt->close();

    // Prepare SQL statement for updating the vehicle information
    $updateStmt = $koneksi->prepare("UPDATE kendaraan SET nm_kendaraan=?, jenis_kendaraan=?, tahun=?, warna=?, status=?, harga=? WHERE id_kendaraan=?");
    $updateStmt->bind_param("ssisssi", $nm_kendaraan, $jenis_kendaraan, $tahun, $warna, $status, $harga, $id_kendaraan);

    // Execute the update statement
    if ($updateStmt->execute()) {
        // Check if an image was uploaded
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            // Handle new image uploads
            $targetDir = '../../../public/uploads/admin/item/';
            $newFoto = $_FILES['foto']['name'];
            $targetFilePath = $targetDir . basename($newFoto);

            // Move the uploaded file to the target location
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFilePath)) {
                // Update the main image in kendaraan table
                $updateMainPhotoStmt = $koneksi->prepare("UPDATE kendaraan SET foto=? WHERE id_kendaraan=?");
                $updateMainPhotoStmt->bind_param("si", $newFoto, $id_kendaraan);
                $updateMainPhotoStmt->execute();
                $updateMainPhotoStmt->close();
            } else {
                echo "Gagal mengupload foto baru: " . $_FILES['foto']['error'] . "<br>";
            }
        } else {
            // If no new photo is uploaded, keep the existing photo
            $updatePhotoStmt = $koneksi->prepare("UPDATE kendaraan SET foto=? WHERE id_kendaraan=?");
            $updatePhotoStmt->bind_param("si", $currentFoto, $id_kendaraan);
            $updatePhotoStmt->execute();
            $updatePhotoStmt->close();
        }

        $message = "Kendaraan berhasil diperbarui!";
    } else {
        $message = "Gagal memperbarui kendaraan: " . $updateStmt->error;
    }

    $updateStmt->close();
    $koneksi->close();

    // Redirect back to the management page with a message
    header("Location: admin.php?message=" . urlencode($message));
    exit();
}
?>
