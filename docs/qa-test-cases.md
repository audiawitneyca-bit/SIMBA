# Skenario Pengujian Sistem (QA Test Cases) - SIMBA

**QA Tester:** Febrianti Arini (24.N1.0007)  
**Environment:** Localhost (Laragon / PHP / MySQL `db_simba`)

| ID Test | Modul | Skenario Pengujian | Langkah Pengujian | Hasil yang Diharapkan | Status | Catatan Bug / Issue |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **TC-01** | Autentikasi | Registrasi akun pendaftar baru | Buka halaman Register -> isi nama, NIM, email, password valid -> klik Daftar | Data masuk ke tabel `users` di `db_simba` dan diarahkan ke halaman Login | Belum Diuji | - |
| **TC-02** | Autentikasi | Login gagal (password salah) | Masukkan email terdaftar dengan password salah -> klik Login | Sistem menolak login dan menampilkan pesan error validasi | Belum Diuji | - |
| **TC-03** | Eksplorasi | Filter pencarian beasiswa | Buka katalog beasiswa -> pilih filter jenjang/jurusan -> klik Cari | Daftar program beasiswa tersaring sesuai kriteria yang dipilih | Belum Diuji | - |
| **TC-04** | Pendaftaran | Submit form & upload berkas valid | Pilih beasiswa -> lengkapi form -> upload KTM & Transkrip (`.pdf` < 2MB) -> Submit | File tersimpan di folder uploads, data masuk ke `db_simba`, status `Menunggu Verifikasi` | Belum Diuji | - |
| **TC-05** | Pendaftaran | Validasi format file terlarang | Unggah file dengan ekstensi `.exe` atau ukuran melebihi batas maksimal | Sistem memblokir unggahan dan menampilkan peringatan format/ukuran file | Belum Diuji | - |
| **TC-06** | Verifikasi Admin | Ubah status seleksi pendaftar | Login sebagai Admin -> buka detail berkas pendaftar -> ubah status menjadi `Lolos` | Status di database diperbarui dan notifikasi langsung tampil di dasbor pendaftar | Belum Diuji | - |
| **TC-07** | UI / Responsivitas | Tampilan mobile & desktop | Buka seluruh halaman utama pada resolusi desktop (1366x768) dan layar mobile | Layout rapi, tidak ada tombol terpotong atau elemen tumpang tindih | Belum Diuji | - |