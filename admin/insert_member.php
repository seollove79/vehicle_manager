<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php include_once("../include/session.php"); ?>
<?php
try {

    $strSql = "SELECT * FROM member where mem_id = :mem_id";
    $stmt = $conn->prepare($strSql);
    $stmt->bindParam(':mem_id', $_POST['mem_id'], PDO::PARAM_STR);
    $stmt->execute();
    $total_records = $stmt->rowCount();

    if ($total_records > 0) {
        echo "<script>alert('이미 등록된 아이디입니다.'); window.location.href = 'write_member.php';</script>";
        exit;
    }

    // SQL 쿼리 준비
    $sql = "INSERT INTO member (mem_name, mem_id, mem_password, mem_level) VALUES (:mem_name, :mem_id, :mem_password, :mem_level)";

    // 쿼리 준비
    $stmt = $conn->prepare($sql);

    // POST로 넘어온 값을 변수에 할당 후 바인딩
    $stmt->bindParam(':mem_name', $_POST['mem_name'], PDO::PARAM_STR);
    $stmt->bindParam(':mem_id', $_POST['mem_id'], PDO::PARAM_STR);
    $stmt->bindParam(':mem_password', $_POST['mem_password'], PDO::PARAM_STR);
    $stmt->bindParam(':mem_level', $_POST['mem_level'], PDO::PARAM_INT);

    // 쿼리 실행
    $stmt->execute();
    echo "<script>alert('회원이 등록되었습니다.'); window.location.href = 'list_member.php';</script>";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    echo "<script>alert('오류가 발생했습니다.');</script>";
}

// 연결 닫기
$conn = null;
?>