<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php include_once("../include/session.php"); ?>

<?php
if (!isset($_GET['sel_num'])) {
  die("잘못된 접근입니다.");
}

$sel_num = $_GET['sel_num'];

try {
  // Prepare SQL query
  $sql = "UPDATE vehicles SET del_check = 1 WHERE num in ($sel_num)";
  $stmt = $conn->prepare($sql);

  // Execute the update
  $stmt->execute();

  echo "<script>alert('기체정보가 삭제되었습니다.'); window.location.href = 'list.php';</script>";
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  echo "<script>alert('오류가 발생했습니다.');</script>";
}

// Close connection
$conn = null;
?>
