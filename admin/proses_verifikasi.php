<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit;
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id     = (int) $_GET['id'];
    $status = $_GET['status'];

    // Validasi nilai status yang diperbolehkan
    if (in_array($status, ['Diterima', 'Ditolak'])) {
        $stmt = mysqli_prepare($conn, "UPDATE pendaftaran SET status = ? WHERE id_pendaftaran = ?");
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        mysqli_stmt_execute($stmt);
    }
}

header("Location: ../pages/verifikasi_pendaftar.php?success=Status berhasil diperbarui");
exit;
?>