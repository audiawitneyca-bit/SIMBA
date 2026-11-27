<?php
// auth/google_callback.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/koneksi.php';
require_once '../config/google_oauth.php';

// 1. Validasi Kode Otorisasi dari Google
if (!isset($_GET['code'])) {
    header("Location: ../pages/login.php?error=" . urlencode("Login Google dibatalkan atau tidak ada kode otorisasi."));
    exit;
}

// Cek validasi state jika session tersedia
if (isset($_SESSION['oauth_state']) && isset($_GET['state']) && $_GET['state'] !== $_SESSION['oauth_state']) {
    header("Location: ../pages/login.php?error=" . urlencode("Sesi login Google kedaluwarsa. Silakan coba klik tombol login lagi."));
    exit;
}
unset($_SESSION['oauth_state']);

$code = $_GET['code'];

// 2. Fungsi Helper HTTP POST & GET menggunakan PHP Stream (Aman dari crash macOS MAMP fork)
function send_http_post($url, $data) {
    $content = http_build_query($data);
    $options = [
        'http' => [
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
                         "Content-Length: " . strlen($content) . "\r\n" .
                         "User-Agent: SIMBA-PHP\r\n",
            'method'  => 'POST',
            'content' => $content,
            'ignore_errors' => true,
            'timeout' => 15
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false
        ]
    ];
    $context = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);
    
    // Fallback ke cURL jika file_get_contents dinonaktifkan
    if ($response === false && function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $response = curl_exec($ch);
        curl_close($ch);
    }
    return $response;
}

function send_http_get($url, $accessToken) {
    $options = [
        'http' => [
            'header'  => "Authorization: Bearer " . $accessToken . "\r\n" .
                         "User-Agent: SIMBA-PHP\r\n",
            'method'  => 'GET',
            'ignore_errors' => true,
            'timeout' => 15
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false
        ]
    ];
    $context = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);

    // Fallback ke cURL
    if ($response === false && function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $accessToken", "User-Agent: SIMBA-PHP"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $response = curl_exec($ch);
        curl_close($ch);
    }
    return $response;
}

// 3. Tukar Code dengan Access Token
$post_fields = [
    'code'          => $code,
    'client_id'     => GOOGLE_CLIENT_ID,
    'client_secret' => GOOGLE_CLIENT_SECRET,
    'redirect_uri'  => GOOGLE_REDIRECT_URI,
    'grant_type'    => 'authorization_code'
];

$token_raw = send_http_post(GOOGLE_TOKEN_URL, $post_fields);
$token_data = json_decode($token_raw, true);

if (!isset($token_data['access_token'])) {
    $error_detail = $token_data['error_description'] ?? ($token_data['error'] ?? 'Gagal memperoleh access token dari Google.');
    header("Location: ../pages/login.php?error=" . urlencode($error_detail));
    exit;
}

// 4. Ambil Profil Pengguna dari Google
$profile_raw = send_http_get(GOOGLE_USERINFO_URL, $token_data['access_token']);
$user_google = json_decode($profile_raw, true);

$google_id = $user_google['sub'] ?? null;
$email     = $user_google['email'] ?? null;
$nama      = $user_google['name'] ?? 'Pendaftar Google';

if (!$email) {
    header("Location: ../pages/login.php?error=" . urlencode("Email Google tidak dapat diakses."));
    exit;
}

// 5. Cek struktur tabel users (apakah sudah ada kolom google_id)
$check_col = mysqli_query($conn, "SHOW COLUMNS FROM users LIKE 'google_id'");
$has_google_id = ($check_col && mysqli_num_rows($check_col) > 0);

// Cek apakah user sudah terdaftar di database SIMBA
$stmt = mysqli_prepare($conn, "SELECT id_user, nama_lengkap, role FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if ($user) {
    // Pengguna sudah ada: update google_id jika belum tersimpan
    if ($has_google_id && $google_id) {
        $update = mysqli_prepare($conn, "UPDATE users SET google_id = ? WHERE id_user = ?");
        mysqli_stmt_bind_param($update, "si", $google_id, $user['id_user']);
        mysqli_stmt_execute($update);
    }
    $id_user = $user['id_user'];
    $role    = $user['role'];
    $nama    = $user['nama_lengkap'];
} else {
    // Pengguna baru: daftarkan akun baru otomatis sebagai 'pendaftar'
    $dummy_pass = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);

    if ($has_google_id) {
        $insert = mysqli_prepare($conn, "INSERT INTO users (nama_lengkap, email, password, google_id, role) VALUES (?, ?, ?, ?, 'pendaftar')");
        mysqli_stmt_bind_param($insert, "ssss", $nama, $email, $dummy_pass, $google_id);
    } else {
        $insert = mysqli_prepare($conn, "INSERT INTO users (nama_lengkap, email, password, role) VALUES (?, ?, ?, 'pendaftar')");
        mysqli_stmt_bind_param($insert, "sss", $nama, $email, $dummy_pass);
    }

    if (!mysqli_stmt_execute($insert)) {
        header("Location: ../pages/register.php?error=" . urlencode("Gagal mendaftarkan akun baru melalui Google ke database."));
        exit;
    }

    $id_user = mysqli_insert_id($conn);
    $role    = 'pendaftar';
}

// 6. Inisialisasi Session Login SIMBA
$_SESSION['id_user'] = $id_user;
$_SESSION['nama']    = $nama;
$_SESSION['role']    = $role;

// 7. Arahkan pengguna ke halaman dasbor
if ($role === 'admin') {
    header("Location: ../pages/dashboard_admin.php");
} else {
    header("Location: ../pages/dashboard_pendaftar.php");
}
exit;
?>
