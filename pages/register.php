<?php
session_start();
if (isset($_SESSION['id_user'])) {
    header("Location: dashboard_pendaftar.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — SIMBA Beasiswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body class="auth-body">

    <div class="auth-container">
        <!-- Panel Visual Kiri -->
        <div class="auth-visual">
            <div class="auth-blob-1"></div>
            <div class="auth-blob-2"></div>

            <a href="../index.php" class="auth-brand">
                <div class="brand-icon"><i class="ri-blaze-fill"></i></div>
                <span>SIMBA</span>
            </a>

            <div class="auth-visual-content">
                <span class="pill-tag-dark">LANGKAH AWAL MERAIH MIMPI</span>
                <h2>Satu Akun untuk Semua Peluang Beasiswa.</h2>
                <p>Buat akunmu dalam hitungan detik. Kelengkapan profil akademik dan unggah dokumen syarat bisa langsung kamu isi setelah masuk ke dasbor.</p>

                <ul class="auth-steps-preview">
                    <li><span>1</span> Registrasi akun singkat</li>
                    <li><span>2</span> Lengkapi biodata di dasbor</li>
                    <li><span>3</span> Pilih beasiswa & unggah berkas</li>
                </ul>
            </div>
        </div>

        <!-- Panel Form Kanan -->
        <div class="auth-form-side">
            <div class="auth-form-box">
                <a href="../index.php" class="back-home"><i class="ri-arrow-left-line"></i> Kembali ke Beranda</a>

                <div class="auth-header">
                    <h1>Buat Akun Baru</h1>
                    <p>Isi data dasar di bawah ini untuk mulai bergabung di SIMBA.</p>
                </div>

                <!-- Notifikasi Error dari Backend Witney -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-error">
                        <i class="ri-error-warning-fill"></i>
                        <span><?= htmlspecialchars($_GET['error']) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Tombol Google SSO -->
                <a href="../auth/google_login.php" class="btn-google">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                    <span>Daftar dengan Google</span>
                </a>

                <div class="auth-divider">
                    <span>atau daftar dengan email</span>
                </div>

                <!-- Form terhubung ke ../auth/proses_register.php -->
                <form action="../auth/proses_register.php" method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <div class="input-wrapper">
                            <i class="ri-user-3-line input-icon"></i>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Contoh: Martin J. Edwards" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Alamat Email Aktif</label>
                        <div class="input-wrapper">
                            <i class="ri-mail-line input-icon"></i>
                            <input type="email" id="email" name="email" placeholder="nmartined@email.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Buat Kata Sandi</label>
                        <div class="input-wrapper">
                            <i class="ri-lock-2-line input-icon"></i>
                            <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" minlength="6" required>
                            <button type="button" class="toggle-pass" data-target="password" aria-label="Lihat sandi">
                                <i class="ri-eye-off-line"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-orange w-100 btn-lg">
                        Daftar Akun <i class="ri-user-add-line"></i>
                    </button>
                </form>

                <p class="auth-switch">
                    Sudah punya akun SIMBA? <a href="login.php">Masuk di Sini</a>
                </p>
            </div>
        </div>
    </div>

    <script>
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