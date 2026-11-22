<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$pendaftar = mysqli_query($conn, "
    SELECT p.id_pendaftaran, u.nama_lengkap, u.email, b.nama_beasiswa, p.ipk, p.status
    FROM pendaftaran p
    JOIN users u ON p.id_user = u.id_user
    JOIN beasiswa b ON p.id_beasiswa = b.id_beasiswa
    ORDER BY p.id_pendaftaran DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Pendaftar - SIMBA</title>
</head>
<body>
    <h2>Verifikasi Pendaftaran Mahasiswa</h2>
    <p><a href="dashboard_admin.php">← Kembali ke Panel Admin</a></p>
    <hr>

    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama Mahasiswa</th>
            <th>Email</th>
            <th>Beasiswa</th>
            <th>IPK</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($pendaftar)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['nama_beasiswa']) ?></td>
            <td><?= $row['ipk'] ?></td>
            <td><b><?= htmlspecialchars($row['status']) ?></b></td>
            <td>
                <a href="../admin/proses_verifikasi.php?id=<?= $row['id_pendaftaran'] ?>&status=Diterima" style="color: green;">Terima</a> | 
                <a href="../admin/proses_verifikasi.php?id=<?= $row['id_pendaftaran'] ?>&status=Ditolak" style="color: red;">Tolak</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>