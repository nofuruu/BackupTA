<?php
// Sertakan file koneksi database
include '../../koneksi.php';

// Mendapatkan id_kendaraan dari parameter GET
if (isset($_GET['id_kendaraan'])) {
    $id_kendaraan = $_GET['id_kendaraan'];

    // Query untuk mengambil detail kendaraan langsung dari tabel kendaraan
    $query = "SELECT * 
              FROM kendaraan 
              WHERE id_kendaraan = ?";
    
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_kendaraan);
    $stmt->execute();
    $result = $stmt->get_result();

    // Mengecek apakah ada hasil
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fotoArray = explode(',', $row['foto']); // Memecah string foto menjadi array
    } else {
        echo '<div class="alert alert-warning">Tidak ada detail kendaraan ditemukan untuk ID: ' . htmlspecialchars($id_kendaraan) . '.</div>';
        exit; // Stop further execution if no record found
    }

    // Menutup statement
    $stmt->close();
} else {
    echo '<div class="alert alert-danger">ID kendaraan tidak diberikan.</div>';
    exit;
}

// Menutup koneksi
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/detail.css"> <!-- Link to the CSS file -->
    <title>Detail Kendaraan</title>
</head>
<body>

<div class="container detail-container">
    <div class="row">
        <div class="col-md-6">
            <div class="slider">
                <div class="slides">
                    <?php if (!empty($fotoArray)): ?>
                        <?php foreach ($fotoArray as $foto): ?>
                            <div class="slide">
                                <img src="../../public/uploads/admin/item/<?php echo htmlspecialchars($foto); ?>" alt="Foto Kendaraan" class="detail-image">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="slide">
                            <p>Tidak ada foto tersedia untuk kendaraan ini.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
                <button class="next" onclick="changeSlide(1)">&#10095;</button>
            </div>
        </div>
        <div class="col-md-6">
        
            <h2 class="details-header"><?php echo htmlspecialchars($row['nm_kendaraan']); ?></h2>
            <div class="detail-item">
                <strong>Jenis Kendaraan:</strong> <?php echo htmlspecialchars($row['jenis_kendaraan']); ?>
            </div>
            <div class="detail-item">
                <strong>Harga:</strong> Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
            </div>
            <div class="detail-item">
                <strong>Tahun:</strong> <?php echo htmlspecialchars($row['tahun']); ?>
            </div>
            <div class="detail-item">
                <strong>Warna:</strong> <?php echo htmlspecialchars($row['warna']); ?>
            </div>
            <div class="detail-item">
                <strong>Kondisi:</strong> <?php echo htmlspecialchars($row['kondisi']); ?>
            </div>
            <div class="detail-item">
                <strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?>
            </div>
            <div class="detail-item">
                <strong>Deskripsi:</strong> <?php echo htmlspecialchars($row['deskripsi']); ?>
            </div>
            <a href="javascript:history.back()" class="btn btn-custom">Kembali</a>

            <!-- Form untuk menambahkan kendaraan ke garasi -->
            <form action="../function/add-to-garage.php" method="POST" class="mt-3">
                <input type="hidden" name="id_kendaraan" value="<?php echo htmlspecialchars($id_kendaraan); ?>">
                <button type="submit" class="btn btn-success">Tambahkan ke Garasi</button>
            </form>
        </div>
    </div>
</div>

<script>

let currentSlide = 0;

function showSlide(index) {
    const slides = document.querySelectorAll('.slide');
    if (index >= slides.length) {
        currentSlide = 0; // Kembali ke slide pertama
    } else if (index < 0) {
        currentSlide = slides.length - 1; // Kembali ke slide terakhir
    } else {
        currentSlide = index;
    }
    const offset = -currentSlide * 100; // Menghitung offset untuk menggeser slide
    document.querySelector('.slides').style.transform = `translateX(${offset}%)`;
}

// Fungsi untuk mengganti slide
function changeSlide(direction) {
    showSlide(currentSlide + direction);
}

// Tampilkan slide pertama saat halaman dimuat
document.addEventListener("DOMContentLoaded", function() {
    showSlide(currentSlide);
});

</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
