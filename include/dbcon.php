<?php
$servername = "localhost";
$username = "vehicle_manager"; // 실제 데이터베이스 사용자 이름으로 변경하세요.
$password = "prince@B612"; // 실제 데이터베이스 비밀번호로 변경하세요.
$dbname = "vehicle_manager";       // 사용중인 데이터베이스 이름으로 변경하세요.

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // 에러 모드를 예외로 설정
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>