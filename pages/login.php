<?php
session_start();
// Jika sudah login, langsung arahkan ke dasbor masing-masing
if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: dashboard_admin.php");
    } else {
        header("Location: dashboard_pendaftar.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — SIMBA Beasiswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body class="auth-body">

    <div class="auth-container">
        <!-- Panel Visual Kiri (Gradient Ungu-Oranye) -->
        <div class="auth-visual">
            <div class="auth-blob-1"></div>
            <div class="auth-blob-2"></div>

            <a href="../index.php" class="auth-brand">
                <div class="brand-icon"><i class="ri-blaze-fill"></i></div>
                <span>SIMBA</span>
            </a>

            <div class="auth-visual-content">
                <span class="pill-tag-dark">PORTAL BEASISWA TERPADU</span>
                <h2>Selamat Datang Kembali, Pejuang Beasiswa!</h2>
                <p>Masuk ke akunmu untuk memantau status verifikasi berkas, melamar program baru, dan melihat pengumuman seleksi secara real-time.</p>

                <div class="auth-quote-card">
                    <div class="quote-stars">
                        <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                    </div>
                    <p>"Proses upload berkas sampai pengumuman di SIMBA super cepat dan transparan. Sangat membantu mahasiswa!"</p>
                    <span>— Awardee SIMBA Batch 2025</span>
                </div>
            </div>
        </div>

        <!-- Panel Form Kanan -->
        <div class="auth-form-side">
            <div class="auth-form-box">
                <a href="../index.php" class="back-home"><i class="ri-arrow-left-line"></i> Kembali ke Beranda</a>

                <div class="auth-header">
                    <h1>Masuk ke Akun</h1>
                    <p>Silakan masukkan email dan kata sandi yang terdaftar.</p>
                </div>

                <!-- Notifikasi Error / Sukses dari Backend Witney -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-error">
                        <i class="ri-error-warning-fill"></i>
                        <span><?= htmlspecialchars($_GET['error']) ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <i class="ri-checkbox-circle-fill"></i>
                        <span><?= htmlspecialchars($_GET['success']) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Tombol Google SSO -->
                <a href="../auth/google_login.php" class="btn-google">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                    <span>Masuk dengan Google</span>
                </a>

                <div class="auth-divider">
                    <span>atau masuk dengan email</span>
                </div>

                <!-- Form terhubung ke ../auth/proses_login.php -->
                <form action="../auth/proses_login.php" method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <div class="input-wrapper">
                            <i class="ri-mail-line input-icon"></i>
                            <input type="email" id="email" name="email" placeholder="nama@student.ac.id" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Kata Sandi</label>
                        <div class="input-wrapper">
                            <i class="ri-lock-2-line input-icon"></i>
                            <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
                            <button type="button" class="toggle-pass" data-target="password" aria-label="Lihat sandi">
                                <i class="ri-eye-off-line"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-orange w-100 btn-lg">
                        Masuk Sekarang <i class="ri-login-circle-line"></i>
                    </button>
                </form>

                <p class="auth-switch">
                    Belum punya akun SIMBA? <a href="register.php">Daftar Gratis di Sini</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Toggle lihat/sembunyikan password
        document.querySelectorAll('.toggle-pass').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = document.getElementById(btn.dataset.target);
                const icon = btn.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'ri-eye-line';
                } else {
                    input.type = 'password';
                    icon.className = 'ri-eye-off-line';
                }
            });
        });
    </script>
</body>
</html>