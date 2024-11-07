<?php
include '../../../koneksi.php';

$message = ''; // Inisialisasi variabel pesan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $nm_kendaraan = $_POST['nm_kendaraan'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $tahun = $_POST['tahun'];
    $warna = $_POST['warna'];
    $kondisi = $_POST['kondisi'];
    $status = $_POST['status'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    // Persiapkan dan eksekusi pernyataan insert untuk tabel kendaraan
    $stmt = $koneksi->prepare("INSERT INTO kendaraan (nm_kendaraan, jenis_kendaraan, tahun, warna, status, harga, deskripsi) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissis", $nm_kendaraan, $jenis_kendaraan, $tahun, $warna, $status, $harga, $deskripsi);

    if ($stmt->execute()) {
        // Ambil ID kendaraan yang baru saja dimasukkan
        $id_kendaraan = $stmt->insert_id;

        // Tangani unggahan banyak file
        if (!empty($_FILES['foto']['name'][0])) {
            $targetDir = '../../../public/uploads/admin/item/';
            $fotoArray = []; // Array untuk menyimpan nama file foto

            foreach ($_FILES['foto']['name'] as $key => $fileName) {
                $targetFilePath = $targetDir . basename($fileName);

                // Pindahkan file yang diunggah ke direktori tujuan
                if (move_uploaded_file($_FILES['foto']['tmp_name'][$key], $targetFilePath)) {
                    $fotoArray[] = $fileName; // Tambahkan nama file ke array
                }
            }

            // Simpan semua nama file foto sebagai string yang dipisahkan koma
            $fotoString = implode(',', $fotoArray);

            // Update tabel kendaraan untuk menyimpan foto
            $updateStmt = $koneksi->prepare("UPDATE kendaraan SET foto = ? WHERE id_kendaraan = ?");
            $updateStmt->bind_param("si", $fotoString, $id_kendaraan);
            $updateStmt->execute();
            $updateStmt->close();
        }

        $message = "Kendaraan dan foto berhasil diupload!";
        header("Location: ../admin/admin.php?message=" . urlencode($message));
        exit();
    } else {
        $message = "Terjadi kesalahan saat menyimpan data kendaraan.";
    }

    $stmt->close();
}
?>
