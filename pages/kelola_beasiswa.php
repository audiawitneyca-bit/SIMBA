<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$data_beasiswa = mysqli_query($conn, "SELECT * FROM beasiswa ORDER BY id_beasiswa DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Beasiswa - SIMBA</title>
</head>
<body>
    <h2>Kelola Data Beasiswa</h2>
    <p><a href="dashboard_admin.php">← Kembali ke Panel Admin</a></p>
    <hr>

    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <h3>Tambah Program Beasiswa Baru</h3>
    <form action="../admin/proses_beasiswa.php" method="POST">
        <label>Nama Beasiswa:</label><br>
        <input type="text" name="nama_beasiswa" required><br><br>

        <label>Deskripsi / Syarat:</label><br>
        <textarea name="deskripsi" rows="3" cols="40" required></textarea><br><br>

        <label>Kuota Penerima:</label><br>
        <input type="number" name="kuota" min="1" required><br><br>

        <label>Batas Pendaftaran (Deadline):</label><br>
        <input type="date" name="deadline" required><br><br>

        <button type="submit" name="tambah">Simpan Beasiswa</button>
    </form>

    <hr>
    <h3>Daftar Beasiswa Aktif</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama Beasiswa</th>
            <th>Deskripsi</th>
            <th>Kuota</th>
            <th>Deadline</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($data_beasiswa)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama_beasiswa']) ?></td>
            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
            <td><?= $row['kuota'] ?></td>
            <td><?= $row['deadline'] ?></td>
            <td>
                <a href="../admin/proses_beasiswa.php?hapus=<?= $row['id_beasiswa'] ?>" 
                   onclick="return confirm('Yakin hapus beasiswa ini?')" 
                   style="color: red;">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>