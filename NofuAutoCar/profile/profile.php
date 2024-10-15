<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="profile.css">
</head>
<body>

<?php
include '../connection/koneksi.php';

session_start();
$id_user = $_SESSION['id_user'];

// Query untuk mendapatkan data pengguna
$query = "SELECT username, email, tanggal_bergabung, profilepict FROM users WHERE id_user = '$id_user'";
$result = mysqli_query($koneksi, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $username = $user['username'];
    $email = $user['email'];
    $tanggal_bergabung = $user['tanggal_bergabung'];
    
    // Periksa apakah pengguna sudah memiliki foto profil, jika tidak, gunakan default.png
    $profilepict = !empty($user['profilepict']) ? "../uploads/" . $user['profilepict'] : "../uploads/default.png";
} else {
    // Jika tidak ada hasil dari query atau pengguna belum memiliki foto profil
    $profilepict = "../uploads/default.png";
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">NofuAuto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../home/home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="profile.php">My Profile</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center text-danger">My Profile</h2>
    <div class="profile-card">
    <div class="profile-images">
    <img src="<?php echo htmlspecialchars($profilepict); ?>?t=<?php echo time(); ?>" alt="pfp" class="img-fluid profile-image">
</div>
        <div class="profile-info mt-3">
            <h4 class="text-light">Username: <?php echo $username; ?></h4>
            <p class="text-secondary">Email: <?php echo $email; ?></p>
            <p class="text-secondary">Bergabung sejak: <?php echo $tanggal_bergabung; ?></p>
        </div>
        <div class="action-buttons mt-4">
            <a href="profile-edit.php" class="btn btn-danger">Edit Profile</a>
            <a href="../home/home.php" class="btn btn-success">Home</a>
        </div>
    </div>
</div>

<!-- footer -->
<footer>
  <div class="footer-content">
    <h3>NofuAuto</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    <ul class="socials">
      <li><a href="#"><i class="fa fa-facebook"></i></a></li>
      <li><a href="#"><i class="fa fa-twitter"></i></a></li>
      <li><a href="#"><i class="fa fa-instagram"></i></a></li>
      <li><a href="#"><i class="fa fa-github"></i></a></li>
    </ul>
  </div>
  <div class="footer-bottom">
    <p>copyright &copy;2024 NofuAuto. Designed by <span>Naufal Fatihul Ihsan</span></p>
  </div>
 </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
