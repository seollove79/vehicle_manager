<?php 
include_once("../include/page_start.php"); 
include_once("../include/dbcon.php"); 
include_once("../include/session.php"); 

// POST 데이터 처리
$vehicleSerialNum = isset($_POST["vehicle_serial_num"]) ? $_POST["vehicle_serial_num"] : exit("<script>alert('기체 일련번호를 입력해주세요.');history.back();</script>");
$num = $_POST["num"];

// 기체 일련번호 중복 검사
$sqlStr = "SELECT * FROM vehicles WHERE vehicle_serial_num = :vehicle_serial_num AND num != :num";
$stmt = $conn->prepare($sqlStr);
$stmt->bindValue(':vehicle_serial_num', $vehicleSerialNum, PDO::PARAM_STR);
$stmt->bindValue(':num', $num, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row) {
    echo "<script>alert('이미 등록된 기체일련번호입니다..');history.back();</script>";
    exit;
}

$registrationNum = $_POST["registration_num"] ?: "N/A";
$makeDate = $_POST["make_date"] ?: null;
$fcSerialNum1 = $_POST["fc_serial_num1"] ?: "N/A";
$fcSerialNum2 = $_POST["fc_serial_num2"] ?: "N/A";
$pmu = $_POST["pmu"] ?: "N/A";

$customerDate = $_POST["customer_date"] ?: null;
$certificationInitialDate = $_POST["certification_initial_date"] ?: null;
$certification1Date = $_POST["certification_1_date"] ?: null;
$certification2Date = $_POST["certification_2_date"] ?: null;
$certification3Date = $_POST["certification_3_date"] ?: null;

$gp1 = $_POST["gps1"] ?: "N/A";
$gp2 = $_POST["gps2"] ?: "N/A";
$rtkModule = $_POST["rtk_module"] ?: "N/A";
$rtk1 = $_POST["rtk1"] ?: "N/A";
$rtk2 = $_POST["rtk2"] ?: "N/A";
$transmitter = $_POST["transmitter"] ?: "N/A";
$receiver = $_POST["receiver"] ?: "N/A";
$camera = $_POST["camera"] ?: "N/A";
$frontRadar = $_POST["front_radar"] ?: "N/A";
$rearRadar = $_POST["rear_radar"] ?: "N/A";
$downwardRadar = $_POST["downward_radar"] ?: "N/A";

$customerCo = $_POST["customer_co"] ?: "N/A";
$custumerOwner = $_POST["customer_owner"] ?: "N/A";
$customerTel = $_POST["customer_tel"] ?: "N/A";
$customerOption = $_POST["customer_option"] ?: "N/A";

$shapeChangeHistory = $_POST["shape_change_history"] ?: "N/A";
$etcMotor = $_POST["etc_motor"] ?: "N/A";

// 장착장비 정보 변경이력 관리
$sqlStr = "select fc_serial_num1, fc_serial_num2, pmu, gps1, gps2, rtk_module, rtk1, rtk2, transmitter, receiver, camera, front_radar, rear_radar, downward_radar, etc_motor from vehicles where num=:num";
$stmt = $conn->prepare($sqlStr);
$stmt->bindValue(':num', $num, PDO::PARAM_INT);
$stmt->execute();
$before = $stmt->fetch(PDO::FETCH_ASSOC);

$before = [
    'fc_serial_num1' => $before['fc_serial_num1'],
    'fc_serial_num2' => $before['fc_serial_num2'],
    'pmu' => $before['pmu'],
    'gps1' => $before['gps1'],
    'gps2' => $before['gps2'],
    'rtk_module' => $before['rtk_module'],
    'rtk1' => $before['rtk1'],
    'rtk2' => $before['rtk2'],
    'transmitter' => $before['transmitter'],
    'receiver' => $before['receiver'],
    'camera' => $before['camera'],
    'front_radar' => $before['front_radar'],
    'rear_radar' => $before['rear_radar'],
    'downward_radar' => $before['downward_radar'],
    'etc_motor' => $before['etc_motor']
];

$after = [
    'fc_serial_num1' => $fcSerialNum1,
    'fc_serial_num2' => $fcSerialNum2,
    'pmu' => $pmu,
    'gps1' => $gp1,
    'gps2' => $gp2,
    'rtk_module' => $rtkModule,
    'rtk1' => $rtk1,
    'rtk2' => $rtk2,
    'transmitter' => $transmitter,
    'receiver' => $receiver,
    'camera' => $camera,
    'front_radar' => $frontRadar,
    'rear_radar' => $rearRadar,
    'downward_radar' => $downwardRadar,
    'etc_motor' => $etcMotor
];

$changeHistory = [];
foreach ($before as $key => $value) {
    if ($before[$key] !== $after[$key]) {
        $changeHistory[] = $key;

        //key에 해당하는 아이템명을 가져옴
        //switch문으로 처리하면 됨
        $changeItem = '';
        switch ($key) {
            case 'fc_serial_num1':
                $changeItem = 'FC 일련번호';
                break;
            case 'fc_serial_num2':
                $changeItem = 'FC 시리얼';
                break;
            case 'pmu':
                $changeItem = 'PMU';
                break;
            case 'gps1':
                $changeItem = 'GPS_1';
                break;
            case 'gps2':
                $changeItem = 'GPS_2';
                break;
            case 'rtk_module':
                $changeItem = 'RTK_모듈';
                break;
            case 'rtk1':
                $changeItem = 'RTK_1';
                break;
            case 'rtk2':
                $changeItem = 'RTK_2';
                break;
            case 'transmitter':
                $changeItem = '송신기';
                break;
            case 'receiver':
                $changeItem = '수신기';
                break;
            case 'camera':
                $changeItem = '카메라';
                break;
            case 'front_radar':
                $changeItem = '전방 레이더';
                break;
            case 'rear_radar':
                $changeItem = '후방 레이더';
                break;
            case 'downward_radar':
                $changeItem = '하방 레이더';
                break;
            case 'etc_motor':
                $changeItem = '비고(모터)';
                break;
        }


        // 변경 이력을 change_history 테이블에 저장
        $sqlStr = "insert into change_history (
                vehicles_num, 
                change_date, 
                change_item, 
                before_status, 
                after_status,
                mem_num
            ) 
            values (
                :vehicles_num, 
                NOW(),
                :change_item,
                :before_status,
                :after_status,
                :mem_num
            )";
        $stmt = $conn->prepare($sqlStr);
        $stmt->bindValue(':vehicles_num', $num, PDO::PARAM_INT);
        $stmt->bindValue(':change_item', $changeItem, PDO::PARAM_STR);
        $stmt->bindValue(':before_status', $before[$key], PDO::PARAM_STR);
        $stmt->bindValue(':after_status', $after[$key], PDO::PARAM_STR);
        $stmt->bindValue(':mem_num', $_SESSION['mem_num'], PDO::PARAM_INT);
        $stmt->execute();
    }
}


// vehicles 테이블에 데이터 삽입
$sqlStr = "update vehicles set 
    registration_num=:registration_num, 
    vehicle_serial_num=:vehicle_serial_num, 
    make_date=:make_date, 
    fc_serial_num1=:fc_serial_num1, 
    fc_serial_num2=:fc_serial_num2, 
    pmu=:pmu, 
    gps1=:gps1, 
    gps2=:gps2, 
    rtk_module=:rtk_module, 
    rtk1=:rtk1, 
    rtk2=:rtk2, 
    transmitter=:transmitter, 
    receiver=:receiver, 
    camera=:camera, 
    front_radar=:front_radar, 
    rear_radar=:rear_radar, 
    downward_radar=:downward_radar, 
    customer_co=:customer_co, 
    customer_date=:customer_date, 
    customer_owner=:customer_owner, 
    customer_tel=:customer_tel, 
    customer_option=:customer_option, 
    shape_change_history=:shape_change_history, 
    certification_initial_date=:certification_initial_date, 
    certification_1_date=:certification_1_date, 
    certification_2_date=:certification_2_date, 
    certification_3_date=:certification_3_date, 
    etc_motor=:etc_motor
    where num=:num";

$stmt = $conn->prepare($sqlStr);
// bindValue 호출로 매개변수 바인딩
$stmt->bindValue(':registration_num', $registrationNum, PDO::PARAM_STR);
$stmt->bindValue(':vehicle_serial_num', $vehicleSerialNum, PDO::PARAM_STR);
$stmt->bindValue(':make_date', $makeDate, PDO::PARAM_STR);
$stmt->bindValue(':fc_serial_num1', $fcSerialNum1, PDO::PARAM_STR);
$stmt->bindValue(':fc_serial_num2', $fcSerialNum2, PDO::PARAM_STR);
$stmt->bindValue(':pmu', $pmu, PDO::PARAM_STR);
$stmt->bindValue(':gps1', $gp1, PDO::PARAM_STR);
$stmt->bindValue(':gps2', $gp2, PDO::PARAM_STR);
$stmt->bindValue(':rtk_module', $rtkModule, PDO::PARAM_STR);
$stmt->bindValue(':rtk1', $rtk1, PDO::PARAM_STR);
$stmt->bindValue(':rtk2', $rtk2, PDO::PARAM_STR);
$stmt->bindValue(':transmitter', $transmitter, PDO::PARAM_STR);
$stmt->bindValue(':receiver', $receiver, PDO::PARAM_STR);
$stmt->bindValue(':camera', $camera, PDO::PARAM_STR);
$stmt->bindValue(':front_radar', $frontRadar, PDO::PARAM_STR);
$stmt->bindValue(':rear_radar', $rearRadar, PDO::PARAM_STR);
$stmt->bindValue(':downward_radar', $downwardRadar, PDO::PARAM_STR);
$stmt->bindValue(':customer_co', $customerCo, PDO::PARAM_STR);
$stmt->bindValue(':customer_date', $customerDate, PDO::PARAM_STR);
$stmt->bindValue(':customer_owner', $custumerOwner, PDO::PARAM_STR);
$stmt->bindValue(':customer_tel', $customerTel, PDO::PARAM_STR);
$stmt->bindValue(':customer_option', $customerOption, PDO::PARAM_STR);
$stmt->bindValue(':shape_change_history', $shapeChangeHistory, PDO::PARAM_STR);
$stmt->bindValue(':certification_initial_date', $certificationInitialDate, PDO::PARAM_STR);
$stmt->bindValue(':certification_1_date', $certification1Date, PDO::PARAM_STR);
$stmt->bindValue(':certification_2_date', $certification2Date, PDO::PARAM_STR);
$stmt->bindValue(':certification_3_date', $certification3Date, PDO::PARAM_STR);
$stmt->bindValue(':etc_motor', $etcMotor, PDO::PARAM_STR);
$stmt->bindValue(':num', $num, PDO::PARAM_INT);
$stmt->execute();


// 파일 업로드 및 데이터베이스 저장 함수
function handleFileUpload($files, $conn, $vehiclesNum, $category) {
    $baseDir = $_SERVER['DOCUMENT_ROOT'] . "/attach_files/" . $category . "/";

    // 현재 폴더의 번호를 결정하는 로직
    $currentFolderNumber = 1;
    while (file_exists($baseDir . $currentFolderNumber) && count(scandir($baseDir . $currentFolderNumber)) >= 102) { // 2 for '.' and '..'
        $currentFolderNumber++;
    }
    $currentDir = $baseDir . $currentFolderNumber;

    // 폴더가 없으면 생성
    if (!file_exists($currentDir)) {
        mkdir($currentDir, 0777, true);
    }

    $total = count($files['name']);

    for ($i = 0; $i < $total; $i++) {
        // 파일 정보 추출
        $fileName = $files['name'][$i];
        $fileTmpName = $files['tmp_name'][$i];
        $fileError = $files['error'][$i];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $fileBaseName = preg_replace('/\.[^.]+$/', '', $fileName); // 확장자 제외한 파일 기본 이름 추출

        if ($fileError === 0) {
            // 유니크한 파일명 생성
            $fileNameNew = $fileBaseName . "." . $fileActualExt;
            $fileDestination = $currentDir . '/' . $fileNameNew;

            // 파일명 중복 검사 및 인덱스 추가
            $index = 1;
            while (file_exists($fileDestination)) {
                $fileNameNew = $fileBaseName . "_" . $index . "." . $fileActualExt;
                $fileDestination = $currentDir . '/' . $fileNameNew;
                $index++;
            }

            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                // 파일 업로드 성공 시, 데이터베이스에 정보 저장
                $sqlStr = "INSERT INTO " . $category.'_files'. " (vehicles_num, filepath, dtime) VALUES (?,?,NOW())";
                $stmt = $conn->prepare($sqlStr);
                $stmt->execute([$vehiclesNum, $fileDestination]);
            } else {
                echo "Failed to upload file.<br>";
            }
        } else {
            echo "There was an error uploading your file!<br>";
        }
    }
}

// 파일 업로드 처리
if (isset($_FILES['certification_initial_files'])) {
    handleFileUpload($_FILES['certification_initial_files'], $conn, $num, 'certification_initial');
}

if (isset($_FILES['certification_1_files'])) {
    handleFileUpload($_FILES['certification_1_files'], $conn, $num, 'certification_1');
}

if (isset($_FILES['certification_2_files'])) {
    handleFileUpload($_FILES['certification_2_files'], $conn, $num, 'certification_2');
}

if (isset($_FILES['certification_3_files'])) {
    handleFileUpload($_FILES['certification_3_files'], $conn, $num, 'certification_3');
}

// 같은 방식으로 다른 파일 카테고리에 대해서도 처리
// 예: certification_1_files, certification_2_files, certification_3_files 등

// DB 연결 종료 및 페이지 리다이렉트
$conn = null;
echo "<script>alert('수정사항이 적용되었습니다.');location.href='./list.php';</script>";
exit;
?>
