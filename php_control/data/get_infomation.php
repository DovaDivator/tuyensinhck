<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db_connect.php';
function get_user_info($username) {
    global $pdo;

    $query = "SELECT id_user, email, phone, avatar_name, role, trang_thai FROM user WHERE id_user = :user OR email = :user OR phone = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user', $username);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC); 
    if ($result) {
        switch($result['role']) {
            case 1:
                $table_role = 'sinh_vien';
                $id_name = 'stu_id';
                $result['role'] = 'Student';
                break;
            case 2:
                $table_role = 'giao_vien';
                $id_name = 'gv_id';
                $result['role'] = 'Teacher';
                break;
            case 1510:
                $table_role = 'admin';
                $id_name = 'ad_id';
                $result['role'] = 'Admin';
                break;
            default:
                return [];
        }
        $query_added = "select ten from $table_role where $id_name = :id";
        $stmt_added = $pdo->prepare($query_added);
        $stmt_added->bindParam(':id', $result['id_user']);
        $stmt_added->execute();
        $added_info = $stmt_added->fetch(PDO::FETCH_ASSOC);

        if ($added_info) {
            $result = array_merge($result, $added_info);
        } else {
            $result = [];
        }

        return $result;
    }
}

function GetKhoaDaoTao($id) {
    global $pdo;

    $query = "SELECT khoa FROM public.giao_vien WHERE gv_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['khoa'] : ''; 
}

function GetDateAccCreated($id) {
    global $pdo;

    $query = "select create_at 
            from user
            where id_user = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['create_at'] : ''; 
}

function getNameGV($id){
    global $pdo;
    $sql = "SELECT ten FROM giao_vien WHERE gv_id = :gv_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':gv_id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return !empty($result) ? $result[0]['ten'] : "";
}

function getSV($id){
    global $pdo;
    $sql = "SELECT * FROM sinh_vien WHERE sinh_vien.stu_id = :sv_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':sv_id', $id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC); 
}
?>