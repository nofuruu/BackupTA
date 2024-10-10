<?php
  include 'koneksi.php';
  session_start();

  // Check if the session 'id_user' is set
  if (!isset($_SESSION['id_user'])) {
    // Redirect to login if the user is not logged in
    header("Location: login.php");
    exit();
  }

  $id_user = $_SESSION['id_user'];

  // Query for user information
  $query = "SELECT profilepict, username, email, tanggal_bergabung FROM user WHERE id_user = ?";
  $stmt = $koneksi->prepare($query); // Prepare the SQL statement
  $stmt->bind_param("i", $id_user); // Bind the parameter to prevent SQL injection
  $stmt->execute(); // Execute the query
  $result = $stmt->get_result(); // Get the result

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $profilePhoto = $user['profilepict'] ? $user['profilepict'] : 'default.png';
  } else {
    // Handle case where the user is not found
    echo "User not found.";
    exit();
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="profile.css">
  <style>
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    
  </div>
</nav>

<div class="container">
  <h2>My Profile</h2>
  <div class="profile-card">
  <div class="profile-images">
    <!-- Tampilkan foto profil -->
    <img src="uploads/<?php echo $profilePhoto; ?>?t=<?php echo time(); ?>" alt="Profile Photo" style="width: 100px; height: 100px; border-radius: 50%;">
    </div>
    <!-- Tampilkan informasi data diri -->
    <div class="profile-info mt-3">
      <h4>Username: <?php echo $user['username']; ?></h4>
      <p>Email: <?php echo $user['email']; ?></p>
      <p>Bergabung sejak: <?php echo $user['tanggal_bergabung']; ?></p>
    </div>

    <!-- Tombol Edit -->
    <div class="edit-button mt-3">
      <a href="profile_edit.php" class="btn btn-primary">Edit</a>
    </div>
    <a href="home.php" type="button" class="btn btn-success mt-3">Home</a>

  </div>
</div>

<footer>
  <div class="footer-content">
    <h3>NofuCarshop</h3>
    <p>lorem ipsum niat ingsun ngising ing tegalgondo tuhan kirimkanlah aku kekasih yang baik hati yang mencintai aku apa adanya
      mawar ini semakin layu
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

</body>
</html>
