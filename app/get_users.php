<?php
header('Content-Type: application/json; charset=utf-8');

$servername = "sql-service";
$username   = "root";
$password   = "P@ssw0rd";
$dbname     = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . $conn->connect_error
    ]);
    exit;
}

$sql = "SELECT id, username, created_at FROM users ORDER BY id DESC";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        "success" => false,
        "message" => "ดึงข้อมูลไม่สำเร็จ: " . $conn->error
    ]);
    $conn->close();
    exit;
}

$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $users
]);

$conn->close();
?>