<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php include_once("../include/session.php"); ?>
<?php
$strSql = "SELECT * FROM member WHERE num = :num";
try {
    $stmt = $conn->prepare($strSql);
    $stmt->bindParam(':num', $_SESSION["mem_num"], PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$memId = $row["mem_id"];
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
                        <div class="col-12 text-start" style="border-bottom:1px solid #c8c8c8;padding-bottom:10px;font-weight:bold;font-size:12pt;">비밀번호 변경</div>
                    </div>
                    <div class="row">
                        <!-- 내용 시작 -->
                        <div class="col-12">
                            <form action="modify_password_ok.php" method="post" onsubmit="return checkForm()" name="myform">
                                <input type="hidden" name="num" value="<?=$num?>">
                                <div class="container" style="margin-top:10px;margin-bottom:50px;">
                                    <div class="row align-items-center" style="margin-top:20px;">
                                        <div class="col-12 text-start">
                                            <span style="font-weight:bold;">이름</span>
                                            <input type="text" class="form-control mt-1" placeholder="이름" aria-label="이름" name="mem_name" value="<?=$_SESSION["mem_name"]?>" readonly>
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
                                            <span style="font-weight:bold;">기존 비밀번호</span>
                                            <input type="password" class="form-control mt-1" placeholder="기존 비밀번호" aria-label="기존 비밀번호" name="old_password">
                                        </div>
                                    </div>
                                    <div class="row align-items-center" style="margin-top:20px;">
                                        <div class="col-12 text-start">
                                            <span style="font-weight:bold;">새 비밀번호</span>
                                            <input type="password" class="form-control mt-1" placeholder="새 비밀번호" aria-label="새 비밀번호" name="new_password">
                                        </div>
                                    </div>
                                    <div class="row align-items-center" style="margin-top:20px;">
                                        <div class="col-12 text-start">
                                            <span style="font-weight:bold;">새 비밀번호 확인</span>
                                            <input type="password" class="form-control mt-1" placeholder="새 비밀번호 확인" aria-label="새 비밀번호 확인" name="new_password_confirm">
                                        </div>
                                    </div>
                                    <div class="row align-items-center" style="margin-top: 20px;">
                                        <div class="col-12 text-center">
                                            <input type="submit" class="btn btn-primary" value="적용">
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
            if(document.myform.old_password.value == "") {
                alert("기존 비밀번호를 입력해주세요.");
                document.myform.old_password.focus();
                return false;
            }

            if(document.myform.new_password.value == "") {
                alert("새 비밀번호를 입력해주세요.");
                document.myform.new_password.focus();
                return false;
            }

            if(document.myform.new_password_confirm.value == "") {
                alert("새 비밀번호 확인을 입력해주세요.");
                document.myform.new_password_confirm.focus();
                return false;
            }

            if(document.myform.new_password.value != document.myform.new_password_confirm.value) {
                alert("새 비밀번호와 새 비밀번호 확인이 일치하지 않습니다.");
                document.myform.new_password.focus();
                return false;
            }
            return true;
        }
    </script>
</body>

</html>