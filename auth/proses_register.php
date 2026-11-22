<?php
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama_lengkap']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Cek apakah email sudah terdaftar
    $cek = mysqli_prepare($conn, "SELECT id_user FROM users WHERE email = ?");
    mysqli_stmt_bind_param($cek, "s", $email);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) > 0) {
        header("Location: ../pages/register.php?error=Email sudah terdaftar");
        exit;
    }

    // Enkripsi password dan simpan sebagai 'pendaftar'
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO users (nama_lengkap, email, password, role) VALUES (?, ?, ?, 'pendaftar')");
    mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $hash);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../pages/login.php?success=Registrasi berhasil, silakan login");
    } else {
        header("Location: ../pages/register.php?error=Gagal mendaftar");
    }
    exit;
}
?>