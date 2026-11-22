<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$pendaftar = mysqli_query($conn, "
    SELECT p.id_pendaftaran, u.nama_lengkap, u.email, b.nama_beasiswa, p.ipk, p.status
    FROM pendaftaran p
    JOIN users u ON p.id_user = u.id_user
    JOIN beasiswa b ON p.id_beasiswa = b.id_beasiswa
    ORDER BY p.id_pendaftaran DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pendaftar — SIMBA</title>
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
            <a href="dashboard_admin.php" class="menu-item" title="Ringkasan Admin">
                <i class="ri-pie-chart-2-line"></i>
                <span class="sidebar-text">Ringkasan</span>
            </a>
            <a href="kelola_beasiswa.php" class="menu-item" title="Kelola Beasiswa">
                <i class="ri-award-line"></i>
                <span class="sidebar-text">Kelola Beasiswa</span>
            </a>
            <a href="verifikasi_pendaftar.php" class="menu-item active" title="Verifikasi Pendaftar">
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

    <!-- ================= KONTEN UTAMA ================= -->
    <main class="dash-main">
        <header class="dash-topbar">
            <div class="topbar-left">
                <button class="mobile-menu-btn" id="mobileMenuBtn"><i class="ri-menu-2-line"></i></button>
                <div>
                    <h1>Verifikasi Pendaftaran Mahasiswa</h1>
                    <p>Tinjau kelayakan IPK dan tetapkan hasil seleksi pendaftar beasiswa.</p>
                </div>
            </div>
            <div class="topbar-right">
                <a href="dashboard_admin.php" class="btn btn-outline-purple" style="padding: 9px 18px; font-size: 0.85rem;">
                    <i class="ri-arrow-left-line"></i> Kembali
                </a>
            </div>
        </header>

        <div class="dash-content">
            <?php if (isset($_GET['success'])): ?>
                <div class="dash-alert alert-success">
                    <i class="ri-checkbox-circle-fill"></i>
                    <span><?= htmlspecialchars($_GET['success']) ?></span>
                </div>
            <?php endif; ?>

            <section class="dash-section">
                <div class="section-bar">
                    <div>
                        <h2><i class="ri-user-search-fill"></i> Daftar Pengajuan Masuk</h2>
                        <p>Klik tombol <strong>Terima</strong> atau <strong>Tolak</strong> untuk memperbarui status pendaftaran mahasiswa.</p>
                    </div>
                    <div class="search-box">
                        <i class="ri-search-line"></i>
                        <input type="text" id="searchPendaftar" placeholder="Cari mahasiswa / beasiswa...">
                    </div>
                </div>

                <div class="table-card">
                    <?php if (mysqli_num_rows($pendaftar) > 0): ?>
                        <div class="table-responsive">
                            <table class="modern-table" id="pendaftarTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Mahasiswa</th>
                                        <th>Program Beasiswa</th>
                                        <th>IPK</th>
                                        <th>Status Saat Ini</th>
                                        <th>Keputusan Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; while ($row = mysqli_fetch_assoc($pendaftar)): 
                                        $st = strtolower($row['status']);
                                        $badge_class = 'badge-pending';
                                        $badge_icon  = 'ri-time-line';
                                        if (str_contains($st, 'terima') || str_contains($st, 'lolos')) {
                                            $badge_class = 'badge-approved';
                                            $badge_icon  = 'ri-checkbox-circle-line';
                                        } elseif (str_contains($st, 'tolak') || str_contains($st, 'gagal')) {
                                            $badge_class = 'badge-rejected';
                                            $badge_icon  = 'ri-close-circle-line';
                                        }
                                    ?>
                                    <tr class="pendaftar-row" data-search="<?= strtolower(htmlspecialchars($row['nama_lengkap'] . ' ' . $row['email'] . ' ' . $row['nama_beasiswa'])) ?>">
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($row['nama_lengkap']) ?></strong><br>
                                            <span style="font-size: 0.82rem; color: var(--text-muted);"><?= htmlspecialchars($row['email']) ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($row['nama_beasiswa']) ?></td>
                                        <td><span class="ipk-tag"><?= number_format((float)$row['ipk'], 2) ?></span></td>
                                        <td>
                                            <span class="status-badge <?= $badge_class ?>">
                                                <i class="<?= $badge_icon ?>"></i>
                                                <?= htmlspecialchars(ucfirst($row['status'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                                <a href="../admin/proses_verifikasi.php?id=<?= $row['id_pendaftaran'] ?>&status=Diterima"
                                                   class="status-badge badge-approved" style="text-decoration: none;">
                                                    <i class="ri-check-line"></i> Terima
                                                </a>
                                                <a href="../admin/proses_verifikasi.php?id=<?= $row['id_pendaftaran'] ?>&status=Ditolak"
                                                   class="status-badge badge-rejected" style="text-decoration: none;">
                                                    <i class="ri-close-line"></i> Tolak
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="ri-inbox-archive-line"></i>
                            <h4>Belum Ada Pengajuan Mahasiswa</h4>
                            <p>Belum ada mahasiswa yang mengajukan pendaftaran beasiswa saat ini.</p>
                        </div>
                    <?php endif; ?>
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

        // Pencarian Instan Pendaftar
        const searchInput = document.getElementById('searchPendaftar');
        const rows = document.querySelectorAll('.pendaftar-row');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const kw = e.target.value.toLowerCase();
                rows.forEach(row => {
                    row.style.display = row.getAttribute('data-search').includes(kw) ? '' : 'none';
                });
            });
        }
    </script>
</body>
</html>