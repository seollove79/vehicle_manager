<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php include_once("../include/session.php"); ?>
<?php
$vehiclesNum = $_GET['vehiclesNum'];

?>
<!doctype html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITE_TITLE; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <style>
    .write-table {
        border-collapse: collapse;
        width: 100%;
        border: 2px solid #c8c8c8;
    }

    .write-table td {
        border: 1px solid #c8c8c8;
        padding: 5px;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 text-start" style="border-bottom:1px solid #c8c8c8;padding-bottom:10px;font-weight:bold;font-size:12pt;margin-top:20px">AS 처리내용 작성</div>
        </div>
        <div class="row">
            <!-- 내용 시작 -->
            <div class="col-12">
                <form action="insert_as.php" method="post" onsubmit="return checkForm()" name="myform"
                    enctype="multipart/form-data">
                    <input type="hidden" name="vehicles_num" value="<?=$vehiclesNum?>">
                    <table class="write-table" style="margin-top:20px">
                        <tr>
                            <td width="50%" style="background-color:#e2e2e2;text-align:center">작성일</td>
                            <td width="50%" style="background-color:#e2e2e2;text-align:center">작성자</td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="date" name="write_date"></td>
                            <td style="text-align:center;"><?=$_SESSION["mem_name"]?></td>
                        </tr>
                    </table>
                    <div style="text-align:left;margin:20px 0 5px 0;">1. 처리정보</div>
                    <table class="write-table">
                        <tr>
                            <td width="25%" style="background-color:#e2e2e2;text-align:center">입고일</td>
                            <td width="25%" style="background-color:#e2e2e2;text-align:center">소요시간(시간)</td>
                            <td width="25%" style="background-color:#e2e2e2;text-align:center">출고일</td>
                            <td width="25%" style="background-color:#e2e2e2;text-align:center">청구비용(원)</td>
                        </tr>
                        <tr>
                            <td width="25%"><input class="form-control" type="date" name="input_date"></td>
                            <td width="25%"><input class="form-control" type="number" name="working_time" style="width:100%;height:100%;" placeholder="소요시간"></td>
                            <td width="25%"><input class="form-control" type="date" name="output_date"></td>
                            <td width="25%"><input class="form-control" type="number" name="price" placeholder="청구비용(원)"></td>
                        </tr>
                    </table>
                    <div style="text-align:left;margin:20px 0 5px 0;">2. 처리내용</div>
                    <table class="write-table">
                        <tr>
                            <td style="background-color:#e2e2e2;text-align:center">증상</td>
                        </tr>
                        <tr>
                            <td><textarea class="form-control" style="width:100%;height:100px" placeholder="증상" name="symptom_content"></textarea></td>
                        </tr>
                        <tr>
                            <td style="background-color:#e2e2e2;text-align:center">원인</td>
                        </tr>
                        <tr>
                            <td><textarea class="form-control" style="width:100%;height:100px" placeholder="원인" name="cause_content"></textarea></td>
                        </tr>
                        <tr>
                            <td style="background-color:#e2e2e2;text-align:center">작업내용</td>
                        </tr>
                        <tr>
                            <td><textarea class="form-control" style="width:100%;height:200px" placeholder="작업내용" name="work_content"></textarea></td>
                        </tr>
                        <tr>
                            <td><input type="file" class="form-control" aria-label="Upload" name="work_content_files[]" multiple placeholder="작업내용 참고파일"></td>
                        </tr>
                        <tr>
                            <td style="background-color:#e2e2e2;text-align:center">비고</td>
                        </tr>
                        <tr>
                            <td><textarea class="form-control" style="width:100%;height:100px" placeholder="비고" name="etc_content"></textarea></td>
                        </tr>
                    </table>
                    <div style="text-align:center;margin:20px 0 50px 0;">
                        <input type="submit" class="btn btn-primary" value="등록">
                        <button class="btn btn-primary" style="margin-left:20px" onclick="event.preventDefault();self.close()">취소</button>
                    </div>
                </form>
            </div>
            <!-- 내용 종료 -->
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script>
    //form submit시 체크
    function checkForm() {
        if (document.myform.write_date.value == "") {
            alert("작성일을 입력해주세요.");
            document.myform.write_date.focus();
            return false;
        }
        if (document.myform.input_date.value == "") {
            alert("입고일를 입력해주세요.");
            document.myform.input_date.focus();
            return false;
        }
        return true;
    }
    </script>
</body>

</html>