<?php
session_start();
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - SIMBA</title>
</head>
<body>
    <h1>Panel Admin SIMBA</h1>
    <p>Halo, <b><?= htmlspecialchars($_SESSION['nama']) ?></b> (Role: Admin)</p>
    <hr>

    <h3>Menu Pengelolaan:</h3>
    <ul>
        <li><a href="#">Kelola Data Beasiswa</a> (Belum dibuat)</li>
        <li><a href="#">Verifikasi Pendaftaran Mahasiswa</a> (Belum dibuat)</li>
        <li><a href="../auth/logout.php" style="color: red;">Logout</a></li>
    </ul>
</body>
</html>