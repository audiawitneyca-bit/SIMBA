<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'pendaftar') {
    header("Location: login.php");
    exit;
}

$id_user  = $_SESSION['id_user'];
$beasiswa = mysqli_query($conn, "SELECT * FROM beasiswa ORDER BY id_beasiswa DESC");
$riwayat  = mysqli_query($conn, "
    SELECT p.*, b.nama_beasiswa 
    FROM pendaftaran p 
    JOIN beasiswa b ON p.id_beasiswa = b.id_beasiswa 
    WHERE p.id_user = $id_user 
    ORDER BY p.id_pendaftaran DESC
");

$list_beasiswa = [];
while ($row = mysqli_fetch_assoc($beasiswa)) {
    $list_beasiswa[] = $row;
}

$list_riwayat = [];
$total_proses = 0;
while ($row = mysqli_fetch_assoc($riwayat)) {
    $list_riwayat[] = $row;
    $st = strtolower($row['status']);
    if (str_contains($st, 'proses') || str_contains($st, 'pending') || str_contains($st, 'menunggu')) {
        $total_proses++;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pendaftar — SIMBA</title>
    <link rel="icon" type="image/jpeg" href="../assets/img/logo.jpeg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body class="dash-body" id="dashBody">

    <!-- ================= FLOATING SIDEBAR (GAYA STOREUI + COLLAPSIBLE) ================= -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="../index.php" class="brand sidebar-brand">
                <div class="brand-icon"><img src="../assets/img/logo.jpeg" alt="Logo SIMBA"></div>
                <span class="sidebar-text">SIMBA</span>
            </a>
            <!-- Tombol Hide / Collapse Sidebar -->
            <button class="collapse-btn" id="collapseBtn" title="Sembunyikan / Perkecil Sidebar">
                <i class="ri-sidebar-fold-line" id="collapseIcon"></i>
            </button>
        </div>

        <nav class="sidebar-menu">
            <span class="menu-label sidebar-text">MENU</span>
            <a href="#ringkasan" class="menu-item active" title="Ringkasan">
                <i class="ri-pie-chart-2-line"></i>
                <span class="sidebar-text">Ringkasan</span>
            </a>
            <a href="#katalog-beasiswa" class="menu-item" title="Eksplorasi Beasiswa">
                <i class="ri-graduation-cap-line"></i>
                <span class="sidebar-text">Eksplorasi Beasiswa</span>
            </a>
            <a href="#status-pendaftaran" class="menu-item" title="Status Lamaran">
                <i class="ri-file-list-3-line"></i>
                <span class="sidebar-text">Status Lamaran</span>
            </a>

            <span class="menu-label sidebar-text mt-section">LAINNYA</span>
            <a href="#profil-modal" class="menu-item" id="openProfileBtn" title="Foto Profil">
                <i class="ri-camera-lens-line"></i>
                <span class="sidebar-text">Ubah Foto Profil</span>
            </a>
            <a href="../index.php" class="menu-item" title="Beranda Utama">
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

    <!-- ================= KONTEN UTAMA DASBOR ================= -->
    <main class="dash-main">
        <!-- Topbar dengan Profil & Trigger Foto -->
        <header class="dash-topbar">
            <div class="topbar-left">
                <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Buka Menu">
                    <i class="ri-menu-2-line"></i>
                </button>
                <div>
                    <h1>Dashboard Mahasiswa</h1>
                    <p>Selamat datang kembali, <strong><?= htmlspecialchars($_SESSION['nama']) ?></strong>!</p>
                </div>
            </div>

            <div class="topbar-right">
                <div class="user-profile-pill" id="profilePill" title="Klik untuk ganti foto profil">
                    <div class="profile-avatar-wrap">
                        <img src="" alt="Foto Profil" id="headerAvatarImg" class="avatar-img hidden">
                        <span id="headerAvatarInitial"><?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?></span>
                        <div class="cam-badge"><i class="ri-camera-fill"></i></div>
                    </div>
                    <div class="profile-meta">
                        <strong><?= htmlspecialchars($_SESSION['nama']) ?></strong>
                        <span>Mahasiswa Pendaftar</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="dash-content">
            <!-- Alert Notifikasi dari Backend Witney -->
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

            <!-- 1. KARTU STATISTIK RINGKASAN (2 KARTU UTAMA SAJA) -->
            <section class="summary-grid-two" id="ringkasan">
                <div class="summary-card card-purple-grad">
                    <div class="summary-icon"><i class="ri-award-fill"></i></div>
                    <div>
                        <span class="summary-label">Beasiswa Tersedia</span>
                        <h3><?= count($list_beasiswa) ?> Program</h3>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon icon-orange"><i class="ri-time-fill"></i></div>
                    <div>
                        <span class="summary-label">Sedang Diverifikasi</span>
                        <h3><?= $total_proses ?> Berkas</h3>
                    </div>
                </div>
            </section>

            <!-- 2. KATALOG BEASISWA TERSEDIA -->
            <section class="dash-section" id="katalog-beasiswa">
                <div class="section-bar">
                    <div>
                        <h2><i class="ri-compass-3-fill"></i> Daftar Beasiswa Tersedia</h2>
                        <p>Masukkan IPK terakhirmu dan klik daftar pada program beasiswa yang kamu minati.</p>
                    </div>
                    <div class="search-box">
                        <i class="ri-search-line"></i>
                        <input type="text" id="searchBeasiswa" placeholder="Cari nama beasiswa...">
                    </div>
                </div>

                <?php if (count($list_beasiswa) > 0): ?>
                    <div class="beasiswa-grid" id="beasiswaGrid">
                        <?php foreach ($list_beasiswa as $b): ?>
                            <div class="beasiswa-card" data-title="<?= strtolower(htmlspecialchars($b['nama_beasiswa'])) ?>">
                                <div class="b-card-top">
                                    <span class="kuota-pill"><i class="ri-group-line"></i> Kuota: <?= $b['kuota'] ?></span>
                                    <span class="deadline-pill"><i class="ri-calendar-event-line"></i> <?= htmlspecialchars($b['deadline']) ?></span>
                                </div>

                                <h3><?= htmlspecialchars($b['nama_beasiswa']) ?></h3>
                                <p class="b-desc"><?= htmlspecialchars($b['deskripsi']) ?></p>

                                <form action="../pendaftar/proses_daftar.php" method="POST" class="apply-form">
                                    <input type="hidden" name="id_beasiswa" value="<?= $b['id_beasiswa'] ?>">
                                    <div class="ipk-input-group">
                                        <label for="ipk_<?= $b['id_beasiswa'] ?>">IPK Terakhir</label>
                                        <input type="number" id="ipk_<?= $b['id_beasiswa'] ?>" step="0.01" min="0" max="4" name="ipk" placeholder="Cth: 3.75" required>
                                    </div>
                                    <button type="submit" class="btn btn-orange w-100">
                                        Ajukan Pendaftaran <i class="ri-arrow-right-up-line"></i>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="ri-folder-open-line"></i>
                        <h4>Belum Ada Program Beasiswa Aktif</h4>
                        <p>Silakan cek kembali secara berkala untuk pembaruan pembukaan beasiswa terbaru.</p>
                    </div>
                <?php endif; ?>
            </section>

            <!-- 3. STATUS PENDAFTARAN SAYA -->
            <section class="dash-section" id="status-pendaftaran">
                <div class="section-bar">
                    <div>
                        <h2><i class="ri-file-check-fill"></i> Status Pendaftaran Saya</h2>
                        <p>Pantau perkembangan seleksi dan hasil verifikasi berkas beasiswa yang telah kamu ajukan.</p>
                    </div>
                </div>

                <div class="table-card">
                    <?php if (count($list_riwayat) > 0): ?>
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Program Beasiswa</th>
                                        <th>IPK Diajukan</th>
                                        <th>Status Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($list_riwayat as $r): 
                                        $status_raw = strtolower($r['status']);
                                        $badge_class = 'badge-pending';
                                        $badge_icon  = 'ri-time-line';
                                        if (str_contains($status_raw, 'terima') || str_contains($status_raw, 'lolos')) {
                                            $badge_class = 'badge-approved';
                                            $badge_icon  = 'ri-checkbox-circle-line';
                                        } elseif (str_contains($status_raw, 'tolak') || str_contains($status_raw, 'gagal')) {
                                            $badge_class = 'badge-rejected';
                                            $badge_icon  = 'ri-close-circle-line';
                                        }
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= htmlspecialchars($r['nama_beasiswa']) ?></strong></td>
                                        <td><span class="ipk-tag"><?= number_format((float)$r['ipk'], 2) ?></span></td>
                                        <td>
                                            <span class="status-badge <?= $badge_class ?>">
                                                <i class="<?= $badge_icon ?>"></i>
                                                <?= htmlspecialchars(ucfirst($r['status'])) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="ri-file-search-line"></i>
                            <h4>Belum Ada Riwayat Pendaftaran</h4>
                            <p>Kamu belum mendaftar ke program beasiswa mana pun. Pilih program di atas untuk mulai mendaftar!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </main>

    <!-- ================= MODAL UPLOAD FOTO PROFIL ================= -->
    <div class="modal-backdrop" id="photoModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Foto Profil Mahasiswa</h3>
                <button class="modal-close" id="closeModal"><i class="ri-close-line"></i></button>
            </div>
            <p class="modal-desc">Unggah foto formal atau semi-formal terbaikmu untuk ditampilkan pada profil pendaftar SIMBA.</p>

            <div class="modal-preview-area">
                <div class="big-avatar-preview" id="modalPreviewBox">
                    <img src="" alt="Preview" id="modalAvatarImg" class="hidden">
                    <span id="modalAvatarInitial"><?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?></span>
                </div>
            </div>

            <div class="modal-actions">
                <label for="photoInput" class="btn btn-orange w-100">
                    <i class="ri-upload-cloud-2-line"></i> Pilih Foto dari Perangkat
                </label>
                <input type="file" id="photoInput" accept="image/*" hidden>
                <button type="button" class="btn btn-outline-purple w-100" id="removePhotoBtn">
                    Hapus Foto
                </button>
            </div>
        </div>
    </div>

    <script>
        const dashBody = document.getElementById('dashBody');
        const sidebar = document.getElementById('sidebar');
        const collapseBtn = document.getElementById('collapseBtn');
        const collapseIcon = document.getElementById('collapseIcon');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');

        // 1. Toggle Hide / Collapse Sidebar di Desktop
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

        // Toggle Sidebar di Mobile
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('open');
            });
        }

        // 2. Active State Menu Sidebar saat diklik
        document.querySelectorAll('.sidebar-menu .menu-item[href^="#"]').forEach(link => {
            link.addEventListener('click', function() {
                if (this.id === 'openProfileBtn') return;
                document.querySelectorAll('.sidebar-menu .menu-item').forEach(el => el.classList.remove('active'));
                this.classList.add('active');
                if (window.innerWidth <= 820) sidebar.classList.remove('open');
            });
        });

        // 3. Pencarian Instan Beasiswa
        const searchInput = document.getElementById('searchBeasiswa');
        const cards = document.querySelectorAll('.beasiswa-card');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const keyword = e.target.value.toLowerCase();
                cards.forEach(card => {
                    const title = card.getAttribute('data-title');
                    card.style.display = title.includes(keyword) ? 'flex' : 'none';
                });
            });
        }

        // 4. Upload & Preview Foto Profil Mahasiswa
        const photoModal = document.getElementById('photoModal');
        const profilePill = document.getElementById('profilePill');
        const openProfileBtn = document.getElementById('openProfileBtn');
        const closeModal = document.getElementById('closeModal');
        const photoInput = document.getElementById('photoInput');
        const removePhotoBtn = document.getElementById('removePhotoBtn');

        const headerAvatarImg = document.getElementById('headerAvatarImg');
        const headerAvatarInitial = document.getElementById('headerAvatarInitial');
        const modalAvatarImg = document.getElementById('modalAvatarImg');
        const modalAvatarInitial = document.getElementById('modalAvatarInitial');

        const storageKey = 'simba_avatar_user_<?= $id_user ?>';

        function applyAvatar(dataUrl) {
            if (dataUrl) {
                headerAvatarImg.src = dataUrl;
                modalAvatarImg.src = dataUrl;
                headerAvatarImg.classList.remove('hidden');
                modalAvatarImg.classList.remove('hidden');
                headerAvatarInitial.classList.add('hidden');
                modalAvatarInitial.classList.add('hidden');
            } else {
                headerAvatarImg.classList.add('hidden');
                modalAvatarImg.classList.add('hidden');
                headerAvatarInitial.classList.remove('hidden');
                modalAvatarInitial.classList.remove('hidden');
            }
        }

        // Muat foto tersimpan jika ada
        applyAvatar(localStorage.getItem(storageKey));

        [profilePill, openProfileBtn].forEach(trigger => {
            if (trigger) {
                trigger.addEventListener('click', (e) => {
                    e.preventDefault();
                    photoModal.classList.add('show');
                });
            }
        });

        closeModal.addEventListener('click', () => photoModal.classList.remove('show'));
        photoModal.addEventListener('click', (e) => {
            if (e.target === photoModal) photoModal.classList.remove('show');
        });

        photoInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (ev) => {
                localStorage.setItem(storageKey, ev.target.result);
                applyAvatar(ev.target.result);
            };
            reader.readAsDataURL(file);
        });

        removePhotoBtn.addEventListener('click', () => {
            localStorage.removeItem(storageKey);
            photoInput.value = '';
            applyAvatar(null);
        });
    </script>
</body>
</html>