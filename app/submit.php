<?php
$servername = "mysql.default.svc.cluster.local";  // Service name ของ MySQL ใน Kubernetes
$username = "root";  // ใช้เป็น root user
$password = "P@ssw0rd";  // รหัสผ่านที่ตั้งไว้ใน StatefulSet
$dbname = "mydatabase";  // ชื่อฐานข้อมูลที่ต้องการใช้

// เชื่อมต่อกับ MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลจาก form
$user_input = $_POST['username'];

// Insert ข้อมูลลงในฐานข้อมูล
$sql = "INSERT INTO users (username) VALUES ('$user_input')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>