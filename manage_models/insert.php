<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php
try {
    // SQL 쿼리 준비
    $sql = "INSERT INTO models (model_name, dtime) 
    VALUES (:model_name, NOW())";

    // 쿼리 준비
    $stmt = $conn->prepare($sql);

    // POST로 넘어온 값을 변수에 할당 후 바인딩
    $stmt->bindParam(':model_name', $_POST['model_name'], PDO::PARAM_STR);

    // 쿼리 실행
    $stmt->execute();
    echo "<script>alert('모델이 등록되었습니다.'); window.location.href = 'list.php';</script>";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    echo "<script>alert('오류가 발생했습니다.');</script>";
}

// 연결 닫기
$conn = null;
?>