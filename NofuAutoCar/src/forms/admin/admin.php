<?php
include '../../../koneksi.php';

$folder = '../../../public/resource/items/'; // Folder tempat menyimpan gambar

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
    <link rel="stylesheet" href="../../../public/css/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>


<div class="sidebar">
    <div class="navbar-brand">
        <img src="../../../public/resource/logoA.png" alt="logo" id="dslogo">
    </div>
    <ul>
        <li><a href="#" onclick="showContent('website')" id="link-website"><i class="fas fa-globe"></i> Website</a></li>
        <li><a href="#" onclick="showContent('user')" id="link-user"><i class="fas fa-user"></i> User</a></li>
        <li><a href="#" onclick="showContent('module')" id="link-module"><i class="fas fa-cart-plus"></i> Post Items</a></li>
        <li><a href="#" onclick="showContent('role')" id="link-role"><i class="fas fa-briefcase"></i> Manage Items</a></li>
        <li><a href="#" onclick="showContent('payments')" id="link-payments"><i class="fas fa-money-bill"></i> Payments</a></li>
        <li><a href="../../../home.php" id="link-website-go"><i class="fas fa-globe"></i> Goes To Website<i class="bi bi-caret-right-fill"></i></a></li>
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
                            $files = '../../../public/resource/carousels/';
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
    include '../../../koneksi.php'; // Include your database connection

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
            echo '<button type="submit" name="delete_user" class="btn btn-danger btn-sm">Banned</button>';
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

<?php
include '../../../koneksi.php';

$message = ''; // Initialize message variable

// Check if a message is passed in the URL
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
?>


<body>
<div id="module" class="content-section">
    <h1>Post Items</h1>
    <p>This Is Where you can Post the Vehicles</p>

    <!-- Display the message if it exists -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-info">
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form id="vehicleForm" method="POST" enctype="multipart/form-data" action="upload.php">
        <div class="form-group">
            <label for="nm_kendaraan">Nama Kendaraan:</label>
            <input type="text" id="nm_kendaraan" name="nm_kendaraan" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="jenis_kendaraan">Jenis Kendaraan:</label>
            <select id="jenis_kendaraan" name="jenis_kendaraan" class="form-control" required>
                <option value="motor">Motor</option>
                <option value="mobil">Mobil</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tahun">Tahun:</label>
            <input type="number" id="tahun" name="tahun" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="warna">Warna:</label>
            <input type="text" id="warna" name="warna" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" class="form-control" required>
                <option value="Tersedia">Tersedia</option>
                <option value="Terjual">Terjual</option>
            </select>
        </div>

        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="harga" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="foto">Foto Kendaraan:</label>
            <input type="file" id="foto" name="foto" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Post Vehicle</button>
    </form>
</div>





<div id="role" class="content-section" style="display:none;">
    <h1>Role Management</h1>
    <p>Assign and manage roles here.</p>

    <!-- Display the message if it exists -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-info">
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <h2 class="mt-5">Manage Vehicles</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kendaraan</th>
                <th>Jenis</th>
                <th>Tahun</th>
                <th>Warna</th>
                <th>Status</th>
                <th>Harga</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query to fetch vehicle data including the image
            $query = "SELECT id_kendaraan, nm_kendaraan, jenis_kendaraan, tahun, warna, status, harga, foto FROM kendaraan";
            $result = $koneksi->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row['id_kendaraan'] . '</td>
                            <td>' . htmlspecialchars($row['nm_kendaraan']) . '</td>
                            <td>' . htmlspecialchars($row['jenis_kendaraan']) . '</td>
                            <td>' . htmlspecialchars($row['tahun']) . '</td>
                            <td>' . htmlspecialchars($row['warna']) . '</td>
                            <td>' . htmlspecialchars($row['status']) . '</td>
                            <td>Rp ' . number_format($row['harga'], 0, ',', '.') . '</td>
                            <td><img src="data:image/jpeg;base64,' . base64_encode($row['foto']) . '" style="height: 100px; object-fit: cover;" alt="Foto Kendaraan"></td>
                            <td>
                                <form method="POST" action="delete.php" style="display:inline;">
                                    <input type="hidden" name="id_kendaraan" value="' . $row['id_kendaraan'] . '">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i></button>
                                </form>
                                <button class="btn btn-warning btn-sm" onclick="openEditModal(' . $row['id_kendaraan'] . ', \'' . htmlspecialchars($row['nm_kendaraan']) . '\', \'' . htmlspecialchars($row['jenis_kendaraan']) . '\', ' . $row['tahun'] . ', \'' . htmlspecialchars($row['warna']) . '\', \'' . htmlspecialchars($row['status']) . '\', ' . $row['harga'] . ', \'' . base64_encode($row['foto']) . '\')"><i class="bi bi-pencil-square"></i></button>
                            </td>
                          </tr>';
                }
            } else {
                echo '<tr><td colspan="9" class="text-center">Tidak ada kendaraan yang tersedia saat ini.</td></tr>';
            }
            ?>
        </tbody>
    </table>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Kendaraan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="vehicleEditForm" method="POST" action="edit.php" enctype="multipart/form-data">
                        <input type="hidden" name="id_kendaraan" id="edit_id_kendaraan">
                        <div class="form-group">
                            <label for="edit_nm_kendaraan">Nama Kendaraan:</label>
                            <input type="text" id="edit_nm_kendaraan" name="nm_kendaraan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_jenis_kendaraan">Jenis Kendaraan:</label>
                            <select id="edit_jenis_kendaraan" name="jenis_kendaraan" class="form-control" required>
                                <option value="motor">Motor</option>
                                <option value="mobil">Mobil</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_tahun">Tahun:</label>
                            <input type="number" id="edit_tahun" name="tahun" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_warna">Warna:</label>
                            <input type="text" id="edit_warna" name="warna" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status:</label>
                            <select id="edit_status" name="status" class="form-control" required>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Terjual">Terjual</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_harga">Harga:</label>
                            <input type="number" id="edit_harga" name="harga" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_foto">Foto Kendaraan:</label>
                            <input type="file" id="edit_foto" name="foto" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Vehicle</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditModal(id, nm, jenis, tahun, warna, status, harga, foto) {
        document.getElementById('edit_id_kendaraan').value = id;
        document.getElementById('edit_nm_kendaraan').value = nm;
        document.getElementById('edit_jenis_kendaraan').value = jenis;
        document.getElementById('edit_tahun').value = tahun;
        document.getElementById('edit_warna').value = warna;
        document.getElementById('edit_status').value = status;
        document.getElementById('edit_harga').value = harga;
        // Show the modal
        var modal = new bootstrap.Modal(document.getElementById('editModal'));
        modal.show();
    }
</script>





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
