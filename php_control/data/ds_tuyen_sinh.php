<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db_connect.php';

function getDSTuyenSinh($query, $status, $selectedTH){
    $condition = getConditionNganh($query, $status, $selectedTH);

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

function getDSGV($query, $khoa, $ma_nganh){
    global $pdo;
    $condition = getConditionDSGV($query, $khoa, $ma_nganh);
    $query_input = "SELECT * FROM get_list_gv_admin()".$condition;
    $stmt = $pdo->prepare($query_input);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    foreach ($courses as &$course) {
        if (isset($course['create_date'])) {
            $course['create_date'] = (new DateTime(substr($course['create_date'], 0, 19)))->format('(H\hi) d/m/Y');
        }
    }
    return $courses;
}

function getDSSV($query, $trang_thai, $date_created, $hinh_thuc){
    global $pdo;
    $condition = getConditionDSSV($query, $trang_thai, $date_created, $hinh_thuc);
    $query_input = "SELECT * FROM get_list_sv_admin()".$condition;
    $stmt = $pdo->prepare($query_input);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);    
    foreach ($courses as &$course) {
        if (isset($course['create_date'])) {
            $course['create_date'] = (new DateTime(substr($course['create_date'], 0, 19)))->format('(H\hi) d/m/Y');
        }
    }
    return $courses;
}

function fetachListNganhUser(){
    global $pdo;
    $query = "SELECT * FROM get_list_nganh_user()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);    
    foreach ($courses as &$course) {
        if (isset($course['create_date'])) {
            $course['create_date'] = (new DateTime(substr($course['create_date'], 0, 19)))->format('(H\hi) d/m/Y');
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
    $query = "
    SELECT 
        ng.nganh_id AS id,
        ng.ten_nganh AS ten,
        CAST(ng.id_tohop AS CHAR) AS tohop,
        CAST(ng.date_end AS DATETIME) AS date_end,
        COUNT(sv.nganh_id) AS slsv
    FROM nganh ng
    LEFT JOIN sinh_vien sv ON ng.nganh_id = sv.nganh_id  
    WHERE ng.isEnable AND CAST(ng.gv_id AS CHAR) = :id $condition
    GROUP BY ng.nganh_id, ng.ten_nganh, ng.id_tohop, ng.date_end;
";
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

function getConditionNganh($query, $status, $selectedTH) {
    $condition = '';
    
    if ($query != '') {
        $condition .= " (id ilike '%$query%' or ten ilike '%$query%')";
    }

    if ($status != '') {
        if ($condition != '') {
            $temp = " and ";
        }else{
            $temp = "";
        }
        switch ($status) {
            case 'sapmo':
                $condition .= $temp. ' isenable = 1';
                break;
            case 'dangmo':
                $condition .= $temp. ' isenable = 2';
                break;
            case 'dadong':
                $condition .= $temp.' isenable = 3';
                break;
            case 'dangan':
                $condition .= $temp. ' isenable = 0';
                break;
            default:
            break;
        }
    }

    if (!empty($selectedTH)) {
        if ($condition != '') {
            $temp = " and ";
        }else{
            $temp = "";
        }
        $condition .= $temp. "(";
        foreach ($selectedTH as $ele) {
            $condition .= "tohop ilike '%$ele%' or ";
        }
        $condition = rtrim($condition, " or ");
        $condition .= ")";
    }

    return $condition == '' ? '' : "AND " . $condition;
}

function getConditionDSGV($query) {
    $condition = '';
    
    if ($query!= '') {
        $condition.= " (id ilike '%$query%' or ten ilike '%$query%')";
    }

    return $condition == '' ? '' : "AND " . $condition;
}

function getConditionDSSV($query){
    $condition = '';
    
    if ($query!= '') {
        $condition.= " (id ilike '%$query%' or ten ilike '%$query%')";
    }

    return $condition == '' ? '' : "AND " . $condition;
}

function GetKhoaDaoTao() {
    global $pdo;
    $query = "SELECT DISTINCT khoa FROM public.giao_vien";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về tất cả kết quả
}

function GetMaNganh(){
    global $pdo;
    $query = "SELECT DISTINCT nganh_id FROM public.nganh";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về tất cả kết quả
}

function GetHinhThucXetTuyen(){
    global $pdo;
    $query = "SELECT DISTINCT ma_htts FROM public.hinh_thuc_xet_tuyen";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về tất cả kết quả
}
?>