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
    $_SESSION['keluhan_message'] = "ID keluhan tidak valid untuk diedit.";
    $_SESSION['keluhan_status'] = "error";
    header("Location: ../keluhansaya.php");
    exit();
}

$sql_fetch_keluhan = "SELECT kategori, deskripsi
                      FROM keluhan
                      WHERE id = '" . mysqli_real_escape_string($conn, $keluhan_id) . "'
                      AND user_id = '" . mysqli_real_escape_string($conn, $user_id) . "'";
$result_fetch_keluhan = mysqli_query($conn, $sql_fetch_keluhan);

if (!$result_fetch_keluhan || mysqli_num_rows($result_fetch_keluhan) == 0) {
    $_SESSION['keluhan_message'] = "Keluhan tidak ditemukan atau Anda tidak memiliki izin untuk mengeditnya.";
    $_SESSION['keluhan_status'] = "error";
    header("Location: ../keluhansayaa.php");
    exit();
}

$data_keluhan = mysqli_fetch_assoc($result_fetch_keluhan);
$current_kategori = $data_keluhan['kategori'];
$current_deskripsi = $data_keluhan['deskripsi'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_kategori = mysqli_real_escape_string($conn, $_POST['kategori'] ?? '');
    $new_deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi'] ?? '');

    $sql_update_complaint = "UPDATE keluhan SET 
                             kategori = '" . $new_kategori . "', 
                             deskripsi = '" . $new_deskripsi . "' 
                             WHERE id = '" . mysqli_real_escape_string($conn, $keluhan_id) . "' AND user_id = '" . mysqli_real_escape_string($conn, $user_id) . "'";

    if (mysqli_query($conn, $sql_update_complaint)) {
        $_SESSION['keluhan_message'] = "Keluhan berhasil diperbarui.";
        $_SESSION['keluhan_status'] = "success";
        header("Location: keluhansayaa.php");
        exit();
    } else {
        $_SESSION['keluhan_message'] = "Gagal memperbarui keluhan: " . mysqli_error($conn);
        $_SESSION['keluhan_status'] = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Keluhan</title>
    <link rel="stylesheet" href="../css/prosesedit.css">
</head>
<body>
    <div class="container">
        <h1>Edit Keluhan Anda</h1>
        
        <?php 
        if (isset($_SESSION['keluhan_message'])): ?>
            <div class="message-box <?php echo htmlspecialchars($_SESSION['keluhan_status']); ?>">
                <p><?php echo htmlspecialchars($_SESSION['keluhan_message']) ?></p>
            </div>
            <?php
            unset($_SESSION['keluhan_message']);
            unset($_SESSION['keluhan_status']);
        endif;
        ?>

        <form action="prosesedit.php?id=<?php echo htmlspecialchars($keluhan_id); ?>" method="post">
            <div class="form-group">
                <label for="kategori">Kategori Keluhan</label>
                <select name="kategori" id="kategori" required>
                    <option value="administrasi" <?php echo ($current_kategori == 'administrasi') ? 'selected' : ''; ?>>Administrasi</option>
                    <option value="fasilitas" <?php echo ($current_kategori == 'fasilitas') ? 'selected' : ''; ?>>Fasilitas</option>
                    <option value="lingkungan" <?php echo ($current_kategori == 'lingkungan') ? 'selected' : ''; ?>>Lingkungan</option>
                    <option value="pelecehan" <?php echo ($current_kategori == 'pelecehan') ? 'selected' : ''; ?>>Pelecehan</option>
                    <option value="lain-lain" <?php echo ($current_kategori == 'lain-lain') ? 'selected' : ''; ?>>Lain-lain</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="deskripsi">Deskripsikan Keluhan</label>
                <textarea name="deskripsi" id="deskripsi" placeholder="Tulis keluhan Anda di sini..." required><?php echo htmlspecialchars($current_deskripsi); ?></textarea>
            </div>
            
            <button type="submit" name="submit">Simpan Perubahan</button>
            <a href="keluhansayaa.php" class="btn-cancel">Batal</a>
        </form>
    </div>
</body>
</html>
<?php
mysqli_close($conn); 
?>
