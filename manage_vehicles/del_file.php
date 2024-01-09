<?php
include_once("../include/page_start.php");
include_once("../include/dbcon.php");
include_once("../include/session.php");
// 첨부파일 테이블의 primari key 를 get으로 받아온다.
$num = $_GET['num'];
$category = $_GET['category'];

// 카테고리는 테이블명이다.
// 카테고리에 따라 첨부파일을 가지고 온다.
// 테이블에서 해당 첨부파일의 정보를 가져온다.
try {
    $sqlStr = "SELECT * FROM $category where num=:num";
    $stmt = $conn->prepare($sqlStr);
    $stmt->bindParam(':num', $num, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $filepath = $row['filepath'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// 파일을 삭제한다.
unlink($filepath);

// 테이블에서 해당 첨부파일의 정보를 삭제한다.
try {
    $sqlStr = "DELETE FROM $category where num=:num";
    $stmt = $conn->prepare($sqlStr);
    $stmt->bindParam(':num', $num, PDO::PARAM_INT);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// 삭제 후 이전 페이지로 돌아간다.
echo "<script>history.back();</script>";
?>