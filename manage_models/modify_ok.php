<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>

<?php
if (!isset($_POST['num'])) {
  die("잘못된 접근입니다.");
}

try {
  // Prepare SQL query
  $sql = "UPDATE models SET model_name = :model_name WHERE num = :num";
  $stmt = $conn->prepare($sql);

  // Bind POST data to parameters
  $stmt->bindParam(':model_name', $_POST['model_name'], PDO::PARAM_STR);
  $stmt->bindParam(':num', $_POST['num'], PDO::PARAM_INT);

  // Execute the update
  $stmt->execute();

  echo "<script>alert('모델이 수정되었습니다.'); window.location.href = 'list.php';</script>";
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  echo "<script>alert('오류가 발생했습니다.');</script>";
}

// Close connection
$conn = null;
?>
