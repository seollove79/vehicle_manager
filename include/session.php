<?php
include_once("../include/page_start.php");
if (!isset($_SESSION["mem_name"])) {
    echo "<script>alert('로그인이 필요합니다.');location.href='/member/login.php';</script>";
}
?>