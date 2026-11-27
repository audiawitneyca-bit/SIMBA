<?php
$host = "localhost";
$user = "root";
$pass = "root"; // Password default MAMP di MacBook
$db   = "db_simba";
$port = 8889;   // Port MySQL default MAMP

// Coba koneksi default MAMP (MacBook: port 8889, pass 'root')
$conn = @mysqli_connect($host, $user, $pass, $db, $port);

// Jika gagal, coba fallback default XAMPP (Windows: port 3306, tanpa pass)
if (!$conn) {
    $conn = @mysqli_connect($host, "root", "", $db, 3306);
}

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
