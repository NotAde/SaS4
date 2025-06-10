<?php
$url = "mysql://root:BJKXFPiMCggubZIMTEuINjPtlmKeXEbc@yamabiko.proxy.rlwy.net:16777/railway";

$parts = parse_url($url);
$host = $parts['host'];
$port = $parts['port'];
$user = $parts['user'];
$pass = $parts['pass'];
$db   = ltrim($parts['path'], '/');

// Tes apakah host dapat di-resolve
$resolved_ip = gethostbyname($host);
if ($resolved_ip === $host) {
    die("Gagal resolve host: $host");
}

$conn = mysqli_connect($host, $user, $pass, $db, $port);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
 k