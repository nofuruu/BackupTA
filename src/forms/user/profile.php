<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../../public/css/profile.css">
</head>
<body>

<?php
include '../../../koneksi.php';

session_start();

// mengecek apakah user sudah login apa belum
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
  // Jika belum login, tampilkan notifikasi dan arahkan ke halaman login setelah beberapa detik
  echo ' <div class="alert alert-warning text-center mx-auto" style="max-width: 400px;"> <!-- Atur max-width sesuai kebutuhan -->
        Anda belum login, login terlebih dahulu.
    </div>
</div>';
  
  // Tambahkan JavaScript untuk redirect ke halaman login setelah 3 detik
  echo '<script>
          setTimeout(function() {
              window.location.href = "../login.php";
          }, 3000); // Redirect setelah 3 detik
        </script>';

  // Hentikan eksekusi halaman ini
  exit();
}









$id_user = $_SESSION['id_user'];

// Query to get user data
$query = "SELECT username, email, tanggal_bergabung, profilepict FROM users WHERE id_user = '$id_user'";
$result = mysqli_query($koneksi, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $username = $user['username'];
    $email = $user['email'];
    $tanggal_bergabung = $user['tanggal_bergabung'];
    
    // Check if the user has a profile picture, if not use default.png
    $profilepict = !empty($user['profilepict']) ? "../../../public/uploads/user/" . $user['profilepict'] : "../../../public/uploads/user/default.png";
} else {
    // If no results from query or user has no profile picture
    $profilepict = "../../../public/uploads/user/default.png";
}
?>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img src="../../../public/resource/logoB.png" alt="logo" id="dslogo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
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
            <h4 class="text"><?php echo $username; ?></h4>
            <p class="text-secondary-black">Email: <?php echo $email; ?></p>
            <p class="text-secondary-black">Bergabung sejak: <?php echo $tanggal_bergabung; ?></p>
        </div>
        <div class="action-buttons mt-4">
            <!-- Trigger the modal with this button -->
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
            <a href="../../../home.php" class="btn btn-success">Home</a>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<form action="../../function/profile-update.php" method="POST" enctype="multipart/form-data">

<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../../function/profile-update.php" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
          </div>
          <div class="mb-3">
            <label for="profilepict" class="form-label">Profile Picture</label>
            <input type="file" class="form-control" id="profilepict" name="profilepict">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</form>

<!-- Footer -->
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
