<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php include_once("../include/session.php"); ?>
<!doctype html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITE_TITLE; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
    <?php include_once("../include/top_menu.php"); ?>
    <div class="container text-center" style="margin-top:30px;">
        <div class="row">
            <div class="col-2"><?php include_once("./left_menu.php"); ?></div>
            <div class="col-10">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-start" style="border-bottom:1px solid #c8c8c8;padding-bottom:10px;font-weight:bold;font-size:12pt;">기체정보 등록</div>
                    </div>
                    <div class="row">
                        <!-- 내용 시작 -->
                        <div class="col-12">
                            <form action="insert.php" method="post" onsubmit="return checkForm()" name="myform" enctype="multipart/form-data">
                                <div style="text-align:right;margin:20px 0 5px 0">* : 필수항목</div>
                                <div style="text-align:left;margin:10px 0 5px 0">1. 기본정보</div>
                                <table class="write-table">
                                    <tr>
                                        <td width="25%" style="background-color:#e2e2e2">*모델명</td>
                                        <td width="25%" style="background-color:#e2e2e2">신고번호</td>
                                        <td width="25%" style="background-color:#e2e2e2">*기체 일련번호</td>
                                        <td width="25%" style="background-color:#e2e2e2">제작일</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select class="form-select" name="models_num">
                                                <option value="">모델명</option>
                                                <option value="">=============</option>
<?php
$sqlStr = "SELECT * FROM models where del_check=0";
$stmt = $conn->prepare($sqlStr);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
                                                <option value="<?=$row['num']?>"><?=$row['model_name']?></option>
<?php
}
?>
                                            </select>
                                        </td>
                                        <td><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="신고번호" name="registration_num"></td>
                                        <td><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="기체 일련번호" name="vehicle_serial_num"></td>
                                        <td><input class="form-control" type="date" name="make_date"></td>
                                    </tr>
                                </table>
                                <div style="text-align:left;margin:20px 0 5px 0;">2. 장착 장비 정보</div>
                                <table class="write-table">
                                    <tr>
                                        <td width="25%" style="background-color:#e2e2e2">FC 일련번호</td>
                                        <td width="50%" colspan="2" style="background-color:#e2e2e2">FC 시리얼</td>
                                        <td width="25%" style="background-color:#e2e2e2">비고(모터)</td>
                                    </tr>
                                    <tr>
                                        <td width="25%"><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="FC 일련번호" name="fc_serial_num1"></td>
                                        <td width="50%" colspan="2"><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="FC 시리얼" name="fc_serial_num2"></td>
                                        <td width="25%" rowspan="9"><textarea class="form-control" style="width:100%;height:320px" placeholder="비고(모터)" name="etc_motor"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" style="background-color:#e2e2e2">PMU</td>
                                        <td width="25%" style="background-color:#e2e2e2">GPS_1</td>
                                        <td width="25%" style="background-color:#e2e2e2">GPS_2</td>
                                    </tr>
                                    <tr>
                                        <td width="25%"><input class="form-control" type="text" style="width:100%;height:100%" placeholder="PMU" name="pmu"></td>
                                        <td width="25%"><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="GPS_1" name="gps1"></td>
                                        <td width="25%"><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="GPS_2" name="gps2"></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" style="background-color:#e2e2e2">RTK_모듈</td>
                                        <td width="25%" style="background-color:#e2e2e2">RTK_1</td>
                                        <td width="25%" style="background-color:#e2e2e2">RTK_2</td>
                                    </tr>
                                    <tr>
                                        <td width="25%"><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="RTK_모듈" name="rtk_module"></td>
                                        <td width="25%"><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="RTK_1" name="rtk1"></td>
                                        <td width="25%"><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="RTK_2" name="rtk2"></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" style="background-color:#e2e2e2">송신기</td>
                                        <td width="25%" style="background-color:#e2e2e2">수신기</td>
                                        <td width="25%" style="background-color:#e2e2e2">카메라</td>
                                    </tr>
                                    <tr>
                                        <td width="25%"><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="송신기" name="transmitter"></td>
                                        <td width="25%"><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="수신기" name="receiver"></td>
                                        <td width="25%"><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="카메라" name="camera"></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" style="background-color:#e2e2e2">전방 레이더</td>
                                        <td width="25%" style="background-color:#e2e2e2">후방 레이더</td>
                                        <td width="25%" style="background-color:#e2e2e2">하방 레이더</td>
                                    </tr>
                                    <tr>
                                        <td width="25%"><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="전방 레이더" name="front_radar"></td>
                                        <td width="25%"><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="후방 레이더" name="rear_radar"></td>
                                        <td width="25%"><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="하방 레이더" name="downward_radar"></td>
                                    </tr>
                                </table>
                                <div style="text-align:left;margin:20px 0 5px 0;">3. 판매 정보</div>
                                <table class="write-table">
                                    <tr>
                                        <td style="background-color:#e2e2e2" width="25%">판매처</td>
                                        <td style="background-color:#e2e2e2" width="25%">출고일</td>
                                        <td style="background-color:#e2e2e2" width="25%">소유자</td>
                                        <td style="background-color:#e2e2e2" width="25%">소유자 연락처</td>
                                    </tr>
                                    <tr>
                                        <td><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="판매처" name="customer_co"></td>
                                        <td><input type="date" class="form-control" name="customer_date"></td>
                                        <td><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="소유자" name="customer_owner"></td>
                                        <td><input class="form-control" type="text" style="width:100%;height:100%;" placeholder="소유자 연락처" name="customer_tel"></td>
                                    </tr>
                                    <tr>
                                        <td colSpan="4" style="background-color:#e2e2e2">비고(옵션)</td>
                                    </tr>
                                    <tr>
                                        <td colSpan="4"><textarea class="form-control" style="width:100%;height:200px" placeholder="비고(옵션)" name="customer_option"></textarea></td>
                                    </tr>
                                </table>
                                <div style="text-align:left;margin:20px 0 5px 0;">4. 형상변경 이력(Rev.)</div>
                                <table class="write-table">
                                    <tr>
                                        <td><textarea class="form-control" style="width:100%;height:200px" placeholder="형상변경 이력(Rev.)" name="shape_change_history"></textarea></td>
                                    </tr>
                                </table>
                                <div style="text-align:left;margin:20px 0 5px 0;">5. 인증 이력</div>
                                <table class="write-table">
                                    <tr>
                                        <td width="25%" style="background-color:#e2e2e2">초도인증검사</td>
                                        <td width="25%" style="background-color:#e2e2e2">1차 정기인증검사</td>
                                        <td width="25%" style="background-color:#e2e2e2">2차 정기인증검사</td>
                                        <td width="25%" style="background-color:#e2e2e2">3차 정기인증검사</td>
                                    </tr>
                                    <tr>
                                        <td><input type="date" class="form-control" name="certification_initial_date"></td>
                                        <td><input type="date" class="form-control" name="certification_1_date"></td>
                                        <td><input type="date" class="form-control" name="certification_2_date"></td>
                                        <td><input type="date" class="form-control" name="certification_3_date"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="file" class="form-control" aria-label="Upload" name="certification_initial_files[]" multiple></td>
                                        <td><input type="file" class="form-control" aria-label="Upload" name="certification_1_files[]" multiple></td>
                                        <td><input type="file" class="form-control" aria-label="Upload" name="certification_2_files[]" multiple></td>
                                        <td><input type="file" class="form-control" aria-label="Upload" name="certification_3_files[]" multiple></td>
                                    </tr>
                                </table>
                                <div style="text-align:center;margin:20px 0 50px 0;">
                                    <input type="submit" class="btn btn-primary" value="등록">
                                    <button class="btn btn-primary" style="margin-left:20px" onclick="event.preventDefault();history.back()">취소</button>
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
//form submit시 체크
function checkForm() {
    if (document.myform.models_num.value == "") {
        alert("모델명을 선택해주세요.");
        document.myform.models_num.focus();
        return false;
    }
    // if (document.myform.registration_num.value == "") {
    //     alert("신고번호를 입력해주세요.");
    //     document.myform.registration_num.focus();
    //     return false;
    // }
    if (document.myform.vehicle_serial_num.value == "") {
        alert("기체 일련번호를 입력해주세요.");
        document.myform.vehicle_serial_num.focus();
        return false;
    }
    // if (document.myform.make_date.value == "") {
    //     alert("제작일을 입력해주세요.");
    //     document.myform.make_date.focus();
    //     return false;
    // }
    // if (document.myform.fc_serial_num1.value == "") {
    //     alert("FC 일련번호를 입력해주세요.");
    //     document.myform.fc_serial_num1.focus();
    //     return false;
    // }
    return true;
}
    </script>
</body>

</html>