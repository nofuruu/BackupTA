<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


  <style>
    /* CSS yang sudah ada */
    #dslogo {
      margin-left: 100px;
    }
    body {
      background: rgb(30,63,87);
      background: linear-gradient(90deg, rgba(30,63,87,1) 10%, rgba(8,33,51,1) 47%, rgba(46,45,45,1) 93%);
    }
    .container {
      margin-top: 150px;
    }
    .login-card {
      max-width: 500px;
      margin: 50px auto;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      background-color: white;
    }
    .btn-submit {
      width: 100%;
      margin-top: 10px;
      margin-bottom: 10px;
      background-color: orange;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      border: none;
      font-weight: bold;
      text-transform: uppercase;
      position: relative;
      overflow: hidden;
      transition: background-color 0.3s, box-shadow 0.3s;
    }
    .btn-submit::after {
      content: '';
      position: absolute;
      top: 100%;
      left: 50%;
      width: 300%;
      height: 300%;
      background: rgba(255, 255, 255, 0.3);
      transition: transform 0.5s ease;
      border-radius: 50%;
      transform: translate(-50%, -50%) scale(0);
    }
    .btn-submit:hover::after {
      transform: translate(-50%, -50%) scale(1);
    }
    .btn-submit:hover {
      background-color: #ff6f61;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }
    input {
      margin: 10px;
      width: 100%;
    }
    form {
      margin-top: 0;
    }
    #logo {
      margin-left: 100px;
    }

    <?php
    session_start();
    session_unset(); // Menghapus semua variabel sesi
    session_destroy(); // Menghancurkan sesi
    ?>
  </style>
</head>
<body>
  <div class="container">
    <div class="login-card">
      <div class="navbar-brand">
        <img src="logo/newlogo.png" alt="logo" id="logo">
      </div>


      <form id="loginForm" method="POST" action="proses_login.php">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username anda" required>
          <label for="username">Username</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password anda" required>
          <label for="password">Password</label>
        </div>
        <button type="submit" class="btn btn-submit" id="btn-submit">Login</button>
        <p class="text-center mt-3">Lupa Password? <a href="proses_register.php" class="link">Pusat Bantuan</a></p>
        <p class="text-center mt-3">Belum memiliki akun? <a href="register.php" class="link">Register</a></p>
        <p class="text-center mt-3"><a href="home/home-user.php" class="link">Lanjutkan tanpa akun</a></p>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
