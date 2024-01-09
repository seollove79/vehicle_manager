<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php
// POST 데이터 처리
$id = $_POST["id"];
$pw = $_POST["pw"];
$previousPage = $_POST["previous_page"];

// id와 pw가 일치하는 데이터가 있는지 확인
$sqlStr = "SELECT * FROM member WHERE mem_id = :id AND mem_password = :pw";

$stmt = $conn->prepare($sqlStr);
$stmt->bindParam(":id", $id);
$stmt->bindParam(":pw", $pw);
$stmt->execute();


$sqlStr = "SELECT * FROM member WHERE mem_id = :id AND mem_password = :pw";
$stmt = $conn->prepare($sqlStr);
$stmt->bindParam(':id', $id, PDO::PARAM_STR);
$stmt->bindParam(':pw', $pw, PDO::PARAM_STR);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $mem_name = $row['mem_name'];
    $mem_num = $row['num'];
    $mem_level = $row['mem_level'];

    $_SESSION["mem_num"] = $mem_num;
    $_SESSION["mem_name"] = $mem_name;
    $_SESSION["mem_level"] = $mem_level;

    echo "<script>alert('로그인되었습니다.');location.href='" . $previousPage . "';</script>";

} else {
    // 페이지 리다이렉트
    echo "<script>alert('아이디 또는 비밀번호가 일치하지 않습니다.');history.back();</script>";
}

// DB 연결 종료
$conn = null;
?>