<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php include_once("../include/session.php"); ?>

<?php
$oldPassword = $_POST['old_password'];
$newPassword = $_POST['new_password'];

$sql = "SELECT * FROM member WHERE num = :num";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':num', $_SESSION['mem_num'], PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($oldPassword!=$row['mem_password']) {
  echo "<script>alert('기존 비밀번호가 일치하지 않습니다.'); history.back();</script>";
  exit;
}

try {
  // Prepare SQL query
  $sql = "UPDATE member SET mem_password = :mem_password WHERE num = :num";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':num', $_SESSION["mem_num"], PDO::PARAM_INT);
  $stmt->bindParam(':mem_password', $newPassword, PDO::PARAM_STR);

  // Execute the update
  $stmt->execute();

  echo "<script>alert('비밀번호가 수정되었습니다.'); window.location.href = '/';</script>";
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  echo "<script>alert('오류가 발생했습니다.');</script>";
}

// Close connection
$conn = null;
?>
