<?php 
include_once("../include/page_start.php");
include_once("../include/session.php");

// 세션 삭제
unset($_SESSION["mem_num"]);
unset($_SESSION["mem_name"]);
unset($_SESSION["mem_level"]);

// 페이지 리다이렉트
echo "<script>alert('로그아웃되었습니다.');location.href='/index.php';</script>";
?>