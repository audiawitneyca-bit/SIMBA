<?php
session_start();
require_once '../config/koneksi.php';

// Proteksi hanya untuk admin
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit;
}

// 1. Proses Tambah Beasiswa
if (isset($_POST['tambah'])) {
    $nama_beasiswa = trim($_POST['nama_beasiswa']);
    $deskripsi     = trim($_POST['deskripsi']);
    $kuota         = (int) $_POST['kuota'];
    $deadline      = $_POST['deadline'];

    $stmt = mysqli_prepare($conn, "INSERT INTO beasiswa (nama_beasiswa, deskripsi, kuota, deadline) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssis", $nama_beasiswa, $deskripsi, $kuota, $deadline);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../pages/kelola_beasiswa.php?success=Beasiswa berhasil ditambahkan");
    } else {
        header("Location: ../pages/kelola_beasiswa.php?error=Gagal menambahkan beasiswa");
    }
    exit;
}

// 2. Proses Hapus Beasiswa
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    $stmt = mysqli_prepare($conn, "DELETE FROM beasiswa WHERE id_beasiswa = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../pages/kelola_beasiswa.php?success=Beasiswa berhasil dihapus");
    } else {
        header("Location: ../pages/kelola_beasiswa.php?error=Gagal menghapus beasiswa");
    }
    exit;
}
?>