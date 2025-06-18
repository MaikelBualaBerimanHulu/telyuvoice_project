<?php
session_start(); // Memulai sesi

require_once "koneksi.php"; // Memastikan file koneksi database tersedia

// --- Proteksi Akses (Hanya Operator yang Boleh Membalas) ---
// Pastikan user sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    $_SESSION['status_message'] = "Anda harus login untuk membalas feedback.";
    $_SESSION['status_type'] = "error";
    header("Location: ../login.html");
    exit();
}

// Pastikan user_id dan role tersedia di sesi
$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['role'] ?? null;
$username = $_SESSION['username'] ?? null;

if (!$user_id || !$user_role || !$username) {
    $_SESSION['status_message'] = "Sesi tidak lengkap. Silakan login kembali.";
    $_SESSION['status_type'] = "error";
    header("Location: ../login.html");
    exit();
}

// PENTING: Pengecekan ROLE OPERATOR DITAMBAHKAN DI SINI
if ($user_role !== 'operator') {
    $_SESSION['status_message'] = "Anda tidak memiliki izin untuk membalas feedback (hanya operator).";
    $_SESSION['status_type'] = "error";
    header("Location: ../dasboard.php"); // Alihkan kembali ke dashboard
    exit();
}

// --- Proses Pengiriman Balasan (Jika Form Disubmit) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback_id = $_POST['feedback_id'] ?? null;
    $reply_text = $_POST['reply_text'] ?? '';

    // Validasi input
    if (!$feedback_id || !is_numeric($feedback_id) || empty($reply_text)) {
        $_SESSION['status_message'] = "ID Feedback atau teks balasan tidak valid.";
        $_SESSION['status_type'] = "error";
        header("Location: ../dasboard.php"); // Alihkan kembali ke dashboard
        exit();
    }

    // Query INSERT balasan baru ke tabel feedback_replies
    $sql_insert_reply = "INSERT INTO feedback_replies (feedback_id, user_id, username_replier, role_replier, reply_text)
                         VALUES (
                             '" . mysqli_real_escape_string($conn, $feedback_id) . "',
                             '" . mysqli_real_escape_string($conn, $user_id) . "',
                             '" . mysqli_real_escape_string($conn, $username) . "',
                             '" . mysqli_real_escape_string($conn, $user_role) . "',
                             '" . mysqli_real_escape_string($conn, $reply_text) . "'
                         )";

    if (mysqli_query($conn, $sql_insert_reply)) {
        $_SESSION['feedback_status_message'] = "Balasan Anda berhasil dikirim."; // Menggunakan feedback_status_message
        $_SESSION['feedback_status_type'] = "success"; // Menggunakan feedback_status_type
    } else {
        $_SESSION['feedback_status_message'] = "Gagal mengirim balasan: " . mysqli_error($conn); // Menggunakan feedback_status_message
        $_SESSION['feedback_status_type'] = "error"; // Menggunakan feedback_status_type
    }

    mysqli_close($conn); // Tutup koneksi database
    header("Location: ../dasboard.php"); // Kembali ke dashboard
    exit();

} else {
    // Jika diakses langsung tanpa POST request
    header("Location: ../dasboard.php"); // Alihkan kembali ke dashboard
    exit();
}
?>
