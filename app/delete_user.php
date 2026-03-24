<?php
header('Content-Type: application/json; charset=utf-8');

$servername = getenv('DB_HOST');
$username   = getenv('DB_USER');
$password   = getenv('DB_PASSWORD');
$dbname     = getenv('DB_NAME');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
    exit;
}

$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(["success" => false, "message" => "ID ไม่ถูกต้อง"]);
    exit;
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . $conn->connect_error]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");

if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Prepare statement ไม่สำเร็จ: " . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "ลบข้อมูลผู้ใช้สำเร็จ"]);
} else {
    echo json_encode(["success" => false, "message" => "ลบข้อมูลไม่สำเร็จ: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>