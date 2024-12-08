<?php
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "db_connect.php";

// Xử lý yêu cầu đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    file_put_contents('log.txt', print_r($_POST, true));
    
    $so_cccd = isset($_POST['so_cccd']) ? $_POST['so_cccd'] : null;
    $hoTen = isset($_POST['hoTen']) ? $_POST['hoTen'] : null;
    $date_birth = isset($_POST['date_birth']) ? $_POST['date_birth'] : null;

    switch ($_POST['gender'] ?? null) {
        case 'nam':
            $gender = 1;
            break;
        case 'nu':
            $gender = 0;
            break;
        default:
            $gender = null;
            break;
    }

    $que_quan = isset($_POST['que_quan']) ? $_POST['que_quan'] : null;
    $htts = isset($_POST['htts']) ? $_POST['htts'] : null;
    $mts = isset($_POST['mts']) ? $_POST['mts'] : null;

    $mon_0 = isset($_POST['mon_0']) ? $_POST['mon_0'] : null;
    $mon_1 = isset($_POST['mon_1']) ? $_POST['mon_1'] : null;
    $mon_2 = isset($_POST['mon_2']) ? $_POST['mon_2'] : null;
    $mon_3 = isset($_POST['mon_3']) ? $_POST['mon_3'] : null;
    $mon_4 = isset($_POST['mon_4']) ? $_POST['mon_4'] : null;
    $mon_5 = isset($_POST['mon_5']) ? $_POST['mon_5'] : null;
    $diem = [
        'mon_0' => $mon_0,
        'mon_1' => $mon_1,
        'mon_2' => $mon_2,
        'mon_3' => $mon_3,
        'mon_4' => $mon_4,
        'mon_5' => $mon_5
    ];

    $sql = "UPDATE sinh_vien SET 
    cccd = :cccd, 
    address = :address, 
    date_of_birth = :date_of_birth, 
    ma_htts = :ma_htts, 
    diem = :diem, 
    ma_tuyen_sinh = :ma_tuyen_sinh, 
    ten = :ten,
    gender = :gender
    WHERE stu_id = :stu_id";

    // Chuẩn bị câu lệnh
    $stmt = $pdo->prepare($sql);

    // Gán giá trị cho các tham số
    $stmt->bindParam(':cccd', $so_cccd);
    $stmt->bindParam(':address', $que_quan);
    $stmt->bindParam(':date_of_birth', $date_birth);
    $stmt->bindParam(':ma_htts', $htts);
    $stmt->bindParam(':diem', $diem_json);
    $stmt->bindParam(':ma_tuyen_sinh', $mts);
    $stmt->bindParam(':ten', $hoTen);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':stu_id', $_SESSION['user']['id']);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        // Nếu thực thi thành công
        echo json_encode([
            'status' => 'success',
            'message' => 'Cập nhật dữ liệu thành công!'
        ]);
    } else {    
        $errorInfo = $stmt->errorInfo();
        // Nếu có lỗi xảy ra
        echo json_encode([
            'status' => 'error',
            'message' => 'Lỗi khi cập nhật dữ liệu. '. $errorInfo[2]
        ]);
    }
}


?>
