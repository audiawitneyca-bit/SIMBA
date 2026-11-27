<?php
require_once 'config/koneksi.php';
$query_beasiswa = mysqli_query($conn, "SELECT * FROM beasiswa ORDER BY id_beasiswa ASC");
$daftar_beasiswa = [];
if ($query_beasiswa) {
    while ($row = mysqli_fetch_assoc($query_beasiswa)) {
        $daftar_beasiswa[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMBA — Sistem Informasi Manajemen Beasiswa</title>
    <link rel="icon" type="image/jpeg" href="assets/img/logo.jpeg">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Remix Icon untuk ikon kekinian -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- ================= HEADER / NAVBAR ================= -->
    <header class="navbar" id="navbar">
        <div class="container nav-wrapper">
            <a href="index.php" class="brand">
                <div class="brand-icon"><img src="assets/img/logo.jpeg" alt="Logo SIMBA"></div>
                <span>SIMBA</span>
            </a>

            <nav class="nav-links" id="navLinks">
                <a href="#tentang">Tentang SIMBA</a>
                <a href="#jenis-beasiswa">Program Beasiswa</a>
                <a href="#benefit">Benefit</a>
                <a href="#statistik">Awardee</a>
            </nav>

            <div class="nav-actions">
                <a href="pages/login.php" class="btn btn-ghost">Masuk</a>
                <a href="pages/register.php" class="btn btn-orange">Daftar Sekarang</a>
                <button class="menu-toggle" id="menuToggle" aria-label="Menu">
                    <i class="ri-menu-3-line"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- ================= HERO SECTION ================= -->
    <section class="hero">
        <!-- Dekorasi Organic Blob & Floating Shapes -->
        <div class="blob-purple"></div>
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>

        <div class="container hero-grid">
            <!-- Slot Foto / Ilustrasi Utama di Kiri (Sesuai Referensi Layout) -->
            <div class="hero-visual reveal">
                <div class="photo-frame main-hero-frame">
                    <!-- GANTI src di bawah dengan foto mahasiswa/ilustrasi kamu di assets/img/ -->
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80" alt="Mahasiswa Penerima Beasiswa SIMBA">
                    <div class="floating-badge badge-top">
                        <i class="ri-shield-check-fill"></i>
                        <div>
                            <strong>100% Paperless</strong>
                            <span>Seleksi Transparan</span>
                        </div>
                    </div>
                    <div class="floating-badge badge-bottom">
                        <i class="ri-trophy-fill"></i>
                        <div>
                            <strong>Dana Pendidikan Penuh</strong>
                            <span>Hingga Lulus Kuliah</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Konten Teks Hero di Kanan -->
            <div class="hero-content reveal">
                <span class="pill-tag"><i class="ri-sparkling-2-fill"></i> Portal Beasiswa Terpadu</span>
                <h1>Raih Masa Depan Gemilang Bersama <span class="text-gradient">SIMBA</span></h1>
                <p>
                    Wujudkan impian akademikmu tanpa hambatan biaya. Eksplorasi puluhan program beasiswa unggulan, unggah berkas dalam satu klik, dan pantau status seleksimu secara real-time.
                </p>
                <div class="hero-cta">
                    <a href="pages/register.php" class="btn btn-orange btn-lg">
                        Mulai Daftar <i class="ri-arrow-right-up-line"></i>
                    </a>
                    <a href="#jenis-beasiswa" class="btn btn-outline-purple btn-lg">
                        <i class="ri-compass-3-line"></i> Jelajahi Program
                    </a>
                </div>
            </div>
        </div>

        <!-- Gelombang Pemisah (Wave Divider) -->
        <div class="wave-bottom">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
            </svg>
        </div>
    </section>

    <!-- ================= 1. APA ITU SIMBA ================= -->
    <section class="about-section" id="tentang">
        <div class="container about-grid">
            <div class="about-text reveal">
                <span class="section-subtitle">MENGENAL LEBIH DEKAT</span>
                <h2>Apa Itu <span class="highlight-orange">SIMBA?</span></h2>
                <p class="lead-text">
                    <strong>SIMBA (Sistem Informasi Manajemen Beasiswa)</strong> adalah portal terpadu berbasis web yang menjembatani penyedia dana pendidikan dengan calon pendaftar berbakat di seluruh Indonesia.
                </p>
                <p>
                    Secara filosofis, nama <strong>SIMBA</strong> terinspirasi dari keberanian sang singa—merepresentasikan semangat pantang menyerah dan kekuatan tekad para pelajar dalam memperjuangkan pendidikan tinggi. Sistem ini mendigitalisasi seluruh alur pengelolaan beasiswa mulai dari eksplorasi program, registrasi profil, pengunggahan dokumen syarat, hingga pengumuman akhir ke dalam satu ekosistem yang transparan dan terstruktur.
                </p>

                <div class="philosophy-cards">
                    <div class="mini-card">
                        <i class="ri-flashlight-fill"></i>
                        <div>
                            <h4>Cepat & Terpusat</h4>
                            <p>Satu akun untuk melamar berbagai jalur beasiswa aktif.</p>
                        </div>
                    </div>
                    <div class="mini-card">
                        <i class="ri-eye-2-fill"></i>
                        <div>
                            <h4>Tracking Real-Time</h4>
                            <p>Pantau progres verifikasi berkas langsung dari dasbor.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slot Foto Kegiatan / Kampus -->
            <div class="about-visual reveal">
                <div class="photo-collage">
                    <div class="collage-main">
                        <!-- GANTI src dengan foto kampus/kegiatan mahasiswa -->
                        <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=700&q=80" alt="Wisuda dan Prestasi Mahasiswa">
                    </div>
                    <div class="collage-sub">
                        <!-- GANTI src dengan foto diskusi/belajar -->
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=500&q=80" alt="Kolaborasi Mahasiswa">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= 4. JENIS BEASISWA (KARTU INTERAKTIF) ================= -->
    <section class="programs-section" id="jenis-beasiswa">
        <div class="container">
            <div class="section-header text-center reveal">
                <span class="section-subtitle">PILIH JALURMU</span>
                <h2>Program Beasiswa Tersedia</h2>
                <p>Pilih kategori beasiswa yang paling sesuai dengan potensi, latar belakang, dan target akademikmu.</p>
            </div>

            <!-- Kartu Pilihan Beasiswa (Highlight Card Tengah ala Referensi) -->
            <!-- Kartu Pilihan Beasiswa (Dinamis dari Database Admin, Tanpa Kuota) -->
            <div class="program-cards-grid">
                <?php if (count($daftar_beasiswa) > 0): ?>
                    <?php
                    $icons  = ['ri-medal-fill', 'ri-hand-heart-fill', 'ri-lightbulb-flash-fill', 'ri-award-fill'];
                    $badges = ['Jalur Unggulan', 'Jalur Afirmasi', 'Jalur Kreatif', 'Program Aktif'];
                    foreach ($daftar_beasiswa as $index => $b):
                        $is_featured = (!empty($b['is_unggulan']) && $b['is_unggulan'] == 1);
                        $icon_class  = $icons[$index % count($icons)];
                        $badge_text  = $badges[$index % count($badges)];
                    ?>
                        <div class="program-card <?= $is_featured ? 'featured-card' : '' ?> reveal">
                            <?php if ($is_featured): ?>
                                <div class="popular-ribbon">Paling Banyak Diminati</div>
                            <?php endif; ?>

                            <div class="card-icon <?= $is_featured ? 'white-glass' : ($index % 2 === 0 ? 'purple-soft' : 'orange-soft') ?>">
                                <i class="<?= $icon_class ?>"></i>
                            </div>
                            <span class="card-badge <?= $is_featured ? 'badge-orange' : '' ?>"><?= $badge_text ?></span>
                            <h3><?= htmlspecialchars($b['nama_beasiswa']) ?></h3>
                            <p><?= htmlspecialchars($b['deskripsi']) ?></p>

                            <ul class="card-criteria">
                                <li><i class="ri-calendar-event-fill"></i> Batas Daftar: <?= !empty($b['deadline']) ? date('d M Y', strtotime($b['deadline'])) : 'Segera Dibuka' ?></li>
                                <li><i class="ri-shield-check-fill"></i> Seleksi Transparan & Paperless</li>
                            </ul>
                            <a href="pages/register.php" class="btn <?= $is_featured ? 'btn-orange' : 'btn-outline-purple' ?> w-100">Daftar Jalur Ini</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="program-card reveal">
                        <div class="card-icon purple-soft"><i class="ri-medal-fill"></i></div>
                        <span class="card-badge">Info Program</span>
                        <h3>Program Beasiswa Segera Dibuka</h3>
                        <p>Pantau terus portal SIMBA untuk informasi pembukaan periode pendaftaran beasiswa terbaru.</p>
                        <ul class="card-criteria">
                            <li><i class="ri-calendar-event-fill"></i> Batas Daftar: Segera Hadir</li>
                        </ul>
                        <a href="pages/register.php" class="btn btn-outline-purple w-100">Buat Akun Dulu</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Interactive Tab Detail Persyaratan -->
            <div class="interactive-tab-box reveal">
                <div class="tab-buttons">
                    <button class="tab-btn active" data-tab="tab-prestasi">Syarat Prestasi</button>
                    <button class="tab-btn" data-tab="tab-afirmasi">Syarat Tidak Mampu</button>
                    <button class="tab-btn" data-tab="tab-talenta">Syarat Talenta Digital</button>
                </div>
                <div class="tab-content-area">
                    <div class="tab-pane active" id="tab-prestasi">
                        <h4><i class="ri-file-list-3-line"></i> Dokumen Wajib Beasiswa Prestasi:</h4>
                        <p>Kartu Tanda Mahasiswa (KTM), Transkrip Nilai terakhir berstempel akademik, maksimal 3 sertifikat kejuaraan 2 tahun terakhir, serta esai rencana kontribusi akademik.</p>
                    </div>
                    <div class="tab-pane" id="tab-afirmasi">
                        <h4><i class="ri-file-list-3-line"></i> Dokumen Wajib Beasiswa Peduli Pendidikan:</h4>
                        <p>KTM aktif, Kartu Keluarga (KK), Surat Keterangan Tidak Mampu (SKTM) dari kelurahan atau kartu KIP/PKH, slip gaji/surat penghasilan orang tua, dan foto kondisi tempat tinggal.</p>
                    </div>
                    <div class="tab-pane" id="tab-talenta">
                        <h4><i class="ri-file-list-3-line"></i> Dokumen Wajib Beasiswa Talenta Digital & Kepemimpinan:</h4>
                        <p>KTM aktif, Surat Keterangan Aktif Organisasi/Komunitas, tautan portofolio karya digital atau proyek sosial, serta surat rekomendasi dari dosen pembimbing.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= 2. BENEFIT BERGABUNG DI SIMBA ================= -->
    <section class="benefits-section" id="benefit">
        <div class="container">
            <div class="section-header text-center reveal">
                <span class="section-subtitle">KENAPA HARUS SIMBA?</span>
                <h2>Benefit Eksklusif Untuk Awardee</h2>
                <p>Lebih dari sekadar bantuan dana, SIMBA mempersiapkan kamu menjadi lulusan siap kerja dan berdaya saing global.</p>
            </div>

            <div class="benefits-grid">
                <div class="benefit-card reveal">
                    <div class="benefit-icon"><i class="ri-wallet-3-fill"></i></div>
                    <h3>Bantuan UKT & Uang Saku</h3>
                    <p>Cakupan biaya pendidikan hingga 100% ditambah tunjangan biaya hidup bulanan yang cair tepat waktu setiap semester.</p>
                </div>

                <div class="benefit-card reveal">
                    <div class="benefit-icon"><i class="ri-macbook-fill"></i></div>
                    <h3>Tunjangan Laptop & Riset</h3>
                    <p>Fasilitas dana penunjang perangkat belajar, pembelian buku referensi, hingga pendanaan tugas akhir/skripsi.</p>
                </div>

                <div class="benefit-card reveal">
                    <div class="benefit-icon"><i class="ri-team-fill"></i></div>
                    <h3>Mentoring & Bootcamp</h3>
                    <p>Akses gratis ke kelas pengembangan skill (UI/UX, Data, Public Speaking) langsung bersama mentor profesional.</p>
                </div>

                <div class="benefit-card reveal">
                    <div class="benefit-icon"><i class="ri-briefcase-4-fill"></i></div>
                    <h3>Jalur Prioritas Magang</h3>
                    <p>Koneksi langsung ke puluhan perusahaan mitra nasional dan multinasional untuk program magang bersertifikat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= 3. TOTAL AWARDEE & STATISTIK (DARK PURPLE WAVE) ================= -->
    <section class="stats-section" id="statistik">
        <div class="wave-top">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path d="M0,32L80,48C160,64,320,96,480,96C640,96,800,64,960,48C1120,32,1280,32,1360,32L1440,32L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
            </svg>
        </div>

        <div class="container stats-wrapper">
            <div class="stats-header text-center reveal">
                <span class="pill-tag-dark">JEJAK DAMPAK NYATA</span>
                <h2>Ribuan Mahasiswa Telah Merasakan Manfaatnya</h2>
                <p>Bergabunglah bersama komunitas penerima beasiswa SIMBA yang tersebar di berbagai universitas.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-item reveal">
                    <div class="stat-number" data-target="12450">0</div>
                    <div class="stat-suffix">+</div>
                    <p>Total Awardee Terbantu</p>
                </div>
                <div class="stat-item reveal">
                    <div class="stat-number" data-target="85">0</div>
                    <div class="stat-suffix">+</div>
                    <p>Mitra Penyedia Beasiswa</p>
                </div>
                <div class="stat-item reveal">
                    <div class="stat-number" data-target="48">0</div>
                    <div class="stat-suffix"> Miliar</div>
                    <p>Dana Pendidikan Tersalurkan</p>
                </div>
                <div class="stat-item reveal">
                    <div class="stat-number" data-target="98">0</div>
                    <div class="stat-suffix">%</div>
                    <p>Tingkat Kelulusan Tepat Waktu</p>
                </div>
            </div>

            <!-- Galeri Foto Awardee (Slot Foto) -->
            <div class="awardee-gallery reveal">
                <div class="gallery-card">
                    <img src="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&w=600&q=80" alt="Awardee Batch 1">
                    <div class="gallery-caption">
                        <strong>Awardee Batch 2025</strong>
                        <span>Gathering Nasional Penerima Beasiswa</span>
                    </div>
                </div>
                <div class="gallery-card">
                    <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop&w=600&q=80" alt="Workshop SIMBA">
                    <div class="gallery-caption">
                        <strong>SIMBA Leadership Camp</strong>
                        <span>Pelatihan Kepemimpinan & Inovasi</span>
                    </div>
                </div>
                <div class="gallery-card">
                    <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=600&q=80" alt="Mentoring Karir">
                    <div class="gallery-caption">
                        <strong>Tech & Career Mentoring</strong>
                        <span>Sesi Bimbingan Bersama Praktisi</span>
                    </div>
                </div>
            </div>

            <!-- Banner CTA Bawah -->
            <div class="cta-box reveal">
                <div class="cta-text">
                    <h3>Siap Menjadi Awardee SIMBA Berikutnya?</h3>
                    <p>Buat akun sekarang dan lengkapi profil akademikmu sebelum pendaftaran ditutup.</p>
                </div>
                <a href="pages/register.php" class="btn btn-orange btn-lg">Buat Akun Gratis <i class="ri-arrow-right-line"></i></a>
            </div>
        </div>
    </section>

    <!-- ================= 5. FOOTER ================= -->
    <footer class="footer">
        <div class="container footer-grid">
            <div class="footer-brand">
                <a href="index.php" class="brand footer-logo">
                    <div class="brand-icon"><img src="assets/img/logo.jpeg" alt="Logo SIMBA"></div>
                    <span>SIMBA</span>
                </a>
                <p>
                    Sistem Informasi Manajemen Beasiswa — Mewujudkan akses pendidikan tinggi yang merata, transparan, dan berdaya saing bagi generasi muda Indonesia.
                </p>
                <div class="social-links">
                    <a href="#" aria-label="Instagram"><i class="ri-instagram-line"></i></a>
                    <a href="#" aria-label="TikTok"><i class="ri-tiktok-fill"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="ri-linkedin-box-fill"></i></a>
                    <a href="#" aria-label="YouTube"><i class="ri-youtube-fill"></i></a>
                </div>
            </div>

            <div class="footer-links">
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="#tentang">Tentang SIMBA</a></li>
                    <li><a href="#jenis-beasiswa">Program Beasiswa</a></li>
                    <li><a href="#benefit">Benefit Awardee</a></li>
                    <li><a href="#statistik">Statistik Dampak</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Akses Cepat</h4>
                <ul>
                    <li><a href="pages/login.php">Login Pendaftar</a></li>
                    <li><a href="pages/register.php">Registrasi Akun Baru</a></li>
                    <li><a href="pages/login.php">Portal Admin Verifikator</a></li>
                    <li><a href="#">Panduan Pendaftaran</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <h4>Hubungi Kami</h4>
                <ul>
                    <li><i class="ri-map-pin-2-fill"></i> Jl. Pawiyatan Luhur IV No.1, Bendan Duwur, Semarang</li>
                    <li><i class="ri-phone-fill"></i> (024) 8441555 / +62 812-3456-7890</li>
                    <li><i class="ri-mail-send-fill"></i> halo@simba-beasiswa.ac.id</li>
                    <li><i class="ri-instagram-fill"></i> @simba.beasiswa</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2026 SIMBA — Sistem Informasi Manajemen Beasiswa. Dikembangkan oleh Tim Proyek SIMBA.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>
</body>
</html>