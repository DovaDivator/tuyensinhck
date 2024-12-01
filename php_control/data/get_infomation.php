<?php
include 'db_connect.php';
function get_user_info($username) {
    global $pdo;

    // Thực hiện truy vấn để lấy thông tin người dùng từ hàm get_email_user
    $query = "SELECT * FROM get_user_info(:info)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':info', $username);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC); 
    // Trả về: table_name, email, id, phone, avatar_name, trang_thai
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

    $query = "select au.created_at 
            from auth.users au
            where au.email = (select ur.email from public.user ur where ur.id_user = :id);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['created_at'] : ''; 
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
?>
