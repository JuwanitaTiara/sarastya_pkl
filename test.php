<?php
// Izinkan koneksi dari luar (misalnya dari emulator)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Ambil data JSON dari MAUI
$data = json_decode(file_get_contents("php://input"));

// Cek apakah data lengkap
if (!isset($data->username) || !isset($data->password)) {
    echo json_encode(["message" => "Data tidak lengkap."]);
    exit;
}

$username = $data->username;
$password = $data->password;

// Koneksi ke database PostgreSQL
$host = "localhost";
$dbname = "PostgreeSQL";
$user = "postgres";
$pass = "admin123";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$pass");

if (!$conn) {
    echo json_encode(["message" => "Koneksi ke database gagal."]);
    exit;
}

// Simpan ke tabel (ganti nama_tabel sesuai tabel kamu)
$query = "INSERT INTO nama_tabel (username, password) VALUES ($1, $2)";
$result = pg_query_params($conn, $query, [$username, $password]);

if ($result) {
    echo json_encode(["message" => "Registrasi berhasil!"]);
} else {
    echo json_encode(["message" => "Gagal menyimpan data."]);
}

pg_close($conn);
?>
