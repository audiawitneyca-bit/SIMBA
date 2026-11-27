<?php
// config/google_oauth.php

// Muat konfigurasi kredensial lokal jika ada (untuk keamanan agar secret tidak ter-push ke GitHub publik)
if (file_exists(__DIR__ . '/google_oauth.local.php')) {
    require_once __DIR__ . '/google_oauth.local.php';
}

// Fallback default jika file lokal belum dibuat
if (!defined('GOOGLE_CLIENT_ID')) {
    define('GOOGLE_CLIENT_ID', 'MASUKKAN_CLIENT_ID_ANDA_DI_SINI');
}
if (!defined('GOOGLE_CLIENT_SECRET')) {
    define('GOOGLE_CLIENT_SECRET', 'MASUKKAN_CLIENT_SECRET_ANDA_DI_SINI');
}
if (!defined('GOOGLE_REDIRECT_URI')) {
    define('GOOGLE_REDIRECT_URI', 'http://localhost:8888/SIMBA/auth/google_callback.php');
}

// Endpoint OAuth 2.0 Google
define('GOOGLE_AUTH_URL', 'https://accounts.google.com/o/oauth2/v2/auth');
define('GOOGLE_TOKEN_URL', 'https://oauth2.googleapis.com/token');
define('GOOGLE_USERINFO_URL', 'https://www.googleapis.com/oauth2/v3/userinfo');
?>
