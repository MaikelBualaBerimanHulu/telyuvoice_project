<?php 
session_start();

require_once "koneksi.php";

$error_message = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, role FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['fakultas'] = $user['fakultas'];
        $_SESSION['prodi'] = $user['prodi'];
        $_SESSION['role'] = $user['role'];
        
        $_SESSION['login'] = true;
        
        header("Location: ../dasboard.php");
        exit();
    }
    else {
        $error_message = "Invalid username of password.";
        header ("Location: ../login.html?error=1");
        exit();
    }
}
?>