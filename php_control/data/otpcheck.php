<?php
session_start();

// Kiểm tra nếu mã OTP và email được gửi qua phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["otp"]) && isset($_POST["email"])) {
    // Lấy mã OTP và email từ request
    $otp = $_POST["otp"];
    $email = $_POST["email"];

    // Supabase API URL và Key (thay bằng URL và API Key của bạn)
    $SUPABASE_API_URL = 'https://iwelyvdecathaeppslzw.supabase.co/auth/v1/verify';
    $SUPABASE_API_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Iml3ZWx5dmRlY2F0aGFlcHBzbHp3Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAxMTgzMDAsImV4cCI6MjA0NTY5NDMwMH0.QY-EVOhlyYJXIJqzummyUblLmGQR3JPt2U0IWfPXLwY';

    // Tạo dữ liệu cho yêu cầu xác thực token từ Supabase
    $data = [
        "type" => "recovery",
        "email" => $email,
        "token" => $otp
    ];

    // Cấu hình cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $SUPABASE_API_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $SUPABASE_API_KEY",
        "apikey: $SUPABASE_API_KEY"
    ]);

    // Gửi yêu cầu và nhận phản hồi từ API
    $response = curl_exec($ch);
    if ($response === false) {
        // Xử lý lỗi cURL
        file_put_contents('otpchecklog.txt', 'cURL Error: ' . curl_error($ch) . PHP_EOL, FILE_APPEND);
        header("Content-Type: application/json", true, 500);
        echo json_encode([
            "statusotp" => "error",
            "messageotp" => "Có lỗi xảy ra khi xác thực mã OTP."
        ]);
        exit;
    }

    // Đóng kết nối cURL
    curl_close($ch);

    // Ghi lại phản hồi từ API
    file_put_contents('otpchecklog.txt', 'API Response: ' . $response . PHP_EOL, FILE_APPEND);
    $result = json_decode($response, true);

    // Kiểm tra phản hồi từ API
    if (isset($result['access_token'])) {
        // OTP hợp lệ, chuyển sang bước khôi phục mật khẩu
        $_SESSION["access_token"] = $result['access_token'];
        header("Content-Type: application/json", true, 200);
        echo json_encode([
            "statusotp" => "success",
            "messageotp" => "Xác thực OTP thành công. Bạn có thể thay đổi mật khẩu."
        ]);
    } else {
        // OTP không hợp lệ hoặc đã hết hạn
        header("Content-Type: application/json", true, 401);
        echo json_encode([
            "statusotp" => "error",
            "messageotp" => "Mã OTP không chính xác hoặc đã hết hạn."
        ]);
    }
    exit;
} else {
    // Không có dữ liệu OTP trong yêu cầu
    header("Content-Type: application/json", true, 400);
    echo json_encode([
        "statusotp" => "error",
        "messageotp" => "Yêu cầu không hợp lệ."
    ]);
    exit;
}
