<?php
session_start();

require_once "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: ../dasboard.php");
    echo "Silahkan login terlebih dahulu";
    exit();
}

$sql_get_profile = "SELECT nama, fakultas, prodi, username, role FROM users WHERE id = '" . mysqli_real_escape_string($conn, $user_id) . "'";
$result_profile = mysqli_query($conn, $sql_get_profile);

if (!$result_profile || mysqli_num_rows($result_profile) == 0) {
    header("Location: ../dasboard.php");
    echo "Data profil tidak ditemukan";
    exit();
}

$user_profile = mysqli_fetch_assoc($result_profile);
mysqli_close($conn); // Tutup koneksi database
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color:rgb(255, 0, 0);
            --secondary-color:rgb(80, 79, 84);
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --success-color: #4cc9f0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: var(--dark-color);
            line-height: 1.6;
            padding: 0;
            margin: 0;
            background-image: url('../asset/univ.jpeg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }
        
        .profile-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            opacity: 0.9;
        }
        
        .profile-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            
        }
        
        h1 {
            color: var(--primary-color);
            margin-bottom: 30px;
            text-align: center;
            font-size: 2.2rem;
            position: relative;
            padding-bottom: 15px;
        }
        
        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 3px;
        }
        
        .profile-info {
            background-color: var(--light-color);
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .profile-info p {
            margin-bottom: 15px;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .profile-info p strong {
            width: 120px;
            color: var(--gray-color);
            font-weight: 500;
        }
        
        .profile-info p i {
            margin-right: 10px;
            color: var(--primary-color);
            width: 20px;
            text-align: center;
        }
        
        .profile-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
            justify-content: center;
        }
        
        .profile-actions a {
            display: inline-flex;
            align-items: center;
            padding: 12px 25px;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .profile-actions a:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .profile-actions a i {
            margin-right: 8px;
        }
        
        .btn-back {
            display: block;
            text-align: center;
            padding: 12px;
            background-color: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
        }
        
        .btn-back:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        @media (max-width: 768px) {
            .profile-container {
                margin: 20px;
                padding: 20px;
            }
            
            h1 {
                font-size: 1.8rem;
            }
            
            .profile-info p {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .profile-info p strong {
                margin-bottom: 5px;
                width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1><i class="fas fa-user-circle"></i> Profil Saya</h1>
        <div class="profile-info">
            <p><strong><i class="fas fa-user"></i> Nama:</strong> <?php echo htmlspecialchars($user_profile['nama']); ?></p>
            <p><strong><i class="fas fa-at"></i> Username:</strong> <?php echo htmlspecialchars($user_profile['username']); ?></p>
            <p><strong><i class="fas fa-university"></i> Fakultas:</strong> <?php echo htmlspecialchars($user_profile['fakultas']); ?></p>
            <p><strong><i class="fas fa-graduation-cap"></i> Prodi:</strong> <?php echo htmlspecialchars($user_profile['prodi']); ?></p>
            <p><strong><i class="fas fa-user-tag"></i> Peran:</strong> <?php echo htmlspecialchars(ucfirst($user_profile['role'])); ?></p>
        </div>

        <div class="profile-actions">
            <!-- Link ke halaman Ubah Password -->
            <a href="gantipasword.php"><i class="fas fa-key"></i> Ubah Password</a>

            <?php if ($user_profile['role'] === 'mahasiswa'): ?>
            <!-- Link ke halaman Keluhan Saya -->
            <a href="keluhansayaa.php"><i class="fas fa-comment-alt"></i> Keluhan Saya</a>
            <?php endif; ?>
        </div>
        <a href="../dasboard.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
    </div>
</body>
</html>