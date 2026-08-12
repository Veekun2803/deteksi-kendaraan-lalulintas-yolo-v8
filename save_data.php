<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

// Konfigurasi Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "traffic_db";

$conn = new mysqli($host, $user, $pass, $db);

// Cek Koneksi
if ($conn->connect_error) {
    die(json_encode(["error" => "Koneksi Gagal"]));
}

// Tangkap Data dari JavaScript
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['type']) && isset($input['speed'])) {
    $type  = $conn->real_escape_with_string($input['type']);
    $speed = (float)$input['speed'];

    $sql = "INSERT INTO traffic_stats (vehicle_type, speed) VALUES ('$type', '$speed')";
    
    if ($conn->query($sql)) {
        echo json_encode(["status" => "Data Tersimpan"]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
}

$conn->close();
?>