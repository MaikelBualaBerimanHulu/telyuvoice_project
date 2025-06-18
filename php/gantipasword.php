<?php
session_start();

require_once "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header ("refresh:3;url=../login.html");
    exit();
}

$message = '';
$status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // 1. Ambil hashed password lama dari database
    $sql_get_password = "SELECT password FROM users WHERE id = '" . mysqli_real_escape_string($conn, $user_id) . "'";
    $result_get_password = mysqli_query($conn, $sql_get_password);

    if (!$result_get_password || mysqli_num_rows($result_get_password) == 0) {
        $message = "Terjadi kesalahan saat mengambil data pengguna.";
        $status = "error";
    } else {
        $user_data = mysqli_fetch_assoc($result_get_password);
        $hashed_password_db = $user_data['password'];

        // 2. Verifikasi password lama
        if (!password_verify($current_password, $hashed_password_db)) {
            $message = "Kata sandi lama salah.";
            $status = "error";
        } 
        // 3. Validasi password baru
        else if (empty($new_password) || empty($confirm_password)) {
            $message = "Kata sandi baru dan konfirmasi tidak boleh kosong.";
            $status = "error";
        }
        else if (strlen($new_password) < 6) { // Contoh: minimal 6 karakter
            $message = "Kata sandi baru minimal 6 karakter.";
            $status = "error";
        }
        else if ($new_password !== $confirm_password) {
            $message = "Kata sandi baru dan konfirmasi tidak cocok.";
            $status = "error";
        } 
        else {
            // 4. Hash password baru
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            // 5. Update password di database
            $sql_update_password = "UPDATE users SET password = '" . mysqli_real_escape_string($conn, $hashed_new_password) . "' WHERE id = '" . mysqli_real_escape_string($conn, $user_id) . "'";
            
            if (mysqli_query($conn, $sql_update_password)) {
                $message = "Kata sandi berhasil diubah.";
                $status = "success";
            } else {
                $message = "Gagal mengubah kata sandi: " . mysqli_error($conn);
                $status = "error";
            }
        }
    }
}
mysqli_close($conn); // Tutup koneksi database
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-red: #e63946;
            --dark-red: #d00000;
            --light-gray: #f5f5f5;
            --medium-gray: #e0e0e0;
            --dark-gray: #333333;
            --text-gray: #555555;
            --white: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-gray);
            color: var(--dark-gray);
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .password-container {
            width: 100%;
            max-width: 450px;
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border-top: 5px solid var(--primary-red);
        }
        
        .password-header {
            padding: 20px;
            text-align: center;
            background-color: var(--white);
            border-bottom: 1px solid var(--medium-gray);
        }
        
        .password-header h1 {
            color: var(--primary-red);
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .password-body {
            padding: 25px;
        }
        
        .message-box {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .message-box.success {
            background-color: rgba(46, 125, 50, 0.1);
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }
        
        .message-box.error {
            background-color: rgba(211, 47, 47, 0.1);
            color: #d32f2f;
            border-left: 4px solid #d32f2f;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-gray);
            font-weight: 500;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--medium-gray);
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-group input:focus {
            border-color: var(--primary-red);
            outline: none;
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.2);
        }
        
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-red);
            color: var(--white);
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-bottom: 15px;
        }
        
        button[type="submit"]:hover {
            background-color: var(--dark-red);
        }
        
        .btn-cancel {
            display: block;
            text-align: center;
            padding: 12px;
            background-color: var(--white);
            color: var(--primary-red);
            border: 1px solid var(--primary-red);
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-cancel:hover {
            background-color: var(--light-gray);
        }
        
        .password-strength {
            margin-top: 5px;
            font-size: 12px;
            color: var(--text-gray);
        }
        
        @media (max-width: 480px) {
            .password-container {
                border-radius: 0;
            }
            
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="password-container">
        <div class="password-header">
            <h1><i class="fas fa-key"></i> Ganti Password</h1>
        </div>
        
        <div class="password-body">
            <?php if (!empty($message)): ?>
                <div class="message-box <?php echo htmlspecialchars($status); ?>">
                    <p><?php echo htmlspecialchars($message); ?></p>
                </div>
            <?php endif; ?>

            <form action="gantipasword.php" method="post">
                <div class="form-group">
                    <label for="current_password"><i class="fas fa-lock"></i> Kata Sandi Lama</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                
                <div class="form-group">
                    <label for="new_password"><i class="fas fa-lock-open"></i> Kata Sandi Baru</label>
                    <input type="password" id="new_password" name="new_password" required>
                    <div class="password-strength">Minimal 6 karakter</div>
                </div>

                <div class="form-group">
                    <label for="confirm_password"><i class="fas fa-check-circle"></i> Konfirmasi Kata Sandi Baru</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" name="submit">
                    <i class="fas fa-save"></i> Ubah Password
                </button>
                <a href="../dasboard.php" class="btn-cancel">
                    <i class="fas fa-times"></i> Kembali ke dasboard
                </a>
            </form>
        </div>
    </div>

    <script>
        // Simple password strength indicator
        document.getElementById('new_password').addEventListener('input', function() {
            const password = this.value;
            const strengthText = document.querySelector('.password-strength');
            
            if (password.length === 0) {
                strengthText.textContent = 'Minimal 6 karakter';
                strengthText.style.color = '#555555';
            } else if (password.length < 6) {
                strengthText.textContent = 'Terlalu pendek';
                strengthText.style.color = '#d32f2f';
            } else if (password.length < 10) {
                strengthText.textContent = 'Sedang';
                strengthText.style.color = '#ff9800';
            } else {
                strengthText.textContent = 'Kuat';
                strengthText.style.color = '#2e7d32';
            }
        });
    </script>
</body>
</html>