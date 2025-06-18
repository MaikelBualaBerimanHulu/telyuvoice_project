<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['role'] ?? null;
$username = htmlspecialchars($_SESSION['username'] ?? 'Pengguna');

require_once "php/koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dasboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>TelyuVoice</title>
</head>

<body>

    <!-- Navbar -->
    <div class="navbar" id="myNavbar">
        <div class="navbar-left">
            <img src="asset/gambarToa.png" alt="Logo">
            <p class="telyuvoice"><b>TelyuVoice</b></p>
        </div>

        <!-- Cek keluhan saya (mhs) -->
        <?php if ($user_role === 'mahasiswa'): ?>

            <a href="javascript:void(0);" class="menu-icon" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </a>
            <div class="dropdown">
                <a href="#layanan">Layanan</a>
                <div class="dropdown-content">
                    <a href="#layanan">Input Keluhan</a>
                    <a href="#layanan">feedback</a>
                </div>
            </div>
            <a href="#about">Tentang TelyuVoice</a>
            <a href="#kategori">Kategori</a>

            <a href="php/keluhansayaa.php">Keluhan Saya</a>
            <a href="php/feedbacksayaa.php">Feedback Saya</a>
        <?php endif; ?>
        <?php if ($user_role === 'operator'): ?>
            <h1 style="color: red;">Halaman Admin</h1>
        <?php endif; ?>

        <a href="php/profile.php">Profil Saya</a>

        <div class="navbar-right">
            <?php if ($user_id): ?>
                <div class="greeting">👋 Halo, <?php echo $username; ?></div>
                <form action="php/logout.php" method="POST" class="logout-form">
                    <button type="submit" class="logout-btn">Keluar</button>
                    
                </form>
            <?php endif; ?>
        </div>
    </div>

    <?php
    if ($user_role === 'mahasiswa'):
        ?>

        <!-- Halaman 1 -->
        <div class="halaman-1" id="home">
            <h1><span class="red">Telyu</span><span class="grey">Voice</span></h1>
            <p>Ajukan keluhanmu terhadap kampus demi kenyamanan dan kemajuan kampus</p>

            <!-- tombol layanan Kami  -->
            <button class="tombol-layanan" onclick="scrollToSection('layanan')">
                Layanan Kami <i class="fas fa-arrow-down"></i>
            </button>
        </div>

        <!-- halaman ke 2 -->
        <div class="about-telyuvoice" id="about">
            <img src="asset/gambarToa.png" alt="Icon TelyuVoice" class="gambar-telyuvoice">
            <div class="teks-telyuvoice">
                <h1><span class="black">Tentang</span> <span class="Telyu">Telyu</span><span class="Voice">Voice</span></h1>
                <p>
                    TelyuVoice diciptakan untuk mendukung mahasiswa Telkom University dalam mengajukan segala keluhan yang
                    mereka hadapi di dalam kampus, baik itu fasilitas, administrasi, lingkungan, pelecehan seksual, dll.
                    Dengan ini, segala keluhan yang para mahasiswa sampaikan di sini dapat kami tangani demi memberikan
                    kenyamanan serta kemajuan kampus lebih lanjut.
                </p>
            </div>
        </div>

        <!-- Kategori Section -->
        <div class="container" id="kategori">
            <div class="header">Kategori</div>
            <div class="content">
                <div class="box">
                    <img src="asset/fasilitas.jpg" alt="Kategori 1">
                    <div class="Kotak">

                        <!-- Fasilitas -->
                        <div class="text-bar">
                            <button class="fasilitas1">Fasilitas</button>
                            <script>
                                document.querySelector('.fasilitas1').addEventListener('click', function () {
                                    window.location.href = 'fasilitas.html'; // Ganti dengan URL halaman fasilitas Anda
                                });
                            </script>
                        </div>
                    </div>
                </div>


                <!-- administrasi -->
                <div class="box">
                    <img src="asset/administrasi1.png" alt="Kategori 2">
                    <div class="text-bar">
                        <button class="administrasi1">Administrasi</button>
                        <script>
                            document.querySelector('.administrasi1').addEventListener('click', function () {
                                window.location.href = 'Administrasi.html';
                            });
                        </script>
                    </div>
                </div>

                <!-- Lingkungan -->
                <div class="box">
                    <img src="asset/lingkungan.jpg" alt="Kategori 3">
                    <div class="text-bar">
                        <button class="lingkungan1">Lingkungan</button>
                        <script> document.querySelector('.lingkungan1').addEventListener('click', function () { window.location.href = 'lingkungan.html'; });</script>
                    </div>
                </div>
                <div class="box">
                    <img src="asset/pelecehan.jpg" alt="Kategori 4">

                    <!-- pelecehan -->
                    <div class="text-bar">
                        <button class="pelecehan1">Pelecehan</button>
                        <script>
                            document.querySelector('.pelecehan1').addEventListener('click', function () {
                                window.location.href = 'pelecehan.html'; // Ganti dengan URL halaman pelecehan Anda
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <!-- Layanan Section -->
        <div class="Layanan" id="layanan">

            <!-- input keluhan -->
            <div class="header">Layanan</div>
            <div class="content">
                <div class="box">
                    <img src="asset/keluhan.jpg" alt="Layanan 1">
                    <div class="text-bar">
                        <button class="keluhan1">input keluhan</button>
                        <script>
                            document.querySelector('.keluhan1').addEventListener('click', function () {
                                window.location.href = 'keluhan.html';
                            });
                        </script>
                    </div>
                </div>

                <!-- feedback -->
                <div class="box">
                    <img src="asset/feed-a.webp" alt="Layanan 2">
                    <div class="text-bar">
                        <button class="feed1">Masukan</button>
                        <script>
                            document.querySelector('.feed1').addEventListener('click', function () {
                                window.location.href = 'feedback.html'; // Ganti dengan URL halaman feedback Anda
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>

    
    
    
       <?php elseif ($user_role === 'operator'): //operator fitur ?>
    <div class="operator-dashboard">
        <!-- Keluhan Section -->
        <div class="dashboard-section complaint-section">
            <div class="section-header">
                <h2><i class="fas fa-exclamation-circle"></i> Manajemen Keluhan Mahasiswa</h2>
            </div>
            
            <?php if (isset($_SESSION['status_message'])): ?>
                <div class="alert alert-<?php echo htmlspecialchars($_SESSION['status_type']); ?>">
                    <p><?php echo htmlspecialchars($_SESSION['status_message']); ?></p>
                    <button class="close-btn">&times;</button>
                </div>
                <?php
                unset($_SESSION['status_message']);
                unset($_SESSION['status_type']);
            endif;
            ?>
            
            <div class="table-responsive">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelapor</th>
                            <th>Fakultas</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_all_complaints = "SELECT 
                                                id, user_id, username, fakultas, 
                                                kategori, deskripsi, status, created_at 
                                            FROM 
                                                keluhan 
                                            ORDER BY 
                                                created_at DESC";
                        $result_all_complaints = mysqli_query($conn, $sql_all_complaints);

                        if ($result_all_complaints && mysqli_num_rows($result_all_complaints) > 0) {
                            while ($row = mysqli_fetch_assoc($result_all_complaints)) {
                                $status_class = strtolower($row['status']);
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td><?php echo htmlspecialchars($row['fakultas']); ?></td>
                                    <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                                    <td class="description-cell"><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></td>
                                    <td><span class="status-badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                                    <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <form action="php/updatestatuskeluhan.php" method="post" class="status-form">
                                            <input type="hidden" name="complaint_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                            <div class="form-group">
                                                <select name="new_status" class="status-select">
                                                    <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                    <option value="Diproses" <?php echo ($row['status'] == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                                                    <option value="Selesai" <?php echo ($row['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                                                    <option value="Ditolak" <?php echo ($row['status'] == 'Ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                                                </select>
                                                <button type="submit" class="btn-update"><i class="fas fa-sync-alt"></i> Update</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="8" class="no-data">Tidak ada keluhan saat ini.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Feedback Section -->
        <div class="dashboard-section feedback-section">
            <div class="section-header">
                <h2><i class="fas fa-comment-alt"></i> Manajemen Feedback Mahasiswa</h2>
            </div>
            
            <?php if (isset($_SESSION['feedback_status_message'])): ?>
                <div class="alert alert-<?php echo htmlspecialchars($_SESSION['feedback_status_type']); ?>">
                    <p><?php echo htmlspecialchars($_SESSION['feedback_status_message']); ?></p>
                    <button class="close-btn">&times;</button>
                </div>
                <?php
                unset($_SESSION['feedback_status_message']);
                unset($_SESSION['feedback_status_type']);
            endif;
            ?>
            
            <div class="table-responsive">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Fakultas</th>
                            <th>Prodi</th>
                            <th>Feedback</th>
                            <th>Balasan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_all_feedback = "SELECT id, nama, fakultas, prodi, feedback, reply 
                                          FROM feeback 
                                          ORDER BY id DESC";
                        $result_all_feedback = mysqli_query($conn, $sql_all_feedback);

                        if ($result_all_feedback && mysqli_num_rows($result_all_feedback) > 0) {
                            while ($row = mysqli_fetch_assoc($result_all_feedback)) {
                                $feedback_replies_sql = "SELECT username_replier, role_replier, reply_text, created_at 
                                                     FROM feedback_replies 
                                                     WHERE feedback_id = '" . mysqli_real_escape_string($conn, $row['id']) . "' 
                                                     ORDER BY created_at ASC";
                                $feedback_replies_result = mysqli_query($conn, $feedback_replies_sql);
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($row['fakultas']); ?></td>
                                    <td><?php echo htmlspecialchars($row['prodi']); ?></td>
                                    <td class="description-cell"><?php echo nl2br(htmlspecialchars($row['feedback'])); ?></td>
                                    <td class="replies-cell">
                                        <?php
                                        if ($feedback_replies_result && mysqli_num_rows($feedback_replies_result) > 0) {
                                            while ($reply_row = mysqli_fetch_assoc($feedback_replies_result)) {
                                                $role_class = ($reply_row['role_replier'] === 'operator') ? 'role-operator' : 'role-mahasiswa';
                                                echo "<div class='reply-item'>";
                                                echo "<div class='reply-header'>";
                                                echo "<span class='replier-name'>" . htmlspecialchars($reply_row['username_replier']) . "</span>";
                                                echo "<span class='replier-role $role_class'>" . htmlspecialchars(ucfirst($reply_row['role_replier'])) . "</span>";
                                                echo "<span class='reply-date'>" . date('d M Y H:i', strtotime($reply_row['created_at'])) . "</span>";
                                                echo "</div>";
                                                echo "<div class='reply-text'>" . nl2br(htmlspecialchars($reply_row['reply_text'])) . "</div>";
                                                echo "</div>";
                                            }
                                        } else {
                                            echo "<span class='no-replies'>Belum ada balasan.</span>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <form action="php/prosesfb.php" method="post" class="reply-form">
                                            <input type="hidden" name="feedback_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                            <textarea name="reply_text" rows="3" placeholder="Tulis balasan..." required></textarea>
                                            <button type="submit" class="btn-reply"><i class="fas fa-paper-plane"></i> Kirim</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="7" class="no-data">Tidak ada feedback saat ini.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        /* Operator Dashboard Styles */
        .operator-dashboard {
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
            
        }
        
        .dashboard-section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .section-header {
            background: linear-gradient(135deg, #e63946, #d00000);
            color: white;
            padding: 15px 20px;
        }
        
        .section-header h2 {
            margin: 0;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert {
            padding: 15px;
            margin: 15px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: inherit;
        }
        
        .table-responsive {
            overflow-x: auto;
            padding: 0 15px 15px;
        }
        
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .styled-table th {
            background-color: #f8f9fa;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #e9ecef;
        }
        
        .styled-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: top;
        }
        
        .styled-table tr:hover {
            background-color: #f8f9fa;
        }
        
        .description-cell {
            max-width: 300px;
            word-wrap: break-word;
        }
        
        .replies-cell {
            max-width: 300px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .pending { background-color: #fff3cd; color: #856404; }
        .diproses { background-color: #cce5ff; color: #004085; }
        .selesai { background-color: #d4edda; color: #155724; }
        .ditolak { background-color: #f8d7da; color: #721c24; }
        
        .status-form .form-group {
            display: flex;
            gap: 10px;
        }
        
        .status-select {
            flex-grow: 1;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        
        .btn-update {
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.2s;
        }
        
        .btn-update:hover {
            background-color: #5a6268;
        }
        
        .reply-item {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #e9ecef;
        }
        
        .reply-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .reply-header {
            display: flex;
            gap: 8px;
            margin-bottom: 5px;
            flex-wrap: wrap;
            align-items: center;
        }
        
        .replier-name {
            font-weight: 500;
        }
        
        .replier-role {
            font-size: 0.8rem;
            padding: 2px 6px;
            border-radius: 10px;
        }
        
        .role-operator { background-color: #e6f7ff; color: #0056b3; }
        .role-mahasiswa { background-color: #f0f0f0; color: #555; }
        
        .reply-date {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .reply-text {
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        .reply-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            resize: vertical;
            min-height: 80px;
            margin-bottom: 8px;
        }
        
        .btn-reply {
            background-color: #e63946;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.2s;
            width: 100%;
            justify-content: center;
        }
        
        .btn-reply:hover {
            background-color: #c1121f;
        }
        
        .no-data {
            text-align: center;
            padding: 20px;
            color: #6c757d;
        }
        
        @media (max-width: 768px) {
            .status-form .form-group {
                flex-direction: column;
                gap: 8px;
            }
            
            .description-cell, .replies-cell {
                max-width: 200px;
            }
        }
    </style>

    <script>
        // Close alert messages
        document.querySelectorAll('.close-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.target.closest('.alert').style.display = 'none';
            });
        });
    </script>
<?php endif; ?>