<?php
include_once "../include/page_start.php";
include_once "../include/dbcon.php";
include_once "../include/session.php";

$vehiclesNum = $_POST['vehicles_num'];
$writeDate = $_POST['write_date'];
$inputDate = $_POST['input_date'];
if ($inputDate == "") {
    $inputDate = null;
}

$workingTime = $_POST['working_time'];
$outputDate = $_POST['output_date'];
if ($outputDate == "") {
    $outputDate = null;
}
$price = $_POST['price'];
$symptomContent = $_POST['symptom_content'];
$causeContent = $_POST['cause_content'];
$workContent = $_POST['work_content'];
$etcContent = $_POST['etc_content'];

// vehicles 테이블에 데이터 삽입
$sqlStr = "INSERT INTO as_history (
    vehicles_num,
    mem_num,
    write_date,
    input_date,
    working_time,
    output_date,
    price,
    symptom_content,
    cause_content,
    work_content,
    etc_content,
    dtime
) VALUES (
    :vehicles_num,
    :mem_num,
    :write_date,
    :input_date,
    :working_time,
    :output_date,
    :price,
    :symptom_content,
    :cause_content,
    :work_content,
    :etc_content,
    NOW()
)";
$stmt = $conn->prepare($sqlStr);

$stmt->bindParam(':vehicles_num', $vehiclesNum, PDO::PARAM_INT);
$stmt->bindParam(':mem_num', $_SESSION["mem_num"], PDO::PARAM_INT);
$stmt->bindParam(':write_date', $writeDate, PDO::PARAM_STR);
$stmt->bindParam(':input_date', $inputDate, PDO::PARAM_STR);
$stmt->bindParam(':working_time', $workingTime, PDO::PARAM_INT);
$stmt->bindParam(':output_date', $outputDate, PDO::PARAM_STR);
$stmt->bindParam(':price', $price, PDO::PARAM_INT);
$stmt->bindParam(':symptom_content', $symptomContent, PDO::PARAM_STR);
$stmt->bindParam(':cause_content', $causeContent, PDO::PARAM_STR);
$stmt->bindParam(':work_content', $workContent, PDO::PARAM_STR);
$stmt->bindParam(':etc_content', $etcContent, PDO::PARAM_STR);

$stmt->execute();
$asHistoryNum = $conn->lastInsertId();

// 파일 업로드 및 데이터베이스 저장 함수
function handleFileUpload($files, $conn, $asHistoryNum, $category) {
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
                $sqlStr = "INSERT INTO " . $category.'_files'. " (as_history_num, filepath, dtime) VALUES (?,?,NOW())";
                $stmt = $conn->prepare($sqlStr);
                $stmt->execute([$asHistoryNum, $fileDestination]);
            } else {
                echo "Failed to upload file.<br>";
            }
        } else {
            echo "There was an error uploading your file!<br>";
        }
    }
}

// 파일 업로드 처리
if (isset($_FILES['work_content_files'])) {
    handleFileUpload($_FILES['work_content_files'], $conn, $asHistoryNum, 'work_content');
}

// DB 연결 종료 및 페이지 리다이렉트
$conn = null;
echo "<script>alert('AS 이력이 등록되었습니다.');opener.location.reload();self.close();</script>";
exit;
?>