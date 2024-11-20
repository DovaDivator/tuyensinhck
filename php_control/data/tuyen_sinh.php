<?php
session_start();
include 'db_connect.php';

// Hàm lấy dữ liệu từ bảng nganh
function fetchNganhData($pdo) {
    $query = "SELECT *
              FROM nganh";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về tất cả các dòng dưới dạng mảng liên kết
}
$courses = fetchNganhData($pdo);

function fetchGVforNgang($pdo) {
    $query = "Select
                giao_vien.ten as teacher_name,
                giao_vien.gv_id
                    From
                nganh  inner join giao_vien on nganh.gv_id = giao_vien.gv_id;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về tất cả các dòng dưới dạng mảng liên kết
}
$gvlist = fetchGVforNgang($pdo);
foreach ($courses as &$course) {
    // Tìm giáo viên theo gv_id
    $course['ten_giao_vien'] = '';  // Mặc định không có giáo viên
    foreach ($gvlist as $gv) {
        if ($course['gv_id'] == $gv['gv_id']) {
            $course['ten_giao_vien'] = $gv['teacher_name'];
            break; // Nếu tìm thấy giáo viên, thoát vòng lặp
        }
    }
}

if ($_SESSION['user']['role'] != 'Student') {
    foreach ($courses as &$course) {
        $course['so_luong_dang_ky'] = 0; 
    }
}


header('Content-Type: application/json');

echo json_encode($courses);
?>

