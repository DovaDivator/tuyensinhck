<?php
session_start();

include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST['email'];
    $password = $_POST["password"];
    unset($_POST["password"]);
    unset($_POST["username"]);
    unset($_POST["email"]);
    
    // Thực hiện truy vấn SQL
    $query = "SELECT * FROM get_email_user(:id_or_phone)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_or_phone', $email);
    $stmt->execute();
    $responseData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($responseData) {
        echo "error: Đã có người dùng sử dụng email này, vui lòng thay email khác hoặc liên hệ với trung tâm hỗ trợ.";
    } else {
        // Tạo người dùng mới
        $httpAuth = CreateUser($email, $password);   
        if ($httpAuth === 200) {
            echo "success";
        }else{
            echo "error: Xảy ra lỗi khi tạo người dùng mới. ($httpAuth)";
        }
    }
    exit();
} else {
    echo "error: Lỗi PHP request";
}

function CreateUser($email, $password) {
    // Thông tin kết nối đến Supabase
    $apiUrl = "https://iwelyvdecathaeppslzw.supabase.co/auth/v1/signup";
    $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Iml3ZWx5dmRlY2F0aGFlcHBzbHp3Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAxMTgzMDAsImV4cCI6MjA0NTY5NDMwMH0.QY-EVOhlyYJXIJqzummyUblLmGQR3JPt2U0IWfPXLwY"; // Thay thế bằng API Key của bạn


    // Tạo dữ liệu để gửi yêu cầu
    $data = [
        "email" => $email,
        "password" => $password
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
    
    // Kiểm tra mã phản hồi
    return $httpCode;
}
?>

