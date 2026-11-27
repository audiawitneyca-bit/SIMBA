<?php
// config/koneksi.php

// Nonaktifkan exception otomatis MySQLi agar dapat mencoba fallback antar lingkungan (MAMP, Laragon, XAMPP) tanpa fatal error di PHP 8.1+
mysqli_report(MYSQLI_REPORT_OFF);

$db = "db_simba";

// Profil koneksi database untuk berbagai lingkungan pengembangan tim
$db_profiles = [
    // 1. MAMP macOS (Witney: port 8889, user 'root', pass 'root')
    [
        'host'   => 'localhost',
        'user'   => 'root',
        'pass'   => 'root',
        'port'   => 8889,
        'socket' => '/Applications/MAMP/tmp/mysql/mysql.sock'
    ],
    [
        'host'   => '127.0.0.1',
        'user'   => 'root',
        'pass'   => 'root',
        'port'   => 8889,
        'socket' => null
    ],

    // 2. Laragon & XAMPP Windows (Teman: port 3306, user 'root', password kosong)
    [
        'host'   => 'localhost',
        'user'   => 'root',
        'pass'   => '',
        'port'   => 3306,
        'socket' => null
    ],
    [
        'host'   => '127.0.0.1',
        'user'   => 'root',
        'pass'   => '',
        'port'   => 3306,
        'socket' => null
    ],

    // 3. MySQL Standar / Homebrew Mac / XAMPP Mac (port 3306, pass 'root')
    [
        'host'   => 'localhost',
        'user'   => 'root',
        'pass'   => 'root',
        'port'   => 3306,
        'socket' => null
    ],
    [
        'host'   => '127.0.0.1',
        'user'   => 'root',
        'pass'   => 'root',
        'port'   => 3306,
        'socket' => null
    ],

    // 4. Port Alternatif (MariaDB / Laragon port 3307)
    [
        'host'   => 'localhost',
        'user'   => 'root',
        'pass'   => '',
        'port'   => 3307,
        'socket' => null
    ],
    [
        'host'   => '127.0.0.1',
        'user'   => 'root',
        'pass'   => '',
        'port'   => 3307,
        'socket' => null
    ]
];

$conn = false;

// Cari dan hubungkan ke MySQL yang aktif secara otomatis
foreach ($db_profiles as $cfg) {
    if (!empty($cfg['socket']) && file_exists($cfg['socket'])) {
        $conn = @mysqli_connect($cfg['host'], $cfg['user'], $cfg['pass'], $db, $cfg['port'], $cfg['socket']);
    } else {
        $conn = @mysqli_connect($cfg['host'], $cfg['user'], $cfg['pass'], $db, $cfg['port']);
    }

    if ($conn) {
        break; // Sukses terhubung!
    }
}

if (!$conn) {
    die("Koneksi database gagal. Pastikan MySQL sudah dinyalakan (MAMP / Laragon / XAMPP) dan database '<strong>" . htmlspecialchars($db) . "</strong>' sudah di-import ke phpMyAdmin.");
}
?>
