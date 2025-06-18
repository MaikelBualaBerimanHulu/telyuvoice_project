<?php
session_start();

require_once "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    $_SESSION['keluhan_message'] = "Sesi tidak valid atau ID pengguna tidak ditemukan, silakan login kembali.";
    $_SESSION['keluhan_status'] = "error";
    header("Location: ../login.html");
    exit();
}

$keluhan_id = $_GET['id'] ?? null;

if (!$keluhan_id || !is_numeric($keluhan_id)) {
    $_SESSION['keluhan_message'] = "ID keluhan tidak valid untuk dihapus.";
    $_SESSION['keluhan_status'] = "error";
    header("Location: keluhansayaa.php");
    exit();
}

$sql_delete_complaint = "DELETE FROM keluhan 
                         WHERE id = '" . mysqli_real_escape_string($conn, $keluhan_id) . "' AND user_id = '" . mysqli_real_escape_string($conn, $user_id) . "'";

if (mysqli_query($conn, $sql_delete_complaint)) {
    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['keluhan_message'] = "Keluhan berhasil dihapus.";
        $_SESSION['keluhan_status'] = "success";
    } else {
        $_SESSION['keluhan_message'] = "Gagal menghapus keluhan: Keluhan tidak ditemukan atau bukan milik Anda.";
        $_SESSION['keluhan_status'] = "error";
    }
} else {
    $_SESSION['keluhan_message'] = "Gagal menghapus keluhan: " . mysqli_error($conn);
    $_SESSION['keluhan_status'] = "error";
}

mysqli_close($conn);
header("Location: keluhansayaa.php");
exit();
?>
