<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Query daftar beasiswa aktif
$data_beasiswa = mysqli_query($conn, "SELECT * FROM beasiswa ORDER BY id_beasiswa DESC");

// Hitung pendaftar baru yang belum dilihat admin untuk badge notifikasi sidebar
$last_seen_id   = $_SESSION['last_seen_pendaftar_id'] ?? 0;
$q_notif        = mysqli_query($conn, "SELECT COUNT(*) AS baru FROM pendaftaran WHERE (LOWER(status) LIKE '%menunggu%' OR LOWER(status) LIKE '%proses%' OR LOWER(status) LIKE '%pending%') AND id_pendaftaran > $last_seen_id");
$jml_notif_baru = (int)(mysqli_fetch_assoc($q_notif)['baru'] ?? 0);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Beasiswa — SIMBA</title>
    <link rel="icon" type="image/png" href="../assets/img/logo.png">
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
                <div class="brand-icon"><img src="../assets/img/logo.png" alt="Logo SIMBA"></div>
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
            <a href="kelola_beasiswa.php" class="menu-item active" title="Kelola Beasiswa">
                <i class="ri-award-line"></i>
                <span class="sidebar-text">Kelola Beasiswa</span>
            </a>
            <a href="verifikasi_pendaftar.php" class="menu-item" title="Verifikasi Pendaftar">
                <i class="ri-user-follow-line"></i>
                <span class="sidebar-text">Verifikasi Pendaftar</span>
                <?php if ($jml_notif_baru > 0): ?>
                    <span class="notif-badge"><?= $jml_notif_baru ?></span>
                <?php endif; ?>
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
                    <h1>Kelola Data Beasiswa</h1>
                    <p>Tambahkan program beasiswa baru, atur kuota, atau tentukan program unggulan landing page.</p>
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
            <?php if (isset($_GET['error'])): ?>
                <div class="dash-alert alert-error">
                    <i class="ri-error-warning-fill"></i>
                    <span><?= htmlspecialchars($_GET['error']) ?></span>
                </div>
            <?php endif; ?>

            <!-- Form Tambah Program Beasiswa Baru (Full Width) -->
            <section class="dash-section">
                <div class="beasiswa-card" style="width: 100%;">
                    <div class="section-bar" style="margin-bottom: 18px;">
                        <div>
                            <h2><i class="ri-add-circle-fill"></i> Tambah Program Beasiswa Baru</h2>
                            <p>Lengkapi detail program beasiswa yang akan dibuka untuk mahasiswa.</p>
                        </div>
                    </div>

                    <form action="../admin/proses_beasiswa.php" method="POST">
                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="display:block; font-weight:700; font-size:0.88rem; color:var(--purple-dark); margin-bottom:6px;">Nama Program Beasiswa</label>
                            <input type="text" name="nama_beasiswa" placeholder="Contoh: Beasiswa Prestasi Akademik 2026" required
                                   style="width:100%; padding:12px 16px; border-radius:14px; border:1.5px solid #e2d9ec; font-family:inherit; font-size:0.94rem;">
                        </div>

                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="display:block; font-weight:700; font-size:0.88rem; color:var(--purple-dark); margin-bottom:6px;">Deskripsi & Persyaratan Singkat</label>
                            <textarea name="deskripsi" rows="3" placeholder="Jelaskan kriteria penerima, cakupan dana, dan dokumen syarat..." required
                                      style="width:100%; padding:12px 16px; border-radius:14px; border:1.5px solid #e2d9ec; font-family:inherit; font-size:0.94rem; resize:vertical;"></textarea>
                        </div>

                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 22px;">
                            <div>
                                <label style="display:block; font-weight:700; font-size:0.88rem; color:var(--purple-dark); margin-bottom:6px;">Kuota Penerima (Orang)</label>
                                <input type="number" name="kuota" min="1" placeholder="Contoh: 50" required
                                       style="width:100%; padding:12px 16px; border-radius:14px; border:1.5px solid #e2d9ec; font-family:inherit; font-size:0.94rem;">
                            </div>
                            <div>
                                <label style="display:block; font-weight:700; font-size:0.88rem; color:var(--purple-dark); margin-bottom:6px;">Batas Pendaftaran (Deadline)</label>
                                <input type="date" name="deadline" required
                                       style="width:100%; padding:12px 16px; border-radius:14px; border:1.5px solid #e2d9ec; font-family:inherit; font-size:0.94rem;">
                            </div>
                        </div>

                        <button type="submit" name="tambah" class="btn btn-orange btn-lg">
                            <i class="ri-save-3-line"></i> Simpan Program Beasiswa
                        </button>
                    </form>
                </div>
            </section>

            <!-- Daftar Beasiswa Aktif -->
            <section class="dash-section">
                <div class="section-bar">
                    <div>
                        <h2><i class="ri-list-check-2"></i> Daftar Beasiswa Aktif</h2>
                        <p>Seluruh program beasiswa yang saat ini tampil di halaman landing page dan pendaftar.</p>
                    </div>
                </div>

                <div class="table-card">
                    <?php if ($data_beasiswa && mysqli_num_rows($data_beasiswa) > 0): ?>
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Beasiswa</th>
                                        <th>Deskripsi</th>
                                        <th>Kuota</th>
                                        <th>Deadline</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; while ($row = mysqli_fetch_assoc($data_beasiswa)): 
                                        $is_top = !empty($row['is_unggulan']) && $row['is_unggulan'] == 1;
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($row['nama_beasiswa']) ?></strong>
                                            <?php if ($is_top): ?>
                                                <br><span class="deadline-pill" style="margin-top:4px;"><i class="ri-fire-fill"></i> Paling Banyak Diminati</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="max-width: 320px; color: var(--text-muted);"><?= htmlspecialchars($row['deskripsi']) ?></td>
                                        <td><span class="kuota-pill"><?= $row['kuota'] ?> Orang</span></td>
                                        <td><span class="deadline-pill"><?= htmlspecialchars($row['deadline']) ?></span></td>
                                        <td>
                                            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                                <?php if (!$is_top): ?>
                                                    <a href="../admin/proses_beasiswa.php?unggulan=<?= $row['id_beasiswa'] ?>"
                                                       class="status-badge badge-pending" style="text-decoration: none;" title="Tampilkan sebagai Paling Banyak Diminati di Landing Page">
                                                        <i class="ri-star-line"></i> Set Unggulan
                                                    </a>
                                                <?php endif; ?>
                                                <a href="../admin/proses_beasiswa.php?hapus=<?= $row['id_beasiswa'] ?>"
                                                   onclick="return confirm('Yakin ingin menghapus program beasiswa ini?')"
                                                   class="status-badge badge-rejected" style="text-decoration: none;">
                                                    <i class="ri-delete-bin-6-line"></i> Hapus
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
                            <i class="ri-award-line"></i>
                            <h4>Belum Ada Program Beasiswa</h4>
                            <p>Gunakan formulir di atas untuk menambahkan program beasiswa pertama.</p>
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
    </script>
</body>
</html>