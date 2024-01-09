<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>

<?php
if (!isset($_GET['num'])) {
  die("잘못된 접근입니다.");
}

try {
  // Prepare SQL query
  $sql = "UPDATE models SET del_check = 1 WHERE num = :num";
  $stmt = $conn->prepare($sql);

  // Bind POST data to parameters
  $stmt->bindParam(':num', $_GET['num'], PDO::PARAM_INT);

  // Execute the update
  $stmt->execute();

  echo "<script>alert('모델이 삭제되었습니다.'); window.location.href = 'list.php';</script>";
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  echo "<script>alert('오류가 발생했습니다.');</script>";
}

// Close connection
$conn = null;
?>
