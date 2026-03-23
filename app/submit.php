<?php
header('Content-Type: application/json; charset=utf-8');

$servername = getenv('DB_HOST');
$username   = getenv('DB_USER');
$password   = getenv('DB_PASSWORD');
$dbname     = getenv('DB_NAME');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed"
    ]);
    exit;
}

$user_input = trim($_POST['username'] ?? '');

if ($user_input === '') {
    echo json_encode([
        "success" => false,
        "message" => "กรุณากรอกชื่อผู้ใช้"
    ]);
    exit;
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . $conn->connect_error
    ]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO users (username) VALUES (?)");

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Prepare statement ไม่สำเร็จ: " . $conn->error
    ]);
    $conn->close();
    exit;
}

$stmt->bind_param("s", $user_input);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "บันทึกข้อมูลผู้ใช้สำเร็จ"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "บันทึกข้อมูลไม่สำเร็จ: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>