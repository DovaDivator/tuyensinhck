<?php
session_start();
include 'db_connect.php';

// Hàm lấy dữ liệu từ bảng nganh
function fetchNganhData($pdo) {
    $query = "SELECT *
              FROM giao_vien";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$coursesGV = fetchNganhData($pdo);

function fetchGVforNgang($pdo) {
    $query = "Select
                gv_id as g,
                CONCAT(nganh_id, ' - ', ten_nganh) AS nganh_giao_vien
                    From
                nganh  ";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}
$gvlist = fetchGVforNgang($pdo);
foreach ($coursesGV as &$course) {
    $course['nganh_giao_vien'] = '';  
    foreach ($gvlist as $gv) {
        if ($course['gv_id'] == $gv['g']) {
            $course['nganh_giao_vien'] = $gv['nganh_giao_vien'];
            break; 
        }
    }
}

header('Content-Type: application/json');

echo json_encode($coursesGV);
?>

