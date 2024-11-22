<?php
session_start();

// Kết nối đến cơ sở dữ liệu (db_connect.php)
include "db_connect.php";
include 'get_infomation.php';

// Hàm lấy thông tin người dùng từ cơ sở dữ liệu hoặc Supabase
function get_email($username)
{
    global $pdo; // Sử dụng kết nối PDO từ db_connect.php

    // Thực hiện truy vấn để lấy thông tin người dùng từ hàm get_email_user
    $query = "SELECT * FROM get_email_user(:id_or_phone)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_or_phone', $username);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về thông tin người dùng
}


// Hàm kiểm tra mật khẩu và lấy token từ Supabase
function check_password($email, $password)
{
    // Thông tin kết nối đến Supabase
    $apiUrl = "https://iwelyvdecathaeppslzw.supabase.co/auth/v1/token?grant_type=password";
    $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Iml3ZWx5dmRlY2F0aGFlcHBzbHp3Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAxMTgzMDAsImV4cCI6MjA0NTY5NDMwMH0.QY-EVOhlyYJXIJqzummyUblLmGQR3JPt2U0IWfPXLwY";

    // Dữ liệu đăng nhập
    $data = [
        "email" => $email,
        "password" => $password,
    ];

    // Khởi tạo cURL
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . $apiKey,
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Gửi yêu cầu và nhận phản hồi
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Giải mã phản hồi JSON của Supabase
    $responseData = json_decode($response, true);

    if ($httpCode === 200) {
        return $responseData; // Trả về Access Token và Refresh Token nếu thành công
    } elseif ($httpCode === 400) {
        if (isset($responseData['error_code']) && $responseData['error_code'] === 'email_not_confirmed') {
            $_SESSION['email_confirm'] = $email;
            return "confirm: Tài khoản chưa được xác thực!";
        } else {
            return "error: Mật khẩu không chính xác!";
        }
    }

    return $httpCode; // Trả về mã HTTP nếu không có lỗi 400
}

// Xử lý yêu cầu đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin từ form đăng nhập
    $username = $_POST["username"];
    $password = $_POST["password"];
    unset($_POST); // Xoá dữ liệu POST
    $_POST = array();

    // Lấy thông tin người dùng từ cơ sở dữ liệu
    $emailInfo = get_email($username);

    if ($emailInfo) {
        // Lấy thông tin người dùng từ kết quả trả về
        $email = $emailInfo['email'];
        //file_put_contents("log.txt", "email: $email\n", FILE_APPEND);

        // Kiểm tra mật khẩu và lấy token
        $authResponse = check_password($email, $password);

        if (is_array($authResponse) && isset($authResponse['access_token'])) {
            // Đăng nhập thành công

            $userInfo = get_user_info($email);
            if ($userInfo) {

                $_SESSION['access_token'] = $authResponse['access_token']; // Lưu Access Token
                $_SESSION['refresh_token'] = $authResponse['refresh_token']; // Lưu Refresh Token

                $_SESSION['user'] = [
                    'username' => $userInfo['ten'],
                    'role' => $userInfo['table_name'],
                    'email' => $userInfo['email'],
                    'id' => $userInfo['id'],
                    'phone' => $userInfo['phone'],
                    'avatar_name' => isValidLink('https://iwelyvdecathaeppslzw.supabase.co/storage/v1/object/public/avatar/'.$userInfo['avatar_name']),
                    'trang_thai' => $userInfo['trang_thai']
                ];
                
                echo "success";
            }else{
                echo "error: Có sự cố khi truy cập dữ liệu người dùng.";
            }
        } else {
            echo "error: Tên đăng nhập hoặc mật khẩu sai.";
        }
    } else {
        echo "error: Tên đăng nhập hoặc mật khẩu sai.";
    }
} else {
    echo "error: Lỗi PHP request";
}
exit();

function isValidLink($url) {
    // Sử dụng cURL để kiểm tra mã HTTP
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true); // Chỉ lấy mã trạng thái, không tải nội dung
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Giới hạn thời gian chờ
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200){
        return $url;
    }else{
        return '';
    }
}
?>