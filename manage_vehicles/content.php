<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php include_once("../include/session.php"); ?>
<?php
$num = isset($_GET["num"]) ? $_GET["num"] : exit("<script>alert('잘못된 접근입니다.');history.back();</script>");
$page  = $_GET["page"];
$column  = $_GET["column"];
$searchString  = $_GET["searchString"];
$selModel = $_GET["sel_model"];

try {
    $sqlStr = "SELECT A.*,B.model_name FROM vehicles A inner join models B on A.models_num = B.num where A.num=:num";
    $stmt = $conn->prepare($sqlStr);
    $stmt->bindParam(':num', $num, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $modelName = $row['model_name'];
    $registrationNum = $row['registration_num'];
    $vehicleSerialNum = $row['vehicle_serial_num'];
    $makeDate = $row['make_date'];
    $fcSerialNum1 = $row['fc_serial_num1'];
    $fcSerialNum2 = $row['fc_serial_num2'];
    $pmu = $row['pmu'];
    
    $customerDate = $row['customer_date'];
    $certificationInitialDate = $row['certification_initial_date'];
    $certification1Date = $row['certification_1_date'];
    $certification2Date = $row['certification_2_date'];
    $certification3Date = $row['certification_3_date'];
    
    $gps1 = $row['gps1'];
    $gps2 = $row['gps2'];
    $rtkModule = $row['rtk_module'];
    $rtk1 = $row['rtk1'];
    $rtk2 = $row['rtk2'];
    $transmitter = $row['transmitter'];
    $receiver = $row['receiver'];
    $camera = $row['camera'];
    $frontRadar = $row['front_radar'];
    $rearRadar = $row['rear_radar'];
    $downwardRadar = $row['downward_radar'];
    
    $customerCo = $row['customer_co'];
    $custumerOwner = $row['customer_owner'];
    $customerTel = $row['customer_tel'];
    $customerOption = $row['customer_option'];
    
    $shapeChangeHistory = $row['shape_change_history'];
    $etcMotor = $row['etc_motor'];

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
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
    <?php include_once("../include/top_menu.php"); ?>
    <div class="container text-center" style="margin-top:30px;">
        <div class="row">
            <div class="col-2"><?php include_once("./left_menu.php"); ?></div>
            <div class="col-10">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-start"
                            style="border-bottom:1px solid #c8c8c8;padding-bottom:10px;font-weight:bold;font-size:12pt;">
                            기체정보 등록</div>
                    </div>
                    <div class="row">
                        <!-- 내용 시작 -->
                        <div class="col-12">
                            <form action="modify_ok.php" method="post" onsubmit="return checkForm()" name="myform"
                                enctype="multipart/form-data">
                                <input type="hidden" name="num" value="<?=$num?>">
                                <div style="text-align:right;margin:20px 0 5px 0">* : 필수항목</div>
                                <div style="text-align:left;margin:10px 0 5px 0">1. 기본정보</div>
                                <table class="write-table">
                                    <tr>
                                        <td width="25%" style="background-color:#e2e2e2">*모델명</td>
                                        <td width="25%" style="background-color:#e2e2e2">*신고번호</td>
                                        <td width="25%" style="background-color:#e2e2e2">*기체 일련번호</td>
                                        <td width="25%" style="background-color:#e2e2e2">*제작일</td>
                                    </tr>
                                    <tr>
                                        <td><?=$modelName?></td>
                                        <td><input class="form-control" type="text" style="width:100%;height:100%;"
                                                placeholder="신고번호" name="registration_num" value="<?=$registrationNum?>"
                                                <?php if (!($_SESSION["mem_level"]==999 || $_SESSION["mem_level"]==100)) {echo 'readonly';}?>></td>
                                        <td><input class="form-control" type="text" style="width:100%;height:100%;"
                                                placeholder="기체 일련번호" name="vehicle_serial_num"
                                                value="<?=$vehicleSerialNum?>" <?php if (!($_SESSION["mem_level"]==999 || $_SESSION["mem_level"]==100)) {echo 'readonly';}?>></td>
                                        <td><input class="form-control" type="date" name="make_date"
                                                value="<?=$makeDate?>" <?php if (!($_SESSION["mem_level"]==999 || $_SESSION["mem_level"]==100)) {echo 'readonly';}?>></td>
                                    </tr>
                                </table>
                                <div style="text-align:left;margin:20px 0 5px 0;">2. 장착 장비 정보</div>
                                <table class="write-table">
                                    <tr>
                                        <td width="25%" style="background-color:#e2e2e2">*FC 일련번호</td>
                                        <td width="50%" colspan="2" style="background-color:#e2e2e2">FC 시리얼</td>
                                        <td width="25%" style="background-color:#e2e2e2">비고(모터)</td>
                                    </tr>
                                    <tr>
                                        <td width="25%"><input class="form-control" type="text"
                                                style="width:100%;height:100%;" placeholder="FC 일련번호"
                                                name="fc_serial_num1" value="<?=$fcSerialNum1?>"></td>
                                        <td width="50%" colspan="2"><input class="form-control" type="text"
                                                style="width:100%;height:100%;" placeholder="FC 시리얼"
                                                name="fc_serial_num2" value="<?=$fcSerialNum2?>"></td>
                                        <td width="25%" rowspan="9"><textarea class="form-control"
                                                style="width:100%;height:320px" placeholder="비고(모터)"
                                                name="etc_motor"><?=$etcMotor?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" style="background-color:#e2e2e2">PMU</td>
                                        <td width="25%" style="background-color:#e2e2e2">GPS_1</td>
                                        <td width="25%" style="background-color:#e2e2e2">GPS_2</td>
                                    </tr>
                                    <tr>
                                        <td width="25%"><input class="form-control" type="text"
                                                style="width:100%;height:100%" placeholder="PMU" name="pmu"
                                                value="<?=$pmu?>"></td>
                                        <td width="25%"><input class="form-control" type="text"
                                                style="width:100%;height:100%;" placeholder="GPS_1" name="gps1"
                                                value="<?=$gps1?>"></td>
                                        <td width="25%"><input class="form-control" type="text"
                                                style="width:100%;height:100%;" placeholder="GPS_2" name="gps2"
                                                value="<?=$gps2?>"></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" style="background-color:#e2e2e2">RTK_모듈</td>
                                        <td width="25%" style="background-color:#e2e2e2">RTK_1</td>
                                        <td width="25%" style="background-color:#e2e2e2">RTK_2</td>
                                    </tr>
                                    <tr>
                                        <td width="25%"><input class="form-control" type="text"
                                                style="width:100%;height:100%;" placeholder="RTK_모듈" name="rtk_module"
                                                value="<?=$rtkModule?>"></td>
                                        <td width="25%"><input class="form-control" type="text"
                                                style="width:100%;height:100%;" placeholder="RTK_1" name="rtk1"
                                                value="<?=$rtk1?>"></td>
                                        <td width="25%"><input class="form-control" type="text"
                                                style="width:100%;height:100%;" placeholder="RTK_2" name="rtk2"
                                                value="<?=$rtk2?>"></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" style="background-color:#e2e2e2">송신기</td>
                                        <td width="25%" style="background-color:#e2e2e2">수신기</td>
                                        <td width="25%" style="background-color:#e2e2e2">카메라</td>
                                    </tr>
                                    <tr>
                                        <td width="25%"><input class="form-control" type="text"
                                                style="width:100%;height:100%;" placeholder="송신기" name="transmitter"
                                                value="<?=$transmitter?>"></td>
                                        <td width="25%"><input class="form-control" type="text"
                                                style="width:100%;height:100%;" placeholder="수신기" name="receiver"
                                                value="<?=$receiver?>"></td>
                                        <td width="25%"><input class="form-control" type="text"
                                                style="width:100%;height:100%;" placeholder="카메라" name="camera"
                                                value="<?=$camera?>"></td>
                                    </tr>
                                    <tr>
                                        <td width="25%" style="background-color:#e2e2e2">전방 레이더</td>
                                        <td width="25%" style="background-color:#e2e2e2">후방 레이더</td>
                                        <td width="25%" style="background-color:#e2e2e2">하방 레이더</td>
                                    </tr>
                                    <tr>
                                        <td width="25%"><input class="form-control" type="text"
                                                style="width:100%;height:100%;" placeholder="전방 레이더" name="front_radar"
                                                value="<?=$frontRadar?>"></td>
                                        <td width="25%"><input class="form-control" type="text"
                                                style="width:100%;height:100%;" placeholder="후방 레이더" name="rear_radar"
                                                value="<?=$rearRadar?>"></td>
                                        <td width="25%"><input class="form-control" type="text"
                                                style="width:100%;height:100%;" placeholder="하방 레이더"
                                                name="downward_radar" value="<?=$downwardRadar?>"></td>
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
                                        <td><input class="form-control" type="text" style="width:100%;height:100%;"
                                                placeholder="판매처" name="customer_co" value="<?=$customerCo?>"></td>
                                        <td><input type="date" class="form-control" name="customer_date"></td>
                                        <td><input class="form-control" type="text" style="width:100%;height:100%;"
                                                placeholder="소유자" name="customer_owner" value="<?=$custumerOwner?>">
                                        </td>
                                        <td><input class="form-control" type="text" style="width:100%;height:100%;"
                                                placeholder="소유자 연락처" name="customer_tel" value="<?=$customerTel?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colSpan="4" style="background-color:#e2e2e2">비고(옵션)</td>
                                    </tr>
                                    <tr>
                                        <td colSpan="4"><textarea class="form-control" style="width:100%;height:200px"
                                                placeholder="비고(옵션)"
                                                name="customer_option"><?=$customerOption?></textarea></td>
                                    </tr>
                                </table>
                                <div style="text-align:left;margin:20px 0 5px 0;">4. 형상변경 이력(Rev.)</div>
                                <table class="write-table">
                                    <tr>
                                        <td><textarea class="form-control" style="width:100%;height:200px"
                                                placeholder="형상변경 이력(Rev.)"
                                                name="shape_change_history"><?=$shapeChangeHistory?></textarea></td>
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
                                        <td><input type="date" class="form-control" name="certification_initial_date"
                                                value="<?=$certificationInitialDate?>"></td>
                                        <td><input type="date" class="form-control" name="certification_1_date"
                                                value="<?=$certification1Date?>"></td>
                                        <td><input type="date" class="form-control" name="certification_2_date"
                                                value="<?=$certification2Date?>"></td>
                                        <td><input type="date" class="form-control" name="certification_3_date"
                                                value="<?=$certification3Date?>"></td>
                                    </tr>
                                    <tr>
                                        <td>
<?php
    $sqlStr = "SELECT * FROM certification_initial_files where vehicles_num=:vehicles_num";
    $stmt = $conn->prepare($sqlStr);
    $stmt->bindParam(':vehicles_num', $num, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $fileNum = $row['num'];
        $filepath = $row['filepath'];
        $filename = basename($filepath);
        $filepath = str_replace("D:/Apache24/htdocs", "", $filepath);
        echo "<a href='".$filepath."' target='_blank'>".$filename."</a> -- <a href='del_file.php?num=" .$fileNum. "&category=certification_initial_files'><i class='bi bi-file-minus-fill' style='color:red'></i></a><br>";
    }
?>
                                        </td>
                                        <td>
<?php
    $sqlStr = "SELECT * FROM certification_1_files where vehicles_num=:vehicles_num";
    $stmt = $conn->prepare($sqlStr);
    $stmt->bindParam(':vehicles_num', $num, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $fileNum = $row['num'];
        $filepath = $row['filepath'];
        $filename = basename($filepath);
        $filepath = str_replace("D:/Apache24/htdocs", "", $filepath);
        echo "<a href='".$filepath."' target='_blank'>".$filename."</a> -- <a href='del_file.php?num=" .$fileNum. "&category=certification_1_files'><i class='bi bi-file-minus-fill' style='color:red'></i></a><br>";
    }
?>
                                        </td>
                                        <td>
                                            <?php
    $sqlStr = "SELECT * FROM certification_2_files where vehicles_num=:vehicles_num";
    $stmt = $conn->prepare($sqlStr);
    $stmt->bindParam(':vehicles_num', $num, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $fileNum = $row['num'];
        $filepath = $row['filepath'];
        $filename = basename($filepath);
        $filepath = str_replace("D:/Apache24/htdocs", "", $filepath);
        echo "<a href='".$filepath."' target='_blank'>".$filename."</a> -- <a href='del_file.php?num=" .$fileNum. "&category=certification_2_files'><i class='bi bi-file-minus-fill' style='color:red'></i></a><br>";
    }
?>
                                        </td>
                                        <td>
                                            <?php
    $sqlStr = "SELECT * FROM certification_3_files where vehicles_num=:vehicles_num";
    $stmt = $conn->prepare($sqlStr);
    $stmt->bindParam(':vehicles_num', $num, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $fileNum = $row['num'];
        $filepath = $row['filepath'];
        $filename = basename($filepath);
        $filepath = str_replace("D:/Apache24/htdocs", "", $filepath);
        echo "<a href='".$filepath."' target='_blank'>".$filename."</a> -- <a href='del_file.php?num=" .$fileNum. "&category=certification_3_files'><i class='bi bi-file-minus-fill' style='color:red'></i></a><br>";
    }
?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="file" class="form-control" aria-label="Upload"
                                                name="certification_initial_files[]" multiple></td>
                                        <td><input type="file" class="form-control" aria-label="Upload"
                                                name="certification_1_files[]" multiple></td>
                                        <td><input type="file" class="form-control" aria-label="Upload"
                                                name="certification_2_files[]" multiple></td>
                                        <td><input type="file" class="form-control" aria-label="Upload"
                                                name="certification_3_files[]" multiple></td>
                                    </tr>
                                </table>
                                <div style="text-align:left;margin:20px 0 5px 0;">6. AS이력 <button class="btn btn-primary btn-sm" style="margin-left:20px" onclick="openWriteAs(<?=$num?>)">AS이력 작성</button></div>
                                <table class="write-table">
                                    <tr>
                                        <td style="background-color:#e2e2e2">작성일</td>
                                        <td style="background-color:#e2e2e2">작성자</td>
                                    </tr>
<?php
    $sqlStr = "SELECT A.num, A.write_date, B.mem_name FROM as_history A inner join member B on A.mem_num=B.num where vehicles_num=:vehicles_num and A.del_check=0 order by A.num desc";
    $stmt = $conn->prepare($sqlStr);
    $stmt->bindParam(':vehicles_num', $num, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $asHistoryNum = $row['num'];
        $asWriteDate = $row['write_date'];
        $asWriteName = $row['mem_name'];
?>
                                    <tr onclick="openContentAs(<?=$asHistoryNum?>)" style="cursor:pointer;">
                                        <td><?=$asWriteDate?></td>
                                        <td><?=$asWriteName?></td>
                                    </tr>
<?php
    }
?>
                                </table>
                                <div style="text-align:left;margin:20px 0 5px 0;">7. 변경이력</div>
                                <table class="write-table">
                                    <tr>
                                        <td width="10%" style="background-color:#e2e2e2">변경일</td>
                                        <td width="16%" style="background-color:#e2e2e2">변경 항목</td>
                                        <td width="33%" style="background-color:#e2e2e2">변경 전</td>
                                        <td width="33%" style="background-color:#e2e2e2">변경 후</td>
                                        <td width="8%" style="background-color:#e2e2e2">작성자</td>
                                    </tr>
<?php
    $sqlStr = "SELECT A.*, B.mem_name FROM change_history A inner join member B on A.mem_num=B.num where vehicles_num=:vehicles_num order by A.num desc";
    $stmt = $conn->prepare($sqlStr);
    $stmt->bindParam(':vehicles_num', $num, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $changeHistoryNum = $row['num'];
        $changeHistoryChangeDate = $row['change_date'];
        $changeHistoryChangeItem = $row['change_item'];
        $changeHistoryBeforeStatus = $row['before_status'];
        $changeHistoryAfterStatus = $row['after_status'];
        $changeHistoryWriteName = $row['mem_name'];
?>
                                    <tr>
                                        <td><?=$changeHistoryChangeDate?></td>
                                        <td><?=$changeHistoryChangeItem?></td>
                                        <td><?=$changeHistoryBeforeStatus?></td>
                                        <td><?=$changeHistoryAfterStatus?></td>
                                        <td><?=$changeHistoryWriteName?></td>
                                    </tr>
<?php
    }
?>
                                </table>
                                <div style="text-align:center;margin:20px 0 50px 0;">
                                    <input type="submit" class="btn btn-primary" value="수정사항 적용">
                                    <button class="btn btn-primary" style="margin-left:20px" onclick="delCheck(<?=$num?>)">삭제</button>
                                    <button class="btn btn-primary" style="margin-left:20px" onclick="event.preventDefault();document.location.href='list.php?page=<?=$page?>&column=<?=$column?>&searchString=<?=$searchString?>&sel_model=<?=$selModel?>';">미적용&목록</button>
                                </div>
                            </form>
                        </div>
                        <!-- 내용 종료 -->
                    </div>
                </div>


            </div>
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
        if (document.myform.registration_num.value == "") {
            alert("신고번호를 입력해주세요.");
            document.myform.registration_num.focus();
            return false;
        }

        if (document.myform.vehicle_serial_num.value == "") {
            alert("기체 일련번호를 입력해주세요.");
            document.myform.vehicle_serial_num.focus();
            return false;
        }

        if (document.myform.make_date.value == "") {
            alert("제작일을 입력해주세요.");
            document.myform.make_date.focus();
            return false;
        }

        if (document.myform.fc_serial_num1.value == "") {
            alert("FC 일련번호를 입력해주세요.");
            document.myform.fc_serial_num1.focus();
            return false;
        }
        return true;
    }

    function openWriteAs(vehiclesNum) {
        event.preventDefault();
        window.open("write_as.php?vehiclesNum="+vehiclesNum, "write_as", "width=800, height=600, left=100, top=50");
    }

    function openContentAs(asHistoryNum) {
        window.open("content_as.php?asHistoryNum="+asHistoryNum, "write_as", "width=800, height=600, left=100, top=50");
    }

    function delCheck(num) {
        event.preventDefault();
        if (confirm("정말 삭제하시겠습니까?")) {
            location.href = "del_ok.php?num=" + num;
        }
    }
    </script>
</body>

</html>