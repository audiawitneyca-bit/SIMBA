<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Ambil ringkasan angka untuk panel admin
$q_beasiswa  = mysqli_query($conn, "SELECT COUNT(*) AS total FROM beasiswa");
$tot_beasiswa = mysqli_fetch_assoc($q_beasiswa)['total'] ?? 0;

$q_pendaftar  = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pendaftaran");
$tot_pendaftar = mysqli_fetch_assoc($q_pendaftar)['total'] ?? 0;

$q_pending    = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pendaftaran WHERE status LIKE '%Proses%' OR status LIKE '%Menunggu%' OR status LIKE '%Pending%'");
$tot_pending  = mysqli_fetch_assoc($q_pending)['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin — SIMBA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body class="dash-body" id="dashBody">

    <!-- ================= FLOATING SIDEBAR ADMIN ================= -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="../index.php" class="brand sidebar-brand">
                <div class="brand-icon"><i class="ri-blaze-fill"></i></div>
                <span class="sidebar-text">SIMBA</span>
            </a>
            <button class="collapse-btn" id="collapseBtn" title="Sembunyikan / Perkecil Sidebar">
                <i class="ri-sidebar-fold-line" id="collapseIcon"></i>
            </button>
        </div>

        <nav class="sidebar-menu">
            <span class="menu-label sidebar-text">PANEL ADMIN</span>
            <a href="dashboard_admin.php" class="menu-item active" title="Ringkasan Admin">
                <i class="ri-pie-chart-2-line"></i>
                <span class="sidebar-text">Ringkasan</span>
            </a>
            <a href="kelola_beasiswa.php" class="menu-item" title="Kelola Beasiswa">
                <i class="ri-award-line"></i>
                <span class="sidebar-text">Kelola Beasiswa</span>
            </a>
            <a href="verifikasi_pendaftar.php" class="menu-item" title="Verifikasi Pendaftar">
                <i class="ri-user-follow-line"></i>
                <span class="sidebar-text">Verifikasi Pendaftar</span>
            </a>

            <span class="menu-label sidebar-text mt-section">LAINNYA</span>
            <a href="../index.php" class="menu-item" title="Lihat Beranda">
                <i class="ri-home-5-line"></i>
                <span class="sidebar-text">Beranda Utama</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="../auth/logout.php" class="btn-logout" title="Keluar Akun">
                <i class="ri-logout-box-r-line"></i>
                <span class="sidebar-text">Keluar Akun</span>
            </a>
        </div>
    </aside>

    <!-- ================= KONTEN UTAMA ADMIN ================= -->
    <main class="dash-main">
        <header class="dash-topbar">
            <div class="topbar-left">
                <button class="mobile-menu-btn" id="mobileMenuBtn"><i class="ri-menu-2-line"></i></button>
                <div>
                    <h1>Panel Administrator</h1>
                    <p>Halo, <strong><?= htmlspecialchars($_SESSION['nama']) ?></strong>! Kelola program beasiswa dan seleksi pendaftar di sini.</p>
                </div>
            </div>
            <div class="topbar-right">
                <span class="role-badge"><i class="ri-shield-star-fill"></i> Admin Verifikator</span>
            </div>
        </header>

        <div class="dash-content">
            <!-- Kartu Statistik Admin -->
            <section class="summary-grid" style="grid-template-columns: repeat(3, 1fr);">
                <div class="summary-card card-purple-grad">
                    <div class="summary-icon"><i class="ri-award-fill"></i></div>
                    <div>
                        <span class="summary-label">Program Beasiswa Aktif</span>
                        <h3><?= $tot_beasiswa ?> Program</h3>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon icon-purple"><i class="ri-group-fill"></i></div>
                    <div>
                        <span class="summary-label">Total Pengajuan Masuk</span>
                        <h3><?= $tot_pendaftar ?> Berkas</h3>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon icon-orange"><i class="ri-time-fill"></i></div>
                    <div>
                        <span class="summary-label">Menunggu Verifikasi</span>
                        <h3><?= $tot_pending ?> Mahasiswa</h3>
                    </div>
                </div>
            </section>

            <!-- Kartu Akses Cepat Pengelolaan -->
            <section class="dash-section">
                <div class="section-bar">
                    <div>
                        <h2><i class="ri-apps-2-fill"></i> Menu Pengelolaan Utama</h2>
                        <p>Pilih modul pengelolaan yang ingin kamu akses sekarang.</p>
                    </div>
                </div>

                <div class="summary-grid-two">
                    <a href="kelola_beasiswa.php" class="beasiswa-card" style="text-decoration: none;">
                        <div class="b-card-top">
                            <div class="summary-icon icon-orange"><i class="ri-add-box-fill"></i></div>
                            <span class="kuota-pill">Manajemen Program</span>
                        </div>
                        <h3>Kelola Data Beasiswa</h3>
                        <p class="b-desc">Tambah program beasiswa baru, atur kuota penerima, tentukan tenggat pendaftaran (deadline), atau hapus program yang sudah selesai.</p>
                        <span class="btn btn-outline-purple w-100">Buka Kelola Beasiswa <i class="ri-arrow-right-line"></i></span>
                    </a>

                    <a href="verifikasi_pendaftar.php" class="beasiswa-card" style="text-decoration: none;">
                        <div class="b-card-top">
                            <div class="summary-icon icon-purple"><i class="ri-checkbox-multiple-fill"></i></div>
                            <span class="deadline-pill">Seleksi Berkas</span>
                        </div>
                        <h3>Verifikasi Pendaftaran Mahasiswa</h3>
                        <p class="b-desc">Tinjau daftar mahasiswa yang melamar beserta nilai IPK-nya, lalu tetapkan status kelulusan (Diterima atau Ditolak).</p>
                        <span class="btn btn-orange w-100">Buka Verifikasi Pendaftar <i class="ri-arrow-right-line"></i></span>
                    </a>
                </div>
            </section>
        </div>
    </main>

    <script>
        const dashBody = document.getElementById('dashBody');
        const sidebar = document.getElementById('sidebar');
        const collapseBtn = document.getElementById('collapseBtn');
        const collapseIcon = document.getElementById('collapseIcon');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');

        if (collapseBtn) {
            collapseBtn.addEventListener('click', () => {
                if (window.innerWidth <= 820) {
                    sidebar.classList.remove('open');
                } else {
                    dashBody.classList.toggle('sidebar-collapsed');
                    collapseIcon.className = dashBody.classList.contains('sidebar-collapsed')
                        ? 'ri-sidebar-unfold-line'
                        : 'ri-sidebar-fold-line';
                }
            });
        }
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => sidebar.classList.toggle('open'));
        }
    </script>
</body>
</html>