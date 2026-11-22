<?php
session_start();
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'pendaftar') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pendaftar - SIMBA</title>
</head>
<body>
    <h2>Halo, <?= htmlspecialchars($_SESSION['nama']) ?>!</h2>
    <p>Kamu berhasil login sebagai <b>Pendaftar</b>.</p>
    <a href="../auth/logout.php">Logout</a>
</body>
</html>