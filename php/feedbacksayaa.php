<?php
session_start(); 

// Memastikan file koneksi database tersedia
require_once "koneksi.php"; // Sesuaikan path ini jika berbeda

// --- Proteksi Login ---
// Halaman ini hanya untuk pengguna yang sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.html"); // Alihkan ke halaman login jika belum login
    exit();
}

// Memastikan 'user_id' dan 'role' dari sesi tersedia (karena user sudah login)
$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['role'] ?? 'mahasiswa';
$username = htmlspecialchars($_SESSION['username'] ?? 'Pengguna');

// Query untuk mengambil semua feedback dari tabel 'feeback'
$sql_all_feedback = "SELECT id, nama, fakultas, prodi, feedback FROM feeback ORDER BY id DESC";
$result_all_feedback = mysqli_query($conn, $sql_all_feedback);

// Memeriksa jika query feedback gagal
if (!$result_all_feedback) {
    echo "Tidak dapat mengambil data feedback. Silakan coba lagi nanti.>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Feedback</title>
    <link rel="stylesheet" href="../css/feedbacksayaa.css"> <!-- Menggunakan style.css umum -->
</head>
<body>
    <div class="feedback-container-wrapper">
        <h1 class="feedback-list-header">Semua Feedback Mahasiswa</h1>

        <?php if (mysqli_num_rows($result_all_feedback) > 0): ?>
            <?php while ($feedback_row = mysqli_fetch_assoc($result_all_feedback)): ?>
                <div class="feedback-item">
                    <div class="feedback-header">
                        <div class="info">
                            <?php echo htmlspecialchars($feedback_row['nama']); ?> (<?php echo htmlspecialchars($feedback_row['fakultas']); ?> - <?php echo htmlspecialchars($feedback_row['prodi']); ?>)
                        </div>
                        <small>ID: #<?php echo htmlspecialchars($feedback_row['id']); ?></small>
                    </div>
                    <div class="feedback-body">
                        <?php echo nl2br(htmlspecialchars($feedback_row['feedback'])); ?>
                    </div>

                    <!-- Bagian Balasan (Replies) -->
                    <div class="feedback-replies-section">
                        <h4>Balasan:</h4>
                        <?php
                        // Query untuk mengambil balasan terkait feedback ini
                        $sql_replies = "SELECT username_replier, role_replier, reply_text, created_at 
                                        FROM feedback_replies 
                                        WHERE feedback_id = '" . mysqli_real_escape_string($conn, $feedback_row['id']) . "' 
                                        ORDER BY created_at ASC";
                        $result_replies = mysqli_query($conn, $sql_replies);

                        if ($result_replies && mysqli_num_rows($result_replies) > 0) {
                            while ($reply_row = mysqli_fetch_assoc($result_replies)) {
                                $role_class = ($reply_row['role_replier'] === 'operator') ? 'role-operator' : 'role-mahasiswa';
                                echo "<div class='reply-item'>";
                                echo "<div class='reply-header'>";
                                echo htmlspecialchars($reply_row['username_replier']) . " (<span class='" . $role_class . "'>" . htmlspecialchars(ucfirst($reply_row['role_replier'])) . "</span>)";
                                echo " <small> - " . htmlspecialchars($reply_row['created_at']) . "</small>";
                                echo "</div>";
                                echo "<div class='reply-text'>" . nl2br(htmlspecialchars($reply_row['reply_text'])) . "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "<span class='no-replies'>Belum ada balasan untuk feedback ini.</span>";
                        }
                        ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-feedback-message">Tidak ada feedback saat ini.</p>
        <?php endif; ?>

        <a href="../dasboard.php" class="btn-back">Kembali ke Dashboard</a>
    </div>
</body>
</html>
<?php
mysqli_close($conn); // Tutup koneksi database
?>