<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="home.css">
  <title>Home</title>
</head>
<body>

<?php
include '../connection/koneksi.php';

session_start();





?>

<!-- navbar -->
<nav class="navbar navbar-expand-lg" style="position:fixed; width: 100%; z-index: 9999  ;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="../assets/logoA.png" alt="dslogo" id="dslogo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
            <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
                <a class="nav-link" href="../profile/profile.php">MyProfile</a>
            <?php else: ?>
                <a class="nav-link" href="../login/login.php">MyProfiles</a>
            <?php endif; ?>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
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



<!-- carousel/slider -->
<div id="carouselauto" class="carousel slide" style="padding-top: 100px;" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $folder = '../resource/'; // Folder that contains the images
        $files = scandir($folder); // Get all files in the folder
        $first = true; // Flag for marking the first image as active

        foreach ($files as $file) {
            // Only include image files (jpg, jpeg, png, gif)
            if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                echo '<div class="carousel-item ' . ($first ? 'active' : '') . '">';
                echo '<img src="' . $folder . $file . '" class="d-block w-100" alt="Image">';
                echo '</div>';
                $first = false; // Set to false after the first image
            }
        }
        ?>

        <!-- Hero Section -->

        
<!-- End of Hero Section -->
 </div>


    <!-- Previous and Next Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselauto" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselauto" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!-- end carousel -->




<!-- footer -->
<footer>
  <div class="footer-content">
    <h3>NofuAuto</h3>
    <p>lorem ipsum sing dolor sit amet
    </p>
    <ul class="socials">
      <li><a href=""><i class="fa fa-facebook"></i></a></li>
      <li><a href=""><i class="fa fa-twitter"></i></a></li>
      <li><a href=""><i class="fa fa-instagram"></i></a></li>
      <li><a href=""><i class="fa fa-github"></i></a></li>
    </ul>
  </div>

  <div class="footer-bottom">
    <p>copyright &copy;2024 nofuruu. designed by <span>Naufal Fatihul Ihsan</span></p>
  </div>
 </footer>

<!-- end footer -->
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>