<?php
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
?>