<?php
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "db_connect.php";

// Xử lý yêu cầu đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    file_put_contents('log.txt', print_r($_POST, true));
    // Lấy dữ liệu từ $_POST và kiểm tra nếu nó tồn tại và không rỗng
    $frontOfCCCD = isset($_POST['frontof_CCCD']) && $_POST['frontof_CCCD'] !== '' ? $_POST['frontof_CCCD'] : null;
    $behindOfCCCD = isset($_POST['behind_CCCD']) && $_POST['behind_CCCD'] !== '' ? $_POST['behind_CCCD'] : null;
    $soCCCD = isset($_POST['so_cccd']) && $_POST['so_cccd'] !== '' ? $_POST['so_cccd'] : null;
    $hoTen = isset($_POST['hoTen']) && $_POST['hoTen'] !== '' ? $_POST['hoTen'] : null;
    $dateBirth = isset($_POST['date_birth']) && $_POST['date_birth'] !== '' ? $_POST['date_birth'] : null;
    $gender = isset($_POST['gender']) && $_POST['gender'] !== '' ? $_POST['gender'] : null;
    $queQuan = isset($_POST['que_quan']) && $_POST['que_quan'] !== '' ? $_POST['que_quan'] : null;
    $mts = isset($_POST['mts']) && $_POST['mts'] !== '' ? $_POST['mts'] : null;

    // Lấy điểm các môn học từ dữ liệu POST, kiểm tra nếu nó tồn tại và không rỗng
    $diem = array();
    for ($i = 0; $i <= 5; $i++) {
        $monKey = 'mon_' . $i;
        $diem[$monKey] = isset($_POST[$monKey]) && $_POST[$monKey] !== '' ? $_POST[$monKey] : null;
    }

    // Tạo cấu trúc JSON từ các dữ liệu
    $result = array(
        'frontOfCCCD' => $frontOfCCCD,
        'behindOfCCCD' => $behindOfCCCD,
        'soCCCD' => $soCCCD,
        'hoTen' => $hoTen,
        'dateBirth' => $dateBirth,
        'gender' => $gender,
        'queQuan' => $queQuan,
        'mts' => $mts,
        'diem' => $diem
    );

    // Chuyển đổi mảng thành JSON
    $jsonData = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    // Ghi dữ liệu JSON vào file
    file_put_contents('data.json', $jsonData);

    // Trả về kết quả JSON
    echo $jsonData;
}
?>
