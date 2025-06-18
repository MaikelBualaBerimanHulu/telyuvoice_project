<?php
session_start();

require_once "koneksi.php";

if(!isset($_SESSION['login']) || $_SESSION['login'] !==true) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;

$sql = "SELECT id AS keluhan_id, kategori, deskripsi, status, created_at
        FROM keluhan
        WHERE user_id = '" . mysqli_real_escape_string($conn, $user_id) . "'
        ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keluhan Saya</title>
    <link rel="stylesheet" href="../css/keluhansaya.css">
</head>
<body>
    <div class="container">
        <h1>Keluhan Saya</h1>
        
        <table>
            <thead>
                <tr>
                    <th>ID Keluhan</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)){
                ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['keluhan_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <a href="prosesedit.php?id=<?php echo htmlspecialchars($row['keluhan_id']); ?>" class="action-btn edit-btn">Edit</a>
                                <a href="prosesdelete.php?id=<?php echo htmlspecialchars($row['keluhan_id']); ?>" class="action-btn delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus keluhan ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php 
                    }
                }else {
                ?>
                    <tr>
                        <td colspan='6' class="no-complaints-message">Anda belum mengajukan keluhan apa pun.</td>
                    </tr>
                <?php 
                }
                ?>
            </tbody>
        </table>
        <a href="../dasboard.php" class="btn-back">Kembali ke Dashboard</a>
    </div>
</body>
</html>
 <?php
 mysqli_close($conn);
 ?>