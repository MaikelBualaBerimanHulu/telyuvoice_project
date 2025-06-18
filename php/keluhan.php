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
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori'] ?? '');
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi'] ?? '');
    $status_keluhan = 'Pending';

    $query_user_data = "SELECT username, fakultas FROM users WHERE id = '" . mysqli_real_escape_string($conn, $user_id) . "'";
    $result_user = mysqli_query($conn, $query_user_data);

    $username = NULL;
    $fakultas = NULL;

    if ($result_user) {
        if (mysqli_num_rows($result_user) > 0) {
            $user_data = mysqli_fetch_assoc($result_user);
            $username = $user_data['username'];
            $fakultas = $user_data['fakultas'];

        } else {
            error_log("ERROR: Data pengguna tidak ditemukan untuk ID pengguna: " . $user_id);
            header("Location: ../keluhan.html");
            exit();
        }
    } else {
        error_log("ERROR: Gagal query data pengguna: " . mysqli_error($conn));
        header("Location: ../keluhan.html");
        exit();
    }

    $sql_insert_keluhan = "INSERT INTO keluhan (user_id, username, fakultas, kategori, deskripsi, status)
                           VALUES ('" . mysqli_real_escape_string($conn, $user_id) . "', 
                                   '" . mysqli_real_escape_string($conn, $username) . "', 
                                   '" . mysqli_real_escape_string($conn, $fakultas) . "', 
                                   '" . mysqli_real_escape_string($conn, $kategori) . "', 
                                   '" . mysqli_real_escape_string($conn, $deskripsi) . "',
                                   '" . mysqli_real_escape_string($conn, $status_keluhan) . "')";
    
    if (mysqli_query($conn, $sql_insert_keluhan)) {

        $_SESSION['last_kategori_keluhan'] = $kategori;

        header("refresh:3;url=keluhansayaa.php");
        echo "Terima kasih atas laporan keluhan Anda. Operator akan mengkonfirmasi keluhan Anda.";
        exit();
    } else {
        error_log("ERROR: Gagal eksekusi INSERT keluhan: " . mysqli_error($conn));
        header("Location: ../keluhan.html");
        exit();
    }
    
    mysqli_close($conn);
} else {
    header("Location: ../keluhan.html");
    exit();
}
?>
