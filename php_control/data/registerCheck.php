<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = ucwords($_POST["username"]);
    $email = $_POST['email'];
    $password = $_POST["password"];
    unset($_POST);
    $_POST = array();
    
    // Thực hiện truy vấn SQL
    $query = "SELECT * FROM user where email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $responseData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($responseData) {
        echo "error: Đã có người dùng sử dụng email này, vui lòng thay email khác hoặc liên hệ với trung tâm hỗ trợ.";
    } else { 
        if (addStudent($username, $email, $password)) {
            echo "success";
        } else {
            echo "error: Có sự cố xảy ra khi thêm thông tin của bạn";
        }
    }
} else {
    echo "error: Lỗi PHP request";
}
exit();

// Hàm thêm thông tin sinh viên vào bảng sinh_vien
function addStudent($username, $email, $password) {
    global $pdo; // Biến PDO kết nối database

    try {
        // Tạo id_user mới
        $stmt = $pdo->query("SELECT COALESCE(MAX(CAST(SUBSTRING(stu_id, 3, 8) AS UNSIGNED)), 0) + 1 AS new_order FROM sinh_vien");
        $newOrder = $stmt->fetchColumn();

        // Tạo `stu_id` với định dạng 10 ký tự (2 số đầu là năm '25', 8 số sau là thứ tự)
        $newId = '25' . str_pad($newOrder, 8, '0', STR_PAD_LEFT);

        // Thêm vào bảng user
        $queryUser = "
            INSERT INTO user (id_user, email, password, role, trang_thai)
            VALUES (:id_user, :email, :password, 1, 1)
        ";
        $stmtUser = $pdo->prepare($queryUser);
        $stmtUser->execute([
            ':id_user' => $newId,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_BCRYPT) // Hash mật khẩu an toàn
        ]);

        // Thêm vào bảng sinh_vien
        $queryStudent = "
            INSERT INTO sinh_vien (stu_id, ten)
            VALUES (:stu_id, :ten)
        ";
        $stmtStudent = $pdo->prepare($queryStudent);
        $stmtStudent->execute([
            ':stu_id' => $newId,
            ':ten' => $username
        ]);

        return true; // Thành công
    } catch (PDOException $e) {
        error_log("Lỗi thêm sinh viên: " . $e->getMessage());
        return false; // Thất bại
    }
}

?>
