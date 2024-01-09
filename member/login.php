<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php
if(isset($_SERVER['HTTP_REFERER'])) {
    $previousPage = $_SERVER['HTTP_REFERER'];
} else {
    $previousPage = "/";
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
            <div class="col-2"></div>
            <div class="col-10">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-start" style="border-bottom:1px solid #c8c8c8;padding-bottom:10px;font-weight:bold;font-size:12pt;">로그인</div>
                    </div>
                    <div class="row justify-content-center" style="margin-top:20px">
                        <div class="col-5">
                            <form action="./login_ok.php" method="post" onsubmit="return checkForm()">
                                <input type="hidden" name="previous_page" value="<?=$previousPage?>">
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="id" name="id" placeholder="아이디를 입력하세요.">
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" id="pw" name="pw" placeholder="비밀번호를 입력하세요.">
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">로그인</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        function checkForm() {
            if (document.getElementById("id").value == "") {
                alert("아이디를 입력해주세요.");
                document.getElementById("id").focus();
                return false;
            }
            if (document.getElementById("pw").value == "") {
                alert("비밀번호를 입력해주세요.");
                document.getElementById("pw").focus();
                return false;
            }
            return true;
        }
    </script>
</body>

</html>