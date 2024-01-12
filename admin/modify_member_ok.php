<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php include_once("../include/session_admin.php"); ?>

<?php
if (!isset($_POST['num'])) {
  die("잘못된 접근입니다.");
}

try {
  // Prepare SQL query
  $sql = "UPDATE member SET mem_password = :mem_password, mem_level=:mem_level WHERE num = :num";
  $stmt = $conn->prepare($sql);

  // Bind POST data to parameters
  $stmt->bindParam(':mem_password', $_POST['mem_password'], PDO::PARAM_STR);
  $stmt->bindParam(':mem_level', $_POST['mem_level'], PDO::PARAM_INT);
  $stmt->bindParam(':num', $_POST['num'], PDO::PARAM_INT);

  // Execute the update
  $stmt->execute();

  echo "<script>alert('회원정보가 수정되었습니다.'); window.location.href = 'list_member.php';</script>";
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  echo "<script>alert('오류가 발생했습니다.');</script>";
}

// Close connection
$conn = null;
?>
