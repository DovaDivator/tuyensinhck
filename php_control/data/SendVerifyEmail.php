<?php 
session_start();
$apiUrl = 'https://iwelyvdecathaeppslzw.supabase.co/auth/v1/magiclink';
$apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Iml3ZWx5dmRlY2F0aGFlcHBzbHp3Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAxMTgzMDAsImV4cCI6MjA0NTY5NDMwMH0.QY-EVOhlyYJXIJqzummyUblLmGQR3JPt2U0IWfPXLwY";

if(isset($_SESSION['email_confirm'])){
    $data = [
        "email" => $_SESSION['email_confirm'],
        "type" => "email"
    ];
    unset($_SESSION['email_confirm']);
}else{
    echo 0;
    exit();
}


// Khởi tạo cURL
$ch = curl_init($apiUrl);

// Thiết lập các tùy chọn cho cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'apikey: ' . $apiKey,
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Gửi yêu cầu và nhận phản hồi
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

file_put_contents("log.txt", $response);

curl_close($ch);

// Kiểm tra mã phản hồi
echo $httpCode;
exit();
?>