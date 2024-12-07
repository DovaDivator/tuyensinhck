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

    return $condition == '' ? '' : "WHERE " . $condition;
}

function getConditionDSGV($query, $khoa, $ma_nganh) {
    $condition = '';
    
    if ($query!= '') {
        $condition.= " (id ilike '%$query%' or ten ilike '%$query%')";
    }

    if (!empty($khoa)) {
        if ($condition != '') {
            $temp = " and ";
        }else{
            $temp = "";
        }
        $condition .= $temp ."khoa = '$khoa'";
    }

    if (!empty($ma_nganh)) {
        if ($condition != '') {
            $temp = " and ";
        }else{
            $temp = "";
        }
        if($ma_nganh == 'Chưa phụ trách'){
            $condition .= $temp."list_nganh is NULL";
        }else{
            $condition .= $temp."list_nganh ilike '%$ma_nganh%'";
        }

    }

    return $condition == '' ? '' : "WHERE " . $condition;
}

function getConditionDSSV($query, $trang_thai, $date_created, $hinh_thuc){
    $condition = '';
    
    if ($query!= '') {
        $condition.= " (id ilike '%$query%' or ten ilike '%$query%')";
    }

    if (!empty($trang_thai)) {
        if((int)$trang_thai >= 1 && (int)$trang_thai <= 6 ) {
            if ($condition != '') {
                $condition .= " and ";
            }
            $condition .= "trang_thai = ".$trang_thai;
        }
    }

    if ($date_created != '') {
        if ($condition != '') {
            $temp = " and ";
        }else{
            $temp = "";
        }
        switch ($date_created) {
            case 1:
                $condition .= $temp." create_date BETWEEN NOW() - INTERVAL '1 day' AND NOW();";
                break;
            case 2:
                $condition .= $temp." create_date BETWEEN NOW() - INTERVAL '7 days' AND NOW();";
                break;
            case 3:
                $condition .= $temp." create_date BETWEEN NOW() - INTERVAL '1 month' AND NOW();";
                break;
            case 4:
                $condition .= $temp." create_date BETWEEN NOW() - INTERVAL '3 months' AND NOW();";
                break;
            default:
            break;
        }
    }

    if (!empty($hinh_thuc) || $hinh_thuc != '0') {
        if ($condition!= '') {
            $temp = " and ";
        } else{
            $temp = "";
        }
        if($hinh_thuc == '1'){
            $condition .= $temp."htts_id is NULL";
        }else{
            $condition .= $temp." htts_id = '$hinh_thuc'";
        }
    }


    return $condition == '' ? '' : "WHERE " . $condition;
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