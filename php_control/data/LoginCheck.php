<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kết nối đến cơ sở dữ liệu (db_connect.php)
include "db_connect.php";
include 'get_infomation.php';

// Hàm kiểm tra mật khẩu và lấy token từ Supabase
function check_password($user, $password){
    global $pdo;

    try {
        // Truy vấn lấy mật khẩu đã băm từ cơ sở dữ liệu
        $query = "SELECT password FROM user WHERE id_user = :user OR email = :user OR phone = :user";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user', $user, PDO::PARAM_STR);
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($password, $result['password'])) {
            // Mật khẩu khớp
            return true;
        } else {
            // Mật khẩu không khớp
            return false;
        }
    } catch (PDOException $e) {
        // Ghi log lỗi nếu cần
        error_log("Lỗi kiểm tra mật khẩu: " . $e->getMessage());
        return false; // Trả về false khi có lỗi
    }
}

// Xử lý yêu cầu đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin từ form đăng nhập
    $username = $_POST["username"];
    $password = $_POST["password"];
    unset($_POST); // Xoá dữ liệu POST
    $_POST = array();

    //file_put_contents("log.txt", "email: $email\n", FILE_APPEND);
     

    if (check_password($username, $password)) {
        // Đăng nhập thành công

        $userInfo = get_user_info($username);
        if ($userInfo) {

            $_SESSION['user'] = [
                'username' => $userInfo['ten'],
                'role' => $userInfo['role'],
                'email' => $userInfo['email'],
                'id' => $userInfo['id_user'],
                'phone' => $userInfo['phone'],
                'avatar_name' => isValidLink($userInfo['avatar_name']),
                'trang_thai' => $userInfo['trang_thai']
            ];
                
            echo "success";
        }else{
            echo "error: Có sự cố khi truy cập dữ liệu người dùng.";
        }
    } else {
        echo "Tên đăng nhập hoặc mật khẩu không đúng";
    }
} else {
    echo "error: Lỗi PHP request";
}
exit();

function isValidLink($url) {
    return empty($url) ? '' : $url = 'data:image/png;base64,' . base64_encode($url);
}
?>