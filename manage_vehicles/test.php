<?php
include_once("../include/page_start.php");
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();  // 스프레드시트 객체 생성
$sheet = $spreadsheet->getActiveSheet();  // 활성 시트 가져오기

// 셀에 값 설정
$sheet->setCellValue('A1', 'Hello World !');
$sheet->setCellValue('A2', 'Another cell');

$writer = new Xlsx($spreadsheet);  // Xlsx 포맷으로 작성하기 위한 객체 생성
$writer->save('hello_world.xlsx');  // 파일로 저장
?>