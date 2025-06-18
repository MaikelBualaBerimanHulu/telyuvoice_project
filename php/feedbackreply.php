<?php
session_start(); 

require_once "koneksi.php"; 

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    $_SESSION['status_message'] = "Anda harus login untuk membalas feedback.";
    $_SESSION['status_type'] = "error";
    header("Location: ../login.html");
    exit();
}


$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['role'] ?? null;
$username = $_SESSION['username'] ?? null;

if (!$user_id || !$user_role || !$username) {
    $_SESSION['status_message'] = "Sesi tidak lengkap. Silakan login kembali.";
    $_SESSION['status_type'] = "error";
    header("Location: ../login.html");
    exit();
}


if ($user_role !== 'operator') {
    $_SESSION['status_message'] = "Anda tidak memiliki izin untuk membalas feedback (hanya operator).";
    $_SESSION['status_type'] = "error";
    header("Location: ../dasboard.php"); 
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback_id = $_POST['feedback_id'] ?? null;
    $reply_text = $_POST['reply_text'] ?? '';

    
    if (!$feedback_id || !is_numeric($feedback_id) || empty($reply_text)) {
        $_SESSION['status_message'] = "ID Feedback atau teks balasan tidak valid.";
        $_SESSION['status_type'] = "error";
        header("Location: ../dasboard.php"); 
        exit();
    }

    
    $stmt = $conn->prepare("INSERT INTO feedback_replies (feedback_id, user_id, username_replier, role_replier, reply_text) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $feedback_id, $user_id, $username, $user_role, $reply_text);

    if ($stmt->execute()) {
        $_SESSION['status_message'] = "Balasan Anda berhasil dikirim.";
        $_SESSION['status_type'] = "success";
    } else {
        $_SESSION['status_message'] = "Gagal mengirim balasan: " . $stmt->error;
        $_SESSION['status_type'] = "error";
    }

    $stmt->close(); 
    $conn->close(); 
    header("Location: ../dasboard.php"); 
    exit();

} else {
    // If accessed directly without POST request
    header("Location: ../dasboard.php"); 
    exit();
}
?>