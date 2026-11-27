<?php
// auth/google_login.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/google_oauth.php';

// Pastikan Client ID sudah diisi
if (GOOGLE_CLIENT_ID === 'MASUKKAN_CLIENT_ID_ANDA_DI_SINI') {
    die("Error: Google Client ID belum dikonfigurasi di config/google_oauth.php");
}

// Generate state acak untuk proteksi CSRF
$_SESSION['oauth_state'] = bin2hex(random_bytes(16));

$params = [
    'client_id'     => GOOGLE_CLIENT_ID,
    'redirect_uri'  => GOOGLE_REDIRECT_URI,
    'response_type' => 'code',
    'scope'         => 'openid email profile',
    'state'         => $_SESSION['oauth_state'],
    'prompt'        => 'select_account'
];

$auth_url = GOOGLE_AUTH_URL . '?' . http_build_query($params);
header('Location: ' . $auth_url);
exit;
?>
