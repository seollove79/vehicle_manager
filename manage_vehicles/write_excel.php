<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php include_once("../include/session.php"); ?>
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
            <div class="col-12 text-start" style="border-bottom:1px solid #c8c8c8;padding-bottom:10px;font-weight:bold;font-size:12pt;margin-top:20px">엑셀 업로드</div>
        </div>
        <div class="row">
            <!-- 내용 시작 -->
            <div class="col-12">
                <form action="insert_excel.php" method="post" onsubmit="return checkForm()" name="myform"
                    enctype="multipart/form-data">
                    <div style="text-align:left;margin:20px 0 5px 0;">엑셀파일 첨부</div>
                    <table class="write-table">
                        <tr>
                            <td><input type="file" class="form-control" aria-label="Upload" name="excelFile"></td>
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
        if (document.myform.excelFile.value == "") {
            alert("파일을 첨부하세요.");
            document.myform.excelFile.focus();
            return false;
        }
        return true;
    }
    </script>
</body>

</html>