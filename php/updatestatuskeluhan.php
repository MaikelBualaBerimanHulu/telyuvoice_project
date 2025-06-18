<?php
session_start(); // Memulai sesi

require_once "koneksi.php"; // Memastikan file koneksi database tersedia

// --- Proteksi Akses ---
// Pastikan user sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.html"); // Alihkan ke halaman login
    exit();
}

// Pastikan user adalah operator
$user_role = $_SESSION['role'] ?? 'mahasiswa';
if ($user_role !== 'operator') {
    $_SESSION['status_message'] = "Anda tidak memiliki izin untuk melakukan aksi ini.";
    $_SESSION['status_type'] = "error";
    header("Location: ../dasboard.php"); // Alihkan kembali ke dashboard
    exit();
}

// --- Proses Update Status Keluhan (Jika Form Disubmit) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_id = $_POST['complaint_id'] ?? null;
    $new_status = $_POST['new_status'] ?? null;

    // Validasi input
    if (!$complaint_id || !is_numeric($complaint_id) || empty($new_status)) {
        $_SESSION['status_message'] = "Data tidak lengkap atau tidak valid untuk update status.";
        $_SESSION['status_type'] = "error";
        header("Location: ../dasboard.php");
        exit();
    }

    // Pastikan status baru adalah salah satu dari yang diizinkan
    $allowed_statuses = ['Pending', 'Diproses', 'Selesai', 'Ditolak'];
    if (!in_array($new_status, $allowed_statuses)) {
        $_SESSION['status_message'] = "Status yang dipilih tidak valid.";
        $_SESSION['status_type'] = "error";
        header("Location: ../dasboard.php");
        exit();
    }

    // Query UPDATE status keluhan
    // PENTING: Gunakan mysqli_real_escape_string untuk semua variabel!
    $sql_update_status = "UPDATE keluhan SET status = '" . mysqli_real_escape_string($conn, $new_status) . "' 
                          WHERE id = '" . mysqli_real_escape_string($conn, $complaint_id) . "'";

    if (mysqli_query($conn, $sql_update_status)) {
        // Cek apakah ada baris yang terpengaruh (berhasil diupdate)
        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['status_message'] = "Status keluhan ID " . $complaint_id . " berhasil diperbarui menjadi " . htmlspecialchars($new_status) . ".";
            $_SESSION['status_type'] = "success";
        } else {
            $_SESSION['status_message'] = "Status keluhan ID " . $complaint_id . " tidak berubah atau keluhan tidak ditemukan.";
            $_SESSION['status_type'] = "warning";
        }
    } else {
        $_SESSION['status_message'] = "Gagal memperbarui status keluhan: " . mysqli_error($conn);
        $_SESSION['status_type'] = "error";
    }
    
    mysqli_close($conn); // Tutup koneksi database
    header("Location: ../dasboard.php"); // Kembali ke dashboard setelah proses
    exit();
} else {
    // Jika diakses langsung tanpa POST request
    header("Location: ../dasboard.php");
    exit();
}
?>
