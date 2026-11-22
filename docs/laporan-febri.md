# Laporan Kegiatan Proyek Website SIMBA

**Nama:** Febrianti Arini  
**NIM:** 24.N1.0007  
**Peran:** System Analyst & Quality Assurance  
**GitHub:** fourleafclover605 (`branch: qa-docs(Febri)`)  

---

### Rincian Kegiatan yang Sudah Dikerjakan

**1. Perencanaan & Analisis Alur Sistem**
* Merumuskan gambaran umum, tujuan sistem, serta kebutuhan fungsional website SIMBA (Sistem Informasi Manajemen Beasiswa).
* Menyusun 5 alur utama penggunaan aplikasi mulai dari registrasi akun mahasiswa, pencarian/filter beasiswa, pengisian form serta unggah syarat (KTM dan transkrip), verifikasi berkas oleh admin, hingga pengumuman hasil seleksi.
* Mendokumentasikan diagram alur sistem dan daftar *use case* pengguna di dalam file `docs/alur-sistem-simba.md`.

**2. Setup Repositori GitHub & Penyusunan Standar Testing**
* Melakukan *clone* repositori kolaborasi `SIMBA` melalui GitHub Desktop dan menyiapkan *branch* terpisah (`qa-docs(Febri)`) agar tidak bentrok dengan pengerjaan *frontend* dan *backend*.
* Menyusun tabel skenario pengujian (*test case* `TC-01` sampai `TC-07`) di file `docs/qa-test-cases.md` untuk mengecek fungsi registrasi, login, filter beasiswa, unggah dokumen, serta pembaruan status verifikasi admin di localhost.

**3. Rencana Tindak Lanjut**
* Melakukan pengujian langsung di browser lokal setelah fitur halaman dari Grace dan database/backend dari Witney digabungkan (*merge*) ke *branch* `main`, serta mencatat temuan *bug* atau tampilan yang belum sesuai melalui fitur *Issues* di GitHub.