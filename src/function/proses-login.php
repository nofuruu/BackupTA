<?php
session_start();
include '../../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    
    $query = "SELECT * FROM users WHERE (username = '$username' OR email = '$username') LIMIT 1";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Debug: Print retrieved hashed password
        echo "Hashed password from database: " . $user['password'] . "<br>";

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            // Debug: Password is correct
            echo "Password verification successful!";
            
            // Generate a unique session ID to allow multiple sessions
            session_regenerate_id(true); // Regenerate session ID to prevent session fixation
            
            // Store user info in the session
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect based on the user's role
            if ($user['role'] === 'superadmin') {
                header("Location: ../forms/admin/admin.php");
            } elseif ($user['role'] === 'admin') {
                header("Location: ../forms/admin/admin.php");
            } else {
                header("Location: ../../home.php");
            }
            exit; // Prevent further execution
        } else {
            // Debug: Password verification failed
            echo "Password verification failed!";
            header("Location: ../forms/login.php?error=1");
            exit; // Prevent further execution
        }
    } else {
        echo "User not found!";
        header("Location: ../forms/login.php?error=1");
        exit; // Prevent further execution
    }
}
?>
