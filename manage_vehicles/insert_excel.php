<?php
include_once("../include/page_start.php"); 
include_once("../include/dbcon.php"); 
include_once("../include/session.php"); 

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excelFile'])) {
    $file = $_FILES['excelFile']['tmp_name'];
    $spreadsheet = IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    foreach ($rows as $rowIndex => $columns) {
        // 첫 번째 행은 열 이름이라고 가정하고 건너뜁니다.
        if ($rowIndex == 0) {
            continue;
        }

        // column 수를 체크합니다.
        if (count($columns) != 30) {
            echo "데이터의 열 개수가 맞지 않습니다. ({$rowIndex}번째 데이터)";
            exit;
        }

        //데이터 삽입 쿼리
        try {
            $strSql = "INSERT INTO vehicles (
                models_num,
                registration_num, 
                vehicle_serial_num, 
                make_date,
                fc_serial_num1, 
                fc_serial_num2, 
                pmu,
                gps1,
                gps2,
                rtk_module,
                rtk1,
                rtk2,
                transmitter,
                receiver,
                camera,
                front_radar,
                rear_radar,
                downward_radar,
                etc_motor,
                customer_co,
                customer_date,
                customer_owner,
                customer_tel,
                customer_option,
                shape_change_history,
                certification_initial_date,
                certification_1_date,
                certification_2_date,
                certification_3_date,
                dtime
            ) VALUES (
                :models_num,
                :registration_num, 
                :vehicle_serial_num, 
                :make_date,
                :fc_serial_num1, 
                :fc_serial_num2, 
                :pmu,
                :gps1,
                :gps2,
                :rtk_module,
                :rtk1,
                :rtk2,
                :transmitter,
                :receiver,
                :camera,
                :front_radar,
                :rear_radar,
                :downward_radar,
                :etc_motor,
                :customer_co,
                :customer_date,
                :customer_owner,
                :customer_tel,
                :customer_option,
                :shape_change_history,
                :certification_initial_date,
                :certification_1_date,
                :certification_2_date,
                :certification_3_date,
                NOW()
            )";

            $stmt = $conn->prepare($strSql);

            $modelNum = trim($columns[1]);
            $registrationNum = trim($columns[2]);
            $vehicleSerialNum = trim($columns[3]);
            $makeDate = trim($columns[4]);

            if ($modelNum=="") {
                echo "<script>alert('모델명이 입력되지 않았습니다. ({$rowIndex}번째 데이터)');history.back();</script>";
                exit();
            }

            if ($registrationNum=="") {
                echo "<script>alert('등록번호가 입력되지 않았습니다. ({$rowIndex}번째 데이터)');history.back();</script>";
                exit();
            }

            if ($vehicleSerialNum=="") {
                echo "<script>alert('기체일련번호가 입력되지 않았습니다. ({$rowIndex}번째 데이터)');history.back();</script>";
                exit();
            }

            if ($makeDate=="") {
                echo "<script>alert('제작일자가 입력되지 않았습니다. ({$rowIndex}번째 데이터)');history.back();</script>";
                exit();
            }
            
            //문자열 모델명을 models_num으로 변환
            $stmt2 = $conn->prepare("SELECT num FROM models WHERE model_name = :model_name");
            $stmt2->bindParam(':model_name', $modelNum, PDO::PARAM_STR);
            $stmt2->execute();
            $row = $stmt2->fetch(PDO::FETCH_ASSOC);
            $modelNum = $row['num'];


            $stmt->bindParam(':models_num', $modelNum, PDO::PARAM_INT);
            $stmt->bindParam(':registration_num', $registrationNum, PDO::PARAM_STR);
            $stmt->bindParam(':vehicle_serial_num', $vehicleSerialNum, PDO::PARAM_STR);
            $stmt->bindParam(':make_date', $makeDate, PDO::PARAM_STR);
            $stmt->bindParam(':fc_serial_num1', $columns[5], PDO::PARAM_STR);
            $stmt->bindParam(':fc_serial_num2', $columns[6], PDO::PARAM_STR);
            $stmt->bindParam(':pmu', $columns[7], PDO::PARAM_STR);
            $stmt->bindParam(':gps1', $columns[8], PDO::PARAM_STR);
            $stmt->bindParam(':gps2', $columns[9], PDO::PARAM_STR);
            $stmt->bindParam(':rtk_module', $columns[10], PDO::PARAM_STR);
            $stmt->bindParam(':rtk1', $columns[11], PDO::PARAM_STR);
            $stmt->bindParam(':rtk2', $columns[12], PDO::PARAM_STR);
            $stmt->bindParam(':transmitter', $columns[13], PDO::PARAM_STR);
            $stmt->bindParam(':receiver', $columns[14], PDO::PARAM_STR);
            $stmt->bindParam(':camera', $columns[15], PDO::PARAM_STR);
            $stmt->bindParam(':front_radar', $columns[16], PDO::PARAM_STR);
            $stmt->bindParam(':rear_radar', $columns[17], PDO::PARAM_STR);
            $stmt->bindParam(':downward_radar', $columns[18], PDO::PARAM_STR);
            $stmt->bindParam(':etc_motor', $columns[19], PDO::PARAM_STR);
            $stmt->bindParam(':customer_co', $columns[20], PDO::PARAM_STR);
            $stmt->bindParam(':customer_date', $columns[21], PDO::PARAM_STR);
            $stmt->bindParam(':customer_owner', $columns[22], PDO::PARAM_STR);
            $stmt->bindParam(':customer_tel', $columns[23], PDO::PARAM_STR);
            $stmt->bindParam(':customer_option', $columns[24], PDO::PARAM_STR);
            $stmt->bindParam(':shape_change_history', $columns[25], PDO::PARAM_STR);
            $stmt->bindParam(':certification_initial_date', $columns[26], PDO::PARAM_STR);
            $stmt->bindParam(':certification_1_date', $columns[27], PDO::PARAM_STR);
            $stmt->bindParam(':certification_2_date', $columns[28], PDO::PARAM_STR);
            $stmt->bindParam(':certification_3_date', $columns[29], PDO::PARAM_STR);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "데이터베이스 오류: " . $e->getMessage();
        }

        
    }
    echo "<script>alert('데이터가 성공적으로 입력되었습니다.');self.close();opener.location.reload();</script>";
}
?>