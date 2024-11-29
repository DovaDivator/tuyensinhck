<?php
include 'db_connect.php';

function getDSTuyenSinh($query, $status, $selectedTH){
    $condition = getCondition($query, $status, $selectedTH);

    switch($_SESSION['user']['role']){
        case 'Student':
            $courses = fetchNganhSV($condition);
            break;
        case 'Teacher':
            $courses = fetchNganhGV($condition);
            break;
        case 'Admin':
            $courses = fetchNganhAD($condition);
            break;
        default:
            return "Vai trò không hợp lệ!";
    }

    foreach ($courses as &$course) {
        if (isset($course['date_end'])) {
            $course['date_end'] = (new DateTime(substr($course['date_end'], 0, 19)))->format('d/m/Y');
        }
    }
    return $courses;
}

function fetchNganhSV($condition){
    global $pdo;
    $query = "SELECT * FROM get_list_nganh_sv() ".$condition;
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

// Hàm lấy dữ liệu từ bảng nganh
function fetchNganhGV($condition){
    global $pdo;
    $query = "SELECT * FROM get_list_nganh_gv(:id) ". $condition;
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $_SESSION['user']['id']);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

function fetchNganhAD($condition){
    global $pdo;
    $query = "SELECT * FROM get_list_nganh_ad() ".$condition;
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

function getCondition($query, $status, $selectedTH) {
    $condition = '';
    
    if ($query != '') {
        $condition .= " (id ilike '%$query%' or ten ilike '%$query%')";
    }

    if ($status != '') {
        if ($condition != '') {
            $condition .= " and ";
        }
        switch ($status) {
            case 'sapmo':
                $condition .= ' isenable = 1';
                break;
            case 'dangmo':
                $condition .= ' isenable = 2';
                break;
            case 'dadong':
                $condition .= ' isenable = 3';
                break;
            case 'dangan':
                $condition .= ' isenable = 0';
                break;
            default:
            $condition = rtrim($condition, " and ");
                break;
        }
    }

    if (!empty($selectedTH)) {
        if ($condition != '') {
            $condition .= " and ";
        }
        $condition .= "(";
        foreach ($selectedTH as $ele) {
            $condition .= "tohop ilike '%$ele%' or ";
        }
        $condition = rtrim($condition, " or ");
        $condition .= ")";
    }

    return $condition == '' ? '' : "WHERE " . $condition;
}

?>

