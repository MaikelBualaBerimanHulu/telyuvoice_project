<?php
require_once "koneksi.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $fakultas = mysqli_real_escape_string($conn, $_POST['fakultas']);
    $prodi = mysqli_real_escape_string($conn, $_POST['prodi']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checksql = "SELECT * FROM users WHERE username = '$username'";
    $checkresult = mysqli_query($conn, $checksql);

    if (mysqli_num_rows($checkresult) > 0) {
        echo "Username sudah dipakai, silakan gunakan username lain.";
        exit();
    }

    $sql = "INSERT INTO users (nama, fakultas, prodi, username, password) 
    VALUES ('$nama', '$fakultas', '$prodi', '$username', '$password')";

    if(mysqli_query($conn, $sql)) {
        header("Location: ../login.html?register=success");
        echo "Registrasi berhasil! silahkan login.";
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
        header("refresh:3;url=../register.html?register=error");
        echo "Registrasi gagal! silahkan coba lagi.";
        exit();
    }
    
}
?>