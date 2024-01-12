<?php
include_once("../include/page_start.php");
include_once("../include/dbcon.php");
include_once("../include/session_admin.php");

if ($_GET['num'] == "") {
    echo "<script>alert('잘못된 접근입니다........'); history.back();</script>";
    exit;
} else {
    $num = $_GET['num'];
    $sql = "UPDATE member SET del_check = 1 WHERE num = :num";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':num', $num, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<script>alert('회원 삭제가 완료되었습니다.'); location.href='./list_member.php';</script>";
}
?>