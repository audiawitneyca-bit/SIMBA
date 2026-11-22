-- 1. Tabel Users (Menyimpan akun Admin & Pendaftar beserta profil akademik)
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('pendaftar', 'admin') DEFAULT 'pendaftar',
    nim VARCHAR(30) NULL,
    jenjang VARCHAR(20) NULL,
    jurusan VARCHAR(100) NULL,
    ipk DECIMAL(3,2) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tabel Beasiswa (Untuk fitur eksplorasi & filter jenjang, jurusan, kuota)
CREATE TABLE beasiswa (
    id_beasiswa INT AUTO_INCREMENT PRIMARY KEY,
    nama_beasiswa VARCHAR(150) NOT NULL,
    penyelenggara VARCHAR(100) NOT NULL,
    deskripsi TEXT NOT NULL,
    jenjang VARCHAR(50) NOT NULL,
    jurusan VARCHAR(100) NOT NULL,
    kuota INT NOT NULL,
    batas_waktu DATE NOT NULL,
    status ENUM('aktif', 'tutup') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabel Pendaftaran (Untuk fitur apply, upload dokumen, verifikasi & status)
CREATE TABLE pendaftaran (
    id_pendaftaran INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_beasiswa INT NOT NULL,
    alasan_mendaftar TEXT NOT NULL,
    file_ktm VARCHAR(255) NOT NULL,
    file_transkrip VARCHAR(255) NOT NULL,
    status ENUM('menunggu', 'revisi', 'diterima', 'ditolak') DEFAULT 'menunggu',
    catatan_admin TEXT NULL,
    tanggal_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_beasiswa) REFERENCES beasiswa(id_beasiswa) ON DELETE CASCADE
);