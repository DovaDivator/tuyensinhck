<?php
session_start();

// Kiểm tra nếu mã OTP được gửi qua phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["otp"]) && isset($_POST["email"])) {
    // Lấy mã OTP và email từ request
    $otp = $_POST["otp"];
    $email = $_POST["email"];

    // API key và URL Supabase (đảm bảo thay thế giá trị này bằng của bạn)
    $SUPABASE_API_URL = 'https://iwelyvdecathaeppslzw.supabase.co/auth/v1/recover';
    $SUPABASE_API_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Iml3ZWx5dmRlY2F0aGFlcHBzbHp3Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAxMTgzMDAsImV4cCI6MjA0NTY5NDMwMH0.QY-EVOhlyYJXIJqzummyUblLmGQR3JPt2U0IWfPXLwY';

    // Gửi yêu cầu xác thực OTP tới Supabase
    $data = [
        "email" => $email,
        "otp" => $otp
    ];

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

    // Gửi yêu cầu và nhận phản hồi
    $response = curl_exec($ch);

    // Kiểm tra lỗi cURL
    if ($response === false) {
        // Xử lý lỗi cURL
        file_put_contents('otpchecklog.txt', 'cURL Error: ' . curl_error($ch) . PHP_EOL, FILE_APPEND);
        die('Có lỗi xảy ra khi xác thực OTP');
    }

    // Đóng kết nối cURL
    curl_close($ch);

   // Ghi lại phản hồi từ API
   file_put_contents('otpchecklog.txt', 'API Response: ' . $response . PHP_EOL, FILE_APPEND);    // Phản hồi từ Supabase
   $result = json_decode($response);
   file_put_contents('otpchecklog.txt', 'Decoded result: ' . print_r($result, true) . PHP_EOL, FILE_APPEND);

    if (isset($result->status) && $result->status === 'success') {
        // Nếu OTP hợp lệ
        $response = [
            "statusotp" => "success",
            "messageotp" => "Xác nhận OTP thành công."
        ];
    } else {
        // Nếu OTP không hợp lệ
        $response = [
            "statusotp" => "error",
            "messageotp" => "Mã OTP không chính xác hoặc đã hết hạn."
        ];
    }

    // Trả về phản hồi dưới dạng JSON
    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
} else {
    // Nếu không có dữ liệu OTP trong request
    $response = [
        "statusotp" => "error",
        "messageotp" => "Yêu cầu không hợp lệ."
    ];

    // Trả về phản hồi dưới dạng JSON
    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}
?>
