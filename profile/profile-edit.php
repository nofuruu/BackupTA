<?php
  session_start();
  $username = $_SESSION['username'];
  $id_user = $_SESSION['id_user'];
  include 'koneksi.php';

  // Jika form di-submit
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Jika ada upload foto profil
    if (isset($_FILES['profilepict'])) {
      $fileName = $_FILES['profilepict']['name'];
      $fileTmp = $_FILES['profilepict']['tmp_name'];
      $uploadDir = 'uploads/';
      
      $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
      
      if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
        if (move_uploaded_file($fileTmp, $uploadDir . $fileName)) {
          $query = "UPDATE user SET profilepict = '$fileName' WHERE id_user = $id_user";
          $koneksi->query($query);
        } else {
          echo "Gagal mengunggah gambar.";
        }
      } else {
        echo "Format file tidak didukung.";
      }
    }

    // Update data diri (nama, email)
    $username = $_POST['username'];
    $email = $_POST['email'];

    $query = "UPDATE user SET username = '$username', email = '$email' WHERE id_user = $id_user";
    if ($koneksi->query($query)) {
      echo "Data berhasil diupdate!";
      header('Location: profile_edit.php');
    } else {
      echo "Gagal mengupdate data.";
    }
  }

  // Query untuk mendapatkan informasi pengguna
  $query = "SELECT profilepict, username, email, tanggal_bergabung FROM user WHERE id_user = $id_user";
  $result = $koneksi->query($query);
  $user = $result->fetch_assoc();
  $profilePhoto = $user['profilepict'] ? $user['profilepict'] : 'default.png';
?>


<!DOCTYPE html>
<html lang="en">
  
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="profile.css">
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <!-- Navbar content -->
  </div>
</nav>

<div class="container">
  <h2>Edit Profile</h2>
  <div class="profile-card">

  <div class="profile-images">
    <!-- Tampilkan foto profil saat ini -->
    <img src="uploads/<?php echo $profilePhoto; ?>?t=<?php echo time(); ?>" alt="Profile Photo" style="width: 100px; height: 100px; border-radius: 50%;">
    </div>
    
    <div class="profile-edit">
    <!-- Form untuk mengganti foto profil -->
    <form action="profile_edit.php" method="POST" enctype="multipart/form-data">
      <input type="file" name="profilepict" id="profilepict" accept="image/*">
      </div>

      <!-- Form untuk mengedit data diri -->
      <div class="form-group">
        <label for="nama">Nama:</label>
        <input type="text" name="username" id="nama" class="form-control" value="<?php echo $user['username']; ?>">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>">
      </div>
      <button type="submit" class="btn btn-primary mt-3">Update Profile</button><br>
      <a href="home.php" type="button" class="btn btn-success mt-3">Home</a>

    </form>
  </div>
</div>

<footer>
  
</footer>

</body>
</html>
