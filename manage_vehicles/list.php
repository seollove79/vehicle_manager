<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php include_once("../include/session.php"); ?>
<?php
// 페이징 설정
$records_per_page = 30; // 페이지당 레코드 수
$page = "";

if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};

if (isset($_GET["column"])) {
    $column  = $_GET["column"];
} else {
    $column = "";
};

if (isset($_GET["searchString"])) {
    $searchString  = $_GET["searchString"];
} else {
    $searchString = "";
};

if (isset($_GET["sel_model"])) {
    $selModel = $_GET["sel_model"];
} else{
    $selModel = "";
};

// 데이터를 추출할 시작 지점 계산
$start_from = ($page - 1) * $records_per_page;

// 이전과 다음 페이지로 이동하는 링크를 포함하여 데이터 가져오기
try {
    // LIMIT 쿼리를 사용하여 필요한 만큼의 레코드만 선택
    // 검색어가 있을 경우


    $sqlStr = "SELECT A.*,B.model_name FROM vehicles A inner join models B on A.models_num = B.num where A.del_check=0 ";
    if ($selModel != "") {
        $sqlStr = $sqlStr . " and A.models_num = $selModel ";
    }
    if ($searchString != "") {
        $sqlStr = $sqlStr . " and A.$column like '%$searchString%' ";
    }
    $sqlStr = $sqlStr . " ORDER BY A.num DESC LIMIT :start_from, :records_per_page";

    $stmt = $conn->prepare($sqlStr);
    $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
    $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $total_records = $stmt->rowCount();
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
                            기체 목록</div>
                    </div>
<!--검색폼-->
                    <div class="row mt-3 mb-3">
                        <div class="col-6 text-start"><button class="btn btn-primary" onclick="document.location.href='download_excel.php?column=<?=$column?>&searchString=<?=$searchString?>&sel_model=<?=$selModel?>';">엑셀저장</button></div>
                        <div class="col-6 text-end">
                            <form class="d-flex" action="list.php" method="get" onsubmit="return checkSearchForm()" name="searchForm">
                            <input type="hidden" name="sel_model" value="<?=$selModel?>">
                                <select class="form-select" aria-label="Default select example" name="column">
                                    <option value="" <?php if($searchString=="") {?>selected<?php }?>>검색항목</option>
                                    <option value="">=======</option>
                                    <option value="registration_num" <?php if($column=='registration_num') {?>selected<?php }?>>신고번호</option>
                                    <option value="vehicle_serial_num" <?php if($column=='vehicle_serial_num') {?>selected<?php }?>>기체 일련번호</option>
                                    <option value="fc_serial_num1" <?php if($column=='fc_serial_num1') {?>selected<?php }?>>FC 일련번호</option>
                                    <option value="fc_serial_num2" <?php if($column=='fc_serial_num2') {?>selected<?php }?>>FC 시리얼</option>
                                </select>
                                <input class="form-control me-2" type="search" placeholder="검색어" name="searchString" value="<?=$searchString?>">
                                <button class="btn btn-outline-success" type="submit">search</button>
                            </form>
                        </div>
                    </div>
<!--검색폼-->
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-hover table-borderd">
                                <thead>
                                    <tr>
                                        <th scope="col">순번</th>
                                        <th scope="col">
                                        <form name="modelForm" method="get" action="list.php" onsubmit="return checkModelForm()">
                                        <input type="hidden" name="column" value="<?=$column?>">
                                        <input type="hidden" name="searchString" value="<?=$searchString?>">
                                            <select class="form-select" name="sel_model" onchange="document.modelForm.submit()">
                                                <option value="" <?php if($selModel=="") {?>selected<?php } ?>>모델명</option>
                                                <option value="">======</option>
<?php
// 모델 목록 가겨오기
$sqlModelStr = "SELECT * FROM models where del_check=0 ORDER BY model_name ASC";
$stmtModel = $conn->prepare($sqlModelStr);
$stmtModel->execute();

while ($rowModel = $stmtModel->fetch(PDO::FETCH_ASSOC)) {
    $modelNum = $rowModel['num'];
    $modelName = $rowModel['model_name'];
?>
                                                <option value="<?=$modelNum?>" <?php if($selModel==$modelNum) { ?>selected<?php } ?>><?=$modelName?></option>
<?php
}
?>
                                            </select>
                                        </form>
                                        </th>
                                        <th scope="col">신고번호</th>
                                        <th scope="col">기체 일련번호</th>
                                        <th scope="col">제작일</th>
                                        <th scope="col">FC 일련번호</th>
                                        <th scope="col">송신기</th>
                                        <th scope="col">수신기</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
// 가져온 데이터 출력
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $num = $row['num'];
    $modelName = $row['model_name'];
    $registrationNum = $row['registration_num'];
    $vehicleSerialNum = $row['vehicle_serial_num'];
    $fcSerialNum1 = $row['fc_serial_num1'];
    $fcSerialNum2 = $row['fc_serial_num2'];
    $pmu = $row['pmu'];
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
    $makeDate = $row['make_date'];
?>
                                    <tr style="cursor:pointer;"
                                        onclick="document.location.href='content.php?num=<?=$num?>&page=<?=$page?>&column=<?=$column?>&searchString=<?=$searchString?>';">
                                        <td scope="row"><?=$num?></td>
                                        <td style="text-align:center;"><?=$modelName?></td>
                                        <td style="text-align:center;"><?=$registrationNum?></td>
                                        <td style="text-align:center;"><?=$vehicleSerialNum?></td>
                                        <td style="text-align:center;"><?=$makeDate?></td>
                                        <td style="text-align:center;"><?=$fcSerialNum1?></td>
                                        <td style="text-align:center;"><?=$transmitter?></td>
                                        <td style="text-align:center;"><?=$receiver?></td>
                                    </tr>
                                    <?php
}
?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
// 전체 페이지 수 계산
$total_pages = ceil($total_records / $records_per_page);

// 페이징 링크 생성
for ($i = 1; $i <= $total_pages; $i++) {
?>
                                    <li class="page-item">
                                        <a class="page-link" href="list.php?page=<?=$i?>&column=<?=$column?>&searchString=<?=$searchString?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                    <?php
}
// 연결 종료
$conn = null;
?>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
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
    function checkSearchForm() {
        if (document.searchForm.searchString.value == "") {
            alert("검색어를 입력하세요.");
            document.searchForm.searchString.focus();
            return false;
        }
        return true;
    }

    function checkModelForm() {
        if (document.modelForm.sel_model.value == "") {
            alert("모델을 선택하세요.");
            document.modelForm.sel_model.focus();
            return false;
        }
        return true;
    }
    </script>
</body>

</html>