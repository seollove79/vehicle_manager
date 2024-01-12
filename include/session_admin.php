<?php
include_once("../include/page_start.php");
if (!isset($_SESSION["mem_name"])) {
    echo "<script>alert('로그인이 필요합니다.');location.href='/member/login.php';</script>";
}

if ($_SESSION["mem_level"] == 100 || $_SESSION["mem_level"] == 999) {
} else {
    echo "<script>alert('관리자만 접근할 수 있습니다.');history.back();</script>";
}
?>