<?php
include '../../koneksi.php';
session_start();

$id_user = $_SESSION['id_user'];

// Mendapatkan data pengguna saat ini
$query = "SELECT profilepict FROM users WHERE id_user = '$id_user'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    // Handle profile picture upload (if provided)
    if (!empty($_FILES['profilepict']['name'])) {
        $profilepict = $_FILES['profilepict']['name'];
        $target_dir = "../../public/uploads/user/";
        $target_file = $target_dir . basename($profilepict);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if it's an actual image
        $check = getimagesize($_FILES['profilepict']['tmp_name']);
        if ($check === false) {
            die("File is not an image.");
        }

        // Check file size (optional, here limited to 2MB)
        if ($_FILES['profilepict']['size'] > 2000000) {
            die("Sorry, your file is too large.");
        }

        // Allow certain file formats (jpg, png, jpeg, gif)
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Hapus foto profil lama jika bukan 'default.png'
        if ($user['profilepict'] !== 'default.png') {
            $old_file = $target_dir . $user['profilepict'];
            if (file_exists($old_file)) {
                unlink($old_file); // Menghapus file lama
            }
        }

        // Move the uploaded file to the target directory
        if (!move_uploaded_file($_FILES['profilepict']['tmp_name'], $target_file)) {
            die("Sorry, there was an error uploading your file.");
        }

        // Update the profile picture in the database
        $update_query = "UPDATE users SET profilepict = '$profilepict' WHERE id_user = '$id_user'";
        mysqli_query($koneksi, $update_query);
    }

    // Update username and email
    $update_query = "UPDATE users SET username = '$username', email = '$email' WHERE id_user = '$id_user'";
    
    if (mysqli_query($koneksi, $update_query)) {
        // Success message and redirect back to profile
        header('Location: ../forms/user/profile.php');
    } else {
        // Error handling
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}
?>
