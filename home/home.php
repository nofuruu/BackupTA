<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="home.css">
  <title>Document</title>
</head>
<body>

<?php
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
        <li class="nav-item mg-2">
          <a class="nav-link" href="#">myprofiles</a>
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
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
      </ul>
      <div class="d-flex ms-auto"> <!-- Flex container for buttons -->
        <a href="#" class="btn btn-login">Login</a>
        <a href="#" class="btn btn-register ms-2">Register</a> <!-- Added ms-2 for spacing -->
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

<!-- end footer -->
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>