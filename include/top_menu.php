<div class="container-fluid text-center" style="background-color: #d1d1d1;">
    <div class="row align-items-start"><a href="/" style="font-size: 20pt;text-align:left;margin:10px 0 0 10px;">INTOSKY
            기체관리 시스템</a></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-7">
                <div class="row align-items-start" style="margin-top:10px">
                    <div class="col align-items-start" style="margin-left:10px;">
                        <ul class="nav nav-underline">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/manage_models/list.php">모델관리</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page"
                                    href="/manage_vehicles/list.php">기체정보관리</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/list_member.php">관리자메뉴</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-5 d-flex align-items-center justify-content-end">
<?php
if (isset($_SESSION["mem_name"])) {
    echo $_SESSION["mem_name"] ."님&nbsp;<a href='/member/myinfo.php'><i class='bi bi-person-circle'></i></a>&nbsp;&nbsp;<a href='/member/logout.php'>로그아웃</a>";
} else {
    echo "<a href='/member/login.php'>로그인</a>";
}
?>
            </div>
        </div>
    </div>
</div>