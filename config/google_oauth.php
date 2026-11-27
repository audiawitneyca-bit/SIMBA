<?php
// config/google_oauth.php

// 1. Membaca file konfigurasi lokal tim jika ada
if (file_exists(__DIR__ . '/google_oauth.local.php')) {
    require_once __DIR__ . '/google_oauth.local.php';
}

if (!defined('GOOGLE_CLIENT_ID')) {
    define('GOOGLE_CLIENT_ID', 'MASUKKAN_CLIENT_ID_ANDA_DI_SINI');
}
if (!defined('GOOGLE_CLIENT_SECRET')) {
    define('GOOGLE_CLIENT_SECRET', 'MASUKKAN_CLIENT_SECRET_ANDA_DI_SINI');
}

// 2. Deteksi Redirect URI secara Dinamis (Mendukung MAMP MacBook, Laragon Windows, XAMPP, dll.)
if (!defined('GOOGLE_REDIRECT_URI')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";
    $http_host = $_SERVER['HTTP_HOST'] ?? 'localhost:8888';

    // Cari direktori root proyek SIMBA dari SCRIPT_NAME saat ini
    $script_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    if (strpos($script_dir, '/auth') !== false || strpos($script_dir, '/pages') !== false) {
        $base_dir = preg_replace('/(\/auth|\/pages).*$/', '', $script_dir);
    } else {
        $base_dir = rtrim($script_dir, '/');
    }

    $dynamic_redirect_uri = $protocol . $http_host . ($base_dir ? $base_dir : '') . '/auth/google_callback.php';
    define('GOOGLE_REDIRECT_URI', $dynamic_redirect_uri);
}

// Endpoint OAuth 2.0 Google
define('GOOGLE_AUTH_URL', 'https://accounts.google.com/o/oauth2/v2/auth');
define('GOOGLE_TOKEN_URL', 'https://oauth2.googleapis.com/token');
define('GOOGLE_USERINFO_URL', 'https://www.googleapis.com/oauth2/v3/userinfo');
?>
