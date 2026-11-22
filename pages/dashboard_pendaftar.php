<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'pendaftar') {
    header("Location: login.php");
    exit;
}

$id_user  = $_SESSION['id_user'];
$beasiswa = mysqli_query($conn, "SELECT * FROM beasiswa ORDER BY id_beasiswa DESC");
$riwayat  = mysqli_query($conn, "
    SELECT p.*, b.nama_beasiswa 
    FROM pendaftaran p 
    JOIN beasiswa b ON p.id_beasiswa = b.id_beasiswa 
    WHERE p.id_user = $id_user 
    ORDER BY p.id_pendaftaran DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pendaftar - SIMBA</title>
</head>
<body>
    <h2>Halo, <?= htmlspecialchars($_SESSION['nama']) ?>!</h2>
    <p><a href="../auth/logout.php" style="color: red;">Logout</a></p>
    <hr>

    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <h3>Daftar Beasiswa Tersedia</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Nama Beasiswa</th>
            <th>Deskripsi</th>
            <th>Kuota</th>
            <th>Deadline</th>
            <th>Daftar</th>
        </tr>
        <?php while ($b = mysqli_fetch_assoc($beasiswa)): ?>
        <tr>
            <td><?= htmlspecialchars($b['nama_beasiswa']) ?></td>
            <td><?= htmlspecialchars($b['deskripsi']) ?></td>
            <td><?= $b['kuota'] ?></td>
            <td><?= $b['deadline'] ?></td>
            <td>
                <form action="../pendaftar/proses_daftar.php" method="POST">
                    <input type="hidden" name="id_beasiswa" value="<?= $b['id_beasiswa'] ?>">
                    <input type="number" step="0.01" min="0" max="4" name="ipk" placeholder="IPK (cth: 3.75)" required style="width: 110px;">
                    <button type="submit">Daftar</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <hr>
    <h3>Status Pendaftaran Saya</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Nama Beasiswa</th>
            <th>IPK</th>
            <th>Status</th>
        </tr>
        <?php while ($r = mysqli_fetch_assoc($riwayat)): ?>
        <tr>
            <td><?= htmlspecialchars($r['nama_beasiswa']) ?></td>
            <td><?= $r['ipk'] ?></td>
            <td><b><?= htmlspecialchars($r['status']) ?></b></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>