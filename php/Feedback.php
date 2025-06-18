<?php
session_start();
require_once "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: ../login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = mysqli_real_escape_string($conn, $_POST['message'] ?? '');

    $query_user_data = "SELECT nama, fakultas, prodi FROM users WHERE id = '" . mysqli_real_escape_string($conn, $user_id) . "'";
    $result_user = mysqli_query($conn, $query_user_data);

    $nama = null;
    $fakultas = null;
    $prodi = null;

    if ($result_user && mysqli_num_rows($result_user) > 0) {
        $user_data = mysqli_fetch_assoc($result_user);
        $nama = $user_data['nama'];
        $fakultas = $user_data['fakultas'];
        $prodi = $user_data['prodi'];
    } else {
        error_log("ERROR: Data pengguna tidak ditemukan atau query gagal.");
        header("Location: ../feedback.html");
        exit();
    }

    $sql_insert = "INSERT INTO feeback (nama, fakultas, prodi, feedback)
                   VALUES ('" . mysqli_real_escape_string($conn, $nama) . "',
                           '" . mysqli_real_escape_string($conn, $fakultas) . "',
                           '" . mysqli_real_escape_string($conn, $prodi) . "',
                           '" . $message . "')";

    if (mysqli_query($conn, $sql_insert)) {
        $_SESSION['last_feedback'] = $message;

        header("refresh:3;url=feedbacksayaa.php");
        echo "Terima kasih atas feedback Anda.";
        exit();
    } else {
        error_log("ERROR: Gagal menyimpan feedback: " . mysqli_error($conn));
        header("Location: ../feedback.html");
        exit();
    }

    mysqli_close($conn);
} else {
    header("Location: ../feedback.html");
    exit();
}
?>