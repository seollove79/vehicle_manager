<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<!doctype html>
<html lang="ko">
<?php
if (isset($_GET["list_contract_state_num"])) {
    $list_contract_state_num  = $_GET["list_contract_state_num"];
} else {
    $list_contract_state_num = "";
};

if (isset($_GET["list_check_tax_bill"])) {
    $list_check_tax_bill = $_GET["list_check_tax_bill"];
} else {
    $list_check_tax_bill = "";
};

if (isset($_GET["list_check_payment"])) {
    $list_check_payment  = $_GET["list_check_payment"];
} else {
    $list_check_payment = "";
};

if (isset($_GET["column"])) {
    $column  = $_GET["column"];
    if ($column == "customer_name") {
        $columnName = "C.name";
    } elseif ($column == "contract_name") {
        $columnName = "A.name";
    } elseif ($column == "contract_price") {
        $columnName = "A.contract_price";
    } else {
        $columnName = "";
    }
} else {
    $column = "";
    $columnName = "";
};

if (isset($_GET["searchString"])) {
    $searchString = $_GET["searchString"];
} else {
    $searchString = "";
};


// 페이징 설정
$records_per_page = 30; // 페이지당 레코드 수
$page = "";
$output = "";

if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};

// 데이터를 추출할 시작 지점 계산
$start_from = ($page - 1) * $records_per_page;

// 이전과 다음 페이지로 이동하는 링크를 포함하여 데이터 가져오기
try {
    // LIMIT 쿼리를 사용하여 필요한 만큼의 레코드만 선택
    $sqlStr = "SELECT A.*,B.name as contract_state_name, C.name as customer_name
    FROM contract A inner join contract_state B on A.contract_state_num = B.num inner join customer C on A.customer_num = C.num
    where A.del_check=0 " .
    ($list_contract_state_num !="" ? " and A.contract_state_num = :list_contract_state_num " : "") .
    ($list_check_tax_bill ? " and A.check_tax_bill = :list_check_tax_bill " : "") .
    ($list_check_payment ? " and A.check_payment = :list_check_payment " : "") .
    ($columnName ? " and " . $columnName . " like '%" . $searchString . "%'" : "") .
    " ORDER BY A.num DESC LIMIT :start_from, :records_per_page";

    $stmt = $conn->prepare($sqlStr);
    $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
    $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
    if ($list_contract_state_num) {
        $stmt->bindParam(':list_contract_state_num', $list_contract_state_num, PDO::PARAM_INT);
    }
    if ($list_check_tax_bill) {
        $stmt->bindParam(':list_check_tax_bill', $list_check_tax_bill, PDO::PARAM_INT);
    }
    if ($list_check_payment) {
        $stmt->bindParam(':list_check_payment', $list_check_payment, PDO::PARAM_INT);
    }
    $stmt->execute();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITE_TITLE; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/style.css">
</head>

<body>
    <?php include_once("../include/top_menu.php"); ?>
    <div class="container text-center" style="margin-top:30px;">
        <div class="row">
            <div class="col-2"><?php include_once("./left_menu.php"); ?></div>
            <div class="col-10">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-start" style="border-bottom:1px solid #c8c8c8;padding-bottom:10px;font-weight:bold;font-size:12pt;">계약 목록</div>
                    </div>
                    <div class="row">
                        <form action="list.php" method="get" onsubmit="return checkForm()" name="searchForm">
                        <input type="hidden" name="list_check_payment" value="<?=$list_check_payment?>">
                        <input type="hidden" name="list_check_tax_bill" value="<?=$list_check_tax_bill?>">
                        <input type="hidden" name="list_contract_state_num" value="<?=$list_contract_state_num?>">
                            <div class="col-12 text-end" style="margin-top:10px;">
                                <select name="column">
                                    <option value="">검색항목</option>
                                    <option value="">========</option>
                                    <option value="customer_name">고객명</option>
                                    <option value="contract_name">계약명</option>
                                    <option value="contract_price">계약금</option>
                                </select>
                                <input type="text" name="searchString" placeholder="검색어를 입력하세요.">
                                <button class="btn btn-outline-primary btn-sm">검색</button>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">번호</th>
                                        <th scope="col">고객명(계약명)</th>
                                        <th scope="col">계약금</th>
                                        <th scope="col">계약일</th>
                                        <th scope="col">작업일</th>
                                        <th scope="col">진행상태<br>
<?php
try {
    // LIMIT 쿼리를 사용하여 필요한 만큼의 레코드만 선택
    $contract_state_record = $conn->prepare("SELECT * FROM contract_state where del_check=0");
    $contract_state_record->execute();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                            <select name="contract_state" id="contract_state" onchange="onchange_filter()">
                                                <option value="" selected>전체</option>
<?php
// 가져온 데이터 출력
while ($contract_state_row = $contract_state_record->fetch(PDO::FETCH_ASSOC)) {
    $contract_state_num = $contract_state_row['num'];
    $contract_state_name = $contract_state_row['name'];
?>
                                                <option value="<?=$contract_state_num?>"  <?php if ($list_contract_state_num==$contract_state_num) { echo "selected"; } ?>><?=$contract_state_name?></option>
<?php
}
?>
                                            </select>
                                        </th>
                                        <th scope="col">계산서<br>
<select name="check_tax_bill" id="check_tax_bill" onchange="onchange_filter()">
    <option value="" selected>전체</option>
    <option value="0" <?php if ($list_check_tax_bill==0) { echo "selected"; } ?>>미발행</option>
    <option value="1" <?php if ($list_check_tax_bill==1) { echo "selected"; } ?>>발행</option>
</select>
                                        </th>
                                        <th scope="col">결제<br>
<select name="check_payment" id="check_payment" onchange="onchange_filter()">
    <option value="" selected>전체</option>
    <option value="0" <?php if ($list_check_payment==0) { echo "selected"; } ?>>미입금</option>
    <option value="1" <?php if ($list_check_payment==1) { echo "selected"; } ?>>입금완료</option>
</select>                                        
                                    </th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
// 가져온 데이터 출력
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $contract_num = $row['num'];
    $contract_name = $row['name'];
    $customer_name = $row['customer_name'];
    $contract_contract_price = number_format($row['contract_price']);
    $contract_date = $row['contract_date'];
    $start_date = $row['start_date'];
    $end_date = $row['end_date'];
    $contract_state_name = $row['contract_state_name'];
    if ($row['check_tax_bill']==0) {
        $check_tax_bill = "미발행";
    } else {
        $check_tax_bill = "발행<br>(".$row['tax_bill_date'].")";
    }

    if ($row['check_payment']==0) {
        $check_payment = "미입금";
    } else {
        $check_payment = "입금완료";
    }
?>
                                        <tr style="cursor:pointer;" onclick="document.location.href='content.php?num=<?=$contract_num?>&column=<?=$column?>&searchString=<?=$searchString?>&list_contract_state_num=<?=$list_contract_state_num?>&list_check_tax_bill=<?=$list_check_tax_bill?>&list_check_payment=<?=$list_check_payment?>&page=<?=$page?>';">
                                            <th scope="row"><?= $contract_num; ?></th>
                                            <td style="text-align:left;"><?= $customer_name; ?><br>(<?= $contract_name; ?>)</td>
                                            <td style="text-align:right;"><?= $contract_contract_price; ?></td>
                                            <td><?= $contract_date; ?></td>
                                            <td><?= $start_date; ?><br><?= $end_date; ?></td>
                                            <td><?= $contract_state_name; ?></td>
                                            <td><?= $check_tax_bill; ?></td>
                                            <td><?= $check_payment; ?></td>
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
$sqlStr = "SELECT COUNT(A.num) AS total FROM contract A inner join contract_state B on A.contract_state_num = B.num inner join customer C on A.customer_num = C.num where A.del_check=0 " .
($list_contract_state_num !="" ? " and A.contract_state_num = :list_contract_state_num " : "") .
($list_check_tax_bill ? " and A.check_tax_bill = :list_check_tax_bill " : "") .
($list_check_payment ? " and A.check_payment = :list_check_payment " : "") .
($columnName ? " and " . $columnName . " like '%" . $searchString . "%'" : "") .
" and A.num>0 ";

$stmt = $conn->prepare($sqlStr);
if ($list_contract_state_num) {
    $stmt->bindParam(':list_contract_state_num', $list_contract_state_num, PDO::PARAM_INT);
}
if ($list_check_tax_bill) {
    $stmt->bindParam(':list_check_tax_bill', $list_check_tax_bill, PDO::PARAM_INT);
}
if ($list_check_payment) {
    $stmt->bindParam(':list_check_payment', $list_check_payment, PDO::PARAM_INT);
}

$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_records = $row["total"];
$total_pages = ceil($total_records / $records_per_page);

// 페이징 링크 생성
for ($i = 1; $i <= $total_pages; $i++) {
?>
                                    <li class="page-item">
                                        <a class="page-link" href="/contract/list.php
                                        ?column=<?=$column?>&searchString=<?=$searchString?>
                                        &list_contract_state_num=<?=$list_contract_state_num?>
                                        &list_check_tax_bill=<?=$list_check_tax_bill?>
                                        &list_check_payment=<?=$list_check_payment?>
                                        &page=<?=$i?>">
                                        <?= $i ?>
                                        </a>
                                    </li>
<?php
}

// 결과 출력
echo $output;
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        function onchange_filter(){
            let list_contract_state_num = document.getElementById("contract_state").value;
            let list_check_tax_bill = document.getElementById("check_tax_bill").value;
            let list_check_payment = document.getElementById("check_payment").value;
            document.location.href = "/contract/list.php?column=<?=$column?>&searchString=<?=$searchString?>&list_contract_state_num="+list_contract_state_num+"&list_check_tax_bill="+list_check_tax_bill+"&list_check_payment="+list_check_payment;
        }

        function checkForm() {
            if(document.searchForm.column.value == "") {
                alert("검색항목을 선택하세요.");
                document.searchForm.column.focus();
                return false;
            }

            if (document.searchForm.searchString.value == "") {
                alert("검색어를 입력하세요.");
                document.searchForm.searchString.focus();
                return false;
            }
        }
    </script>
</body>

</html>