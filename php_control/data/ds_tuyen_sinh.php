<?php
include 'db_connect.php';
include '../php_control/backend/convert.php';

function getDSTuyenSinh(){
    switch($_SESSION['user']['role']){
        case 'Student':
            $courses = fetchNganhSV();
            break;
        case 'Teacher':
            $courses = fetchNganhGV();
            break;
        case 'Admin':
            $courses = fetchNganhAD();
            break;
        default:
            return "Vai trò không hợp lệ!";
    }

    foreach ($courses as &$course) {
        if (isset($course['date_end'])) {
            $course['date_end'] = convert_date($course['date_end']);
        }
    }
    return $courses;
}

function getDSGV(){
    $courses = fetchListGV();
    foreach ($courses as &$course) {
        if (isset($course['date_end'])) {
            $course['date_end'] = convert_date($course['date_end']);
        }
    }
    return $courses;
}

function getDSSV(){
    $courses = fetchListSV();
    foreach ($courses as &$course) {
        if (isset($course['date_end'])) {
            $course['date_end'] = convert_date($course['date_end']);
        }
    }
    return $courses;
}

function fetchNganhSV(){
    global $pdo;
    $query = "SELECT * FROM get_list_nganh_sv()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

// Hàm lấy dữ liệu từ bảng nganh
function fetchNganhGV(){
    global $pdo;
    $query = "SELECT * FROM get_list_nganh_gv(:id)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $_SESSION['user']['id']);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

function fetchNganhAD(){
    global $pdo;
    $query = "SELECT * FROM get_list_nganh_ad()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

function fetchListGV(){
    global $pdo;
    $query = "SELECT * FROM get_list_gv_admin()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

function fetchListSV(){
    global $pdo;
    $query = "SELECT * FROM get_list_sv_admin()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}
?>

