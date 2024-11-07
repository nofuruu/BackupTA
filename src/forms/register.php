<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
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
    </style>
</head>
<body>
    
<div class="container">
    <div class="login-card">
        <div class="navbar-brand">
            <img src="../../public/resource/logoB.png" alt="logo" id="dslogo">
            
            <form action="../function/proses-register.php" method="POST">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="username" required>
                    <label for="username">Enter username</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <label for="password">Password Minimum 8 characters</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="verpass" name="verpass" required>
                    <label for="verpass">Re-Confirm Password</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" required>
                    <label for="email">Enter your Email Address</label>
                </div>

                <button type="submit" class="btn btn-submit" id="btn-submit">Register</button>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // SweetAlert2 for handling errors and success messages
    const urlParams = new URLSearchParams(window.location.search);

    // Registration success modal
    if (urlParams.has('register') && urlParams.get('register') === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Registrasi Berhasil',
            text: 'Anda berhasil registrasi! Anda akan diarahkan ke halaman login.',
            showConfirmButton: false,
            timer: 3000,
            willClose: () => {
                window.location.href = '../forms/login.php'; // Redirect to login page
            }
        });
    }

    // Username or email already exists modal
    if (urlParams.has('error') && urlParams.get('error') === 'exists') {
        Swal.fire({
            icon: 'error',
            title: 'Username atau Email Sudah Terdaftar',
            text: 'Silakan coba dengan username atau email yang berbeda.',
            confirmButtonText: 'Coba Lagi'
        });
    }

    // Password mismatch modal
    if (urlParams.has('error') && urlParams.get('error') === 'password_mismatch') {
        Swal.fire({
            icon: 'error',
            title: 'Password Tidak Cocok',
            text: 'Password dan verifikasi password harus sama.',
            confirmButtonText: 'Coba Lagi'
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-tgfEvpn7j0s7ySmmdJ+uCxpsLGxWPUQpgxEjwG1rVRYtzhZPgiJTQE5A5LnbOLB/" crossorigin="anonymous"></script>

</body>
</html>
