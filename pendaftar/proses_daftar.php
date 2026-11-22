<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'pendaftar') {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user     = $_SESSION['id_user'];
    $id_beasiswa = (int) $_POST['id_beasiswa'];
    $ipk         = (float) $_POST['ipk'];

    // Cek agar tidak mendaftar dua kali di beasiswa yang sama
    $cek = mysqli_prepare($conn, "SELECT id_pendaftaran FROM pendaftaran WHERE id_user = ? AND id_beasiswa = ?");
    mysqli_stmt_bind_param($cek, "ii", $id_user, $id_beasiswa);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) > 0) {
        header("Location: ../pages/dashboard_pendaftar.php?error=Kamu sudah mendaftar di beasiswa ini");
        exit;
    }

    // Simpan pendaftaran dengan status awal 'Menunggu'
    $stmt = mysqli_prepare($conn, "INSERT INTO pendaftaran (id_user, id_beasiswa, ipk, status) VALUES (?, ?, ?, 'Menunggu')");
    mysqli_stmt_bind_param($stmt, "iid", $id_user, $id_beasiswa, $ipk);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../pages/dashboard_pendaftar.php?success=Pendaftaran berhasil dikirim");
    } else {
        header("Location: ../pages/dashboard_pendaftar.php?error=Gagal mengirim pendaftaran");
    }
    exit;
}
?>