<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/store.css">
    <title>Store Page</title>
</head>
<body>


<?php
session_start();

include '../../../koneksi.php';

?>



    <!-- navbar -->
<nav class="navbar navbar-expand-lg" style="position:fixed; width: 100%; z-index: 9999  ;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="../../../public/resource/logoA.png" alt="dslogo" id="dslogo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="../../../home.php">home</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="../../forms/user/mygarage.php">mygarage</a>

        </li>

        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../../forms/user/store-page.php">marketplace</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown link
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
          </ul>
        </li>
      </ul>
      

      <!-- Foto Profil pengguna -->
      <?php
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    // Pengguna sudah login, ambil user ID dari sesi
    $id_user = $_SESSION['id_user'];
    
    // Query untuk mengambil foto profil dari database
    $query = "SELECT profilepict FROM users WHERE id_user = '$id_user'";
    $result = mysqli_query($koneksi, $query);
    
    // Cek apakah query berhasil dieksekusi dan ada hasil
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Cek apakah pengguna memiliki foto profil, jika tidak, gunakan default.png
        $profilepict = (!empty($row['profilepict'])) ? "../uploads/" . $row['profilepict'] : "../uploads/default.png";
    } else {
        // Jika tidak ada hasil dari query atau pengguna belum memiliki foto profil
        $profilepict = "../uploads/default.png";
    }
    
    // Tampilkan gambar profil
    echo '<div class="d-flex ms-auto">
    <div class="dropdown">
        <a class="navbar-brand" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="' . htmlspecialchars($profilepict) . '" alt="pfp" id="pfp" class="rounded-circle" width="30" height="30">
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown" id="pfpdr">
            <li><a class="dropdown-item" href="../profile/profile.php">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../login/logout.php">Logout</a></li>
        </ul>
    </div>
  </div>';

} else {
    // Jika pengguna belum login, tampilkan tombol login dan register
    echo '<div class="d-flex ms-auto">
            <a href="../login/login.php" class="btn btn-login">Login</a>
            <a href="../login/register.php" class="btn btn-register ms-2">Register</a>
          </div>';
}
?>

      </div>
    </div>
  </div>
</nav>
<!-- end navbar -->
    

<div id="marketplace" class="content-section">
    <h1 class="text-center mb-4">Marketplace</h1>

    <div class="container">
        <div class="row">
            <?php
            // Query to fetch vehicle data
            $query = "SELECT id_kendaraan, nm_kendaraan, jenis_kendaraan, tahun, warna, status, harga, foto FROM kendaraan";
            $result = $koneksi->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="data:image/jpeg;base64,' . base64_encode($row['foto']) . '" class="card-img-top" alt="Foto Kendaraan">
                                <div class="card-body">
                                    <h5 class="card-title">' . htmlspecialchars($row['nm_kendaraan']) . '</h5>
                                    <p class="card-text">Jenis: ' . htmlspecialchars($row['jenis_kendaraan']) . '</p>
                                    <p class="card-text">Tahun: ' . htmlspecialchars($row['tahun']) . '</p>
                                    <p class="card-text">Warna: ' . htmlspecialchars($row['warna']) . '</p>
                                    <p class="card-text">Status: ' . htmlspecialchars($row['status']) . '</p>
                                    <p class="card-text">Harga: Rp ' . number_format($row['harga'], 0, ',', '.') . '</p>
                                    <a href="#" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                          </div>';
                }
            } else {
                echo '<div class="col-12">
                        <div class="alert alert-warning text-center">Tidak ada kendaraan yang tersedia saat ini.</div>
                      </div>';
            }
            ?>
        </div>
    </div>
</div>







    
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>