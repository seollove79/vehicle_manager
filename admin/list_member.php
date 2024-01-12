<?php include_once("../include/page_start.php"); ?>
<?php include_once("../include/dbcon.php"); ?>
<?php include_once("../include/session_admin.php"); ?>
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

// 데이터를 추출할 시작 지점 계산
$start_from = ($page - 1) * $records_per_page;

// 이전과 다음 페이지로 이동하는 링크를 포함하여 데이터 가져오기
try {
    // LIMIT 쿼리를 사용하여 필요한 만큼의 레코드만 선택
    // 검색어가 있을 경우


    $sqlStr = "SELECT * FROM member where del_check = 0 and mem_level != 999 ";
    if ($searchString != "") {
        $sqlStr = $sqlStr . " and $column like '%$searchString%' ";
    }
    $sqlStr = $sqlStr . " ORDER BY num ASC LIMIT :start_from, :records_per_page";

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
                            회원 목록</div>
                    </div>
<!--검색폼-->
                    <div class="row mt-3 mb-3">
                        <div class="col-6 text-start"></div>
                        <div class="col-6 text-end">
                            <form class="d-flex" action="list_member.php" method="get" onsubmit="return checkSearchForm()" name="searchForm">
                                <select class="form-select" aria-label="Default select example" name="column">
                                    <option value="" <?php if($searchString=="") {?>selected<?php }?>>검색항목</option>
                                    <option value="">=======</option>
                                    <option value="mem_name" <?php if($column=='mem_name') {?>selected<?php }?>>이름</option>
                                    <option value="mem_id" <?php if($column=='mem_id') {?>selected<?php }?>>아이디</option>
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
                                        <th scope="col">이름</th>
                                        <th scope="col">아이디</th>
                                        <th scope="col">권한</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
// 가져온 데이터 출력
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $num = $row['num'];
    $memName = $row['mem_name'];
    $memId = $row['mem_id'];
    $memLevel = $row['mem_level'];
    switch ($memLevel) {
        case 999:
            $memLevel = "개발자";
            break;
        case 100:
            $memLevel = "관리자";
            break;
        default:
            $memLevel = "일반회원";
    }
?>
                                    <tr style="cursor:pointer;"
                                        onclick="document.location.href='content_member.php?num=<?=$num?>&page=<?=$page?>&column=<?=$column?>&searchString=<?=$searchString?>';">
                                        <td scope="row"><?=$num?></td>
                                        <td style="text-align:center;"><?=$memName?></td>
                                        <td style="text-align:center;"><?=$memId?></td>
                                        <td style="text-align:center;"><?=$memLevel?></td>
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
                                        <a class="page-link" href="list_member.php?page=<?=$i?>&column=<?=$column?>&searchString=<?=$searchString?>">
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
    </script>
</body>

</html>