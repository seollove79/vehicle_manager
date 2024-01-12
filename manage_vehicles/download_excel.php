<?php
include_once("../include/page_start.php");
include_once("../include/dbcon.php");
include_once("../include/session.php");
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

$spreadsheet = new Spreadsheet();  // 스프레드시트 객체 생성
$sheet = $spreadsheet->getActiveSheet();  // 활성 시트 가져오기

// 셀에 값 설정
$sheet->setCellValue('A1', '순번');
$sheet->setCellValue('B1', '모델명');
$sheet->setCellValue('C1', '신고번호');
$sheet->setCellValue('D1', '기체 일련번호');
$sheet->setCellValue('E1', '제작일');
$sheet->setCellValue('F1', 'FC 일련번호');
$sheet->setCellValue('G1', 'FC 시리얼');
$sheet->setCellValue('H1', 'PMU');
$sheet->setCellValue('I1', 'GPS(1)');
$sheet->setCellValue('J1', 'GPS(2)');
$sheet->setCellValue('K1', 'RTK(모듈)');
$sheet->setCellValue('L1', 'RTK(1)');
$sheet->setCellValue('M1', 'RTK(2)');
$sheet->setCellValue('N1', '송신기');
$sheet->setCellValue('O1', '수신기');
$sheet->setCellValue('P1', '카메라');
$sheet->setCellValue('Q1', '전방 레이더');
$sheet->setCellValue('R1', '후방 레이더');
$sheet->setCellValue('S1', '하방 레이더');
$sheet->setCellValue('T1', '비고(모터)');
$sheet->setCellValue('U1', '판매처');
$sheet->setCellValue('V1', '출고일');
$sheet->setCellValue('W1', '소유자');
$sheet->setCellValue('X1', '소유자 연락처');
$sheet->setCellValue('Y1', '비고(옵션)');
$sheet->setCellValue('Z1', '형상변경이력');
$sheet->setCellValue('AA1', '초도인증검사');
$sheet->setCellValue('AB1', '1차 정기인증검사');
$sheet->setCellValue('AC1', '2차 정기인증검사');
$sheet->setCellValue('AD1', '3차 정기인증검사');


$sqlStr = "SELECT A.*,B.model_name FROM vehicles A inner join models B on A.models_num = B.num where A.del_check=0 ";

if ($selModel != "") {
    $sqlStr = $sqlStr . " and A.models_num = $selModel ";
}
if ($searchString != "") {
    $sqlStr = $sqlStr . " and A.$column like '%$searchString%' ";
}
$sqlStr = $sqlStr . " ORDER BY A.num ASC";

$stmt = $conn->prepare($sqlStr);
$stmt->execute();

$i=2;
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
    $etcMotor = $row['etc_motor'];
    $makeDate = $row['make_date'];
    $customerCo = $row['customer_co'];
    $customerDate = $row['customer_date'];
    $customerOwner = $row['customer_owner'];
    $customerTel = $row['customer_tel'];
    $customerOption = $row['customer_option'];
    $shapeChangeHistory = $row['shape_change_history'];
    $certificationInitialDate = $row['certification_initial_date'];
    $certification1Date = $row['certification_1_date'];
    $certification2Date = $row['certification_2_date'];
    $certification3Date = $row['certification_3_date'];

    $sheet->setCellValue('A'.$i, $num);
    $sheet->setCellValue('B'.$i, $modelName);
    $sheet->setCellValue('C'.$i, $registrationNum);
    $sheet->setCellValue('D'.$i, $vehicleSerialNum);
    $sheet->setCellValue('E'.$i, $makeDate);
    $sheet->setCellValue('F'.$i, $fcSerialNum1);
    $sheet->setCellValue('G'.$i, $fcSerialNum2);
    $sheet->setCellValue('H'.$i, $pmu);
    $sheet->setCellValue('I'.$i, $gps1);
    $sheet->setCellValue('J'.$i, $gps2);
    $sheet->setCellValue('K'.$i, $rtkModule);
    $sheet->setCellValue('L'.$i, $rtk1);
    $sheet->setCellValue('M'.$i, $rtk2);
    $sheet->setCellValue('N'.$i, $transmitter);
    $sheet->setCellValue('O'.$i, $receiver);
    $sheet->setCellValue('P'.$i, $camera);
    $sheet->setCellValue('Q'.$i, $frontRadar);
    $sheet->setCellValue('R'.$i, $rearRadar);
    $sheet->setCellValue('S'.$i, $downwardRadar);
    $sheet->setCellValue('T'.$i, $etcMotor);
    $sheet->setCellValue('U'.$i, $customerCo);
    $sheet->setCellValue('V'.$i, $customerDate);
    $sheet->setCellValue('W'.$i, $customerOwner);
    $sheet->setCellValue('X'.$i, $customerTel);
    $sheet->setCellValue('Y'.$i, $customerOption);
    $sheet->setCellValue('Z'.$i, $shapeChangeHistory);
    $sheet->setCellValue('AA'.$i, $certificationInitialDate);
    $sheet->setCellValue('AB'.$i, $certification1Date);
    $sheet->setCellValue('AC'.$i, $certification2Date);
    $sheet->setCellValue('AD'.$i, $certification3Date);
    $i++;
}

$conn = null;

$writer = new Xlsx($spreadsheet);  // Xlsx 포맷으로 작성하기 위한 객체 생성
//$writer->save('hello_world.xlsx');  // 파일로 저장

// 브라우저로 파일을 직접 출력하기 위한 HTTP 헤더 설정
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="기체목록.xlsx"');

// PHP 출력 버퍼링을 끄고 파일을 출력
ob_end_clean();
$writer->save('php://output');
exit;
?>