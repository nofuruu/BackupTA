<?php
include '../connection/koneksi.php';

$folder = '../resource/'; // Folder tempat menyimpan gambar

// Variabel untuk menyimpan pesan
$message = '';

// Fungsi untuk mengunggah gambar
function uploadImage($folder) {
    global $message;
    if (isset($_POST['upload'])) {
        // Pastikan file diunggah
        if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['new_image']['tmp_name'];
            $fileName = $_FILES['new_image']['name'];
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            
            // Validasi ekstensi file
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($fileExtension, $allowedExtensions)) {
                $destPath = $folder . $fileName;

                // Pindahkan file yang diunggah ke folder tujuan
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $message = "File berhasil diunggah.";
                } else {
                    $message = "Gagal memindahkan file.";
                }
            } else {
                $message = "Ekstensi file tidak diizinkan.";
            }
        } else {
            $message = "Terjadi kesalahan saat mengunggah file.";
        }
    }
}

// Fungsi untuk menghapus gambar
function deleteImage($folder) {
    global $message;
    if (isset($_POST['delete'])) {
        $fileToDelete = $_POST['file_to_delete'];
        $filePath = $folder . $fileToDelete;

        // Hapus file jika ada di folder
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                $message = "File berhasil dihapus.";
            } else {
                $message = "Gagal menghapus file.";
            }
        } else {
            $message = "File tidak ditemukan.";
        }
    }
}

// Panggil fungsi upload jika form unggah di-submit
uploadImage($folder);

// Panggil fungsi delete jika tombol hapus di-submit
deleteImage($folder);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Sidebar with Dynamic Content</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>


    <div class="sidebar">
        <div class="navbar-brand">
            <img src="../assets/logoA.png" alt="logo" id="dslogo">
        </div>
        <ul>
            <li><a href="#" onclick="showContent('website')"><i class="fas fa-globe"></i> Website</a></li>
            <li><a href="#" onclick="showContent('user')"><i class="fas fa-user"></i> User</a></li>
            <li><a href="#" onclick="showContent('module')"><i class="fas fa-cart-plus"></i> Post Items</a></li>
            <li><a href="#" onclick="showContent('role')"><i class="fas fa-briefcase"></i> Manage Items</a></li>
        </ul>
    </div>



    <div class="content">
        <!-- Dynamic Content Area -->

        <div id="website" class="content-section" style="display:none;">
            <h1>Website Content</h1>

            <!-- Tampilkan pesan jika ada -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-info">
                    <?= $message; ?>
                </div>
            <?php endif; ?>

           <!-- Menampilkan carousel web -->
           <div class="container mt-4">
    <div class="row">
        <div class="col-md-6"> <!-- Adjust the column size as needed -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Images</h5>
                    <!-- Menampilkan carousel web -->
                    <div id="carouselAdmin" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $files = scandir($folder);
                            $first = true;

                            foreach ($files as $file) {
                                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                                    echo '<div class="carousel-item ' . ($first ? 'active' : '') . '">';
                                    echo '<img src="' . $folder . $file . '" class="d-block w-100" alt="Image" style="height: 150px; object-fit: cover;">';

                                    // Tombol hapus
                                    echo '<form action="admin.php" method="post" class="mt-2">'; 
                                    echo '<input type="hidden" name="file_to_delete" value="' . $file . '">';
                                    echo '<button type="submit" name="delete" class="btn btn-danger btn-sm">Hapus</button>';
                                    echo '</form>';

                                    echo '</div>';
                                    $first = false;
                                }
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselAdmin" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselAdmin" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>

                    <!-- Form untuk menambahkan gambar -->
                    <form action="admin.php" method="post" enctype="multipart/form-data" class="mt-3">
                        <div class="form-group">
                            <label for="new_image">Tambah Gambar:</label>
                            <input type="file" name="new_image" id="new_image" class="form-control-file">
                        </div>
                        <button type="submit" name="upload" class="btn btn-primary mt-2">Unggah Gambar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- end tambah gambar -->


<!-- fitur lainya -->

<!-- end fitur lainya -->






<div id="user" class="content-section" style="display:none;">
    <h1>User Management</h1>
    <p>This is where you can manage users.</p>

    <?php
    include '../connection/koneksi.php'; // Include your database connection

    // Check if a delete request has been made
    if (isset($_POST['delete_user'])) {
        $idToDelete = $_POST['user_id'];
        // Prepare the delete query
        $deleteQuery = "DELETE FROM users WHERE id_user = ?";
        $stmt = mysqli_prepare($koneksi, $deleteQuery);
        mysqli_stmt_bind_param($stmt, 'i', $idToDelete); // 'i' for integer
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo '<div class="alert alert-success">User deleted successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Failed to delete user or user not found.</div>';
        }

        mysqli_stmt_close($stmt);
    }

    // Fetch all users from the database, excluding the password
    $query = "SELECT id_user, username, email, tanggal_bergabung FROM users";
    $result = mysqli_query($koneksi, $query);

    // Check if the query execution was successful
    if (!$result) {
        die('Query Error: ' . mysqli_error($koneksi)); // Output query error message
    }

    // Check if there are any users
    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Username</th>';
        echo '<th>Email</th>';
        echo '<th>Bergabung Sejak</th>';
        echo '<th>Aksi</th>'; // Added action column for delete button
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Loop through all users and display them
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id_user'] . '</td>';
            echo '<td>' . $row['username'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['tanggal_bergabung'] . '</td>';
            echo '<td>'; // Action column for the delete button
            echo '<form action="" method="post" style="display:inline;">';
            echo '<input type="hidden" name="user_id" value="' . $row['id_user'] . '">';
            echo '<button type="submit" name="delete_user" class="btn btn-danger btn-sm">Hapus</button>';
            echo '</form>';
            echo '</td>'; // Close action column
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No users found.</p>';
    }

    // Close the database connection
    mysqli_close($koneksi);
    ?>
</div>

        
        <div id="module" class="content-section" style="display:none;">
            <h1>Post Items</h1>
            <p>This Is Where you can Post the Vehicles</p>
        </div>
        
        <div id="role" class="content-section" style="display:none;">
            <h1>Role Management</h1>
            <p>Assign and manage roles here.</p>
        </div>
    </div>
    </div>
    <script>
    function showContent(section) {
        // Hide all sections first
        var sections = document.getElementsByClassName('content-section');
        for (var i = 0; i < sections.length; i++) {
            sections[i].style.display = 'none';
        }

        // Show the selected section
        document.getElementById(section).style.display = 'block';
    }
</script>
  
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>
