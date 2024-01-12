<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php include_once("../include/session_admin.php"); ?>
<?php
if ($_GET['num'] == "") {
    echo "<script>alert('잘못된 접근입니다........'); history.back();</script>";
    exit;
} else {
    $num = $_GET['num'];
    $sql = "SELECT * FROM member WHERE num = :num";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':num', $_GET['num'], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) == 0) {
        echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
        exit;
    }

    $memName = $result[0]['mem_name'];
    $memId = $result[0]['mem_id'];
    $memPassword = $result[0]['mem_password'];
    $memLevel = $result[0]['mem_level'];
}
?>
<!doctype html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITE_TITLE; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <?php include_once("../include/top_menu.php"); ?>
    <div class="container text-center" style="margin-top:30px;">
        <div class="row">
            <div class="col-2"><?php include_once("./left_menu.php"); ?></div>
            <div class="col-10">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-start" style="border-bottom:1px solid #c8c8c8;padding-bottom:10px;font-weight:bold;font-size:12pt;">회원 정보</div>
                    </div>
                    <div class="row">
                        <!-- 내용 시작 -->
                        <div class="col-12">
                            <form action="modify_member_ok.php" method="post" onsubmit="checkForm()" name="myform">
                                <input type="hidden" name="num" value="<?=$num?>">
                                <div class="container" style="margin-top:10px;margin-bottom:50px;">
                                    <div class="row align-items-center" style="margin-top:20px;">
                                        <div class="col-12 text-start">
                                            <span style="font-weight:bold;">이름</span>
                                            <input type="text" class="form-control mt-1" placeholder="이름" aria-label="이름" name="mem_name" value="<?=$memName?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row align-items-center" style="margin-top:20px;">
                                        <div class="col-12 text-start">
                                            <span style="font-weight:bold;">아이디</span>
                                            <input type="text" class="form-control mt-1" placeholder="아이디" aria-label="아이디" name="mem_id" value="<?=$memId?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row align-items-center" style="margin-top:20px;">
                                        <div class="col-12 text-start">
                                            <span style="font-weight:bold;">비밀번호</span>
                                            <input type="password" class="form-control mt-1" placeholder="비밀번호" aria-label="비밀번호" name="mem_password" value="<?=$memPassword?>">
                                        </div>
                                    </div>
                                    <div class="row align-items-center" style="margin-top:20px;">
                                        <div class="col-12 text-start">
                                            <span style="font-weight:bold;">회원레벨</span>
                                            <select class="form-select" name="mem_level">
                                                <option value="999" <?php if($memLevel==999) {?>selected<?php }?>>개발자</option>
                                                <option value="100" <?php if($memLevel==100) {?>selected<?php }?>>관리자</option>
                                                <option value="200" <?php if($memLevel==200) {?>selected<?php }?>>일반회원</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center" style="margin-top: 20px;">
                                        <div class="col-12 text-center">
                                            <button type="button" class="btn btn-primary" onclick="checkForm()">적용</button>
                                            <button type="button" class="btn btn-primary" style="margin-left:30px;" onclick="del(<?=$num?>)">삭제</button>
                                            <button type="button" class="btn btn-primary" style="margin-left:30px;" onclick="history.back()">취소</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- 내용 종료 -->
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        function checkForm() {
            if (document.myform.name.value == "") {
                alert("모델명을 입력해주세요.");
                document.myform.name.focus();
                return false;
            }
            document.myform.submit();
        }

        function del(num) {
            if (confirm("정말로 삭제하시겠습니까?")) {
                location.href = "./del_member_ok.php?num=" + num;
            }
        }
    </script>
</body>

</html>