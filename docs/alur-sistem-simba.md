# Alur Sistem & Use Case - SIMBA (Sistem Informasi Manajemen Beasiswa)

**Disusun oleh:** Febrianti Arini (24.N1.0007) — System Analyst & Quality Assurance

## 1. Flowchart Alur Sistem Utama

```mermaid
flowchart TD
    A([Mulai]) --> B[Registrasi / Login Akun]
    B --> C{Role Pengguna?}
    C -- Pendaftar --> D[Lengkapi Profil Akademik]
    D --> E[Eksplorasi & Filter Beasiswa]
    E --> F[Pilih Program & Isi Formulir]
    F --> G[Upload Dokumen Syarat: KTM, Transkrip]
    G --> H[Kirim Lamaran]
    
    C -- Admin --> I[Terima Notifikasi Pendaftaran Masuk]
    H --> I
    I --> J[Tinjau Kelengkapan Berkas]
    J --> K{Keputusan Verifikasi?}
    K -- Lolos --> L[Update Status: Lolos]
    K -- Revisi --> M[Update Status: Perlu Revisi]
    K -- Tidak Lolos --> N[Update Status: Tidak Lolos]
    
    L --> O[Pendaftar Melihat Hasil & Notifikasi di Dasbor]
    M --> O
    N --> O
    O --> P([Selesai])