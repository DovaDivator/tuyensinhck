<?php 
session_start();
include "db_connect.php";

$apiUrlRecover = 'https://iwelyvdecathaeppslzw.supabase.co/auth/v1/recover';
$apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Iml3ZWx5dmRlY2F0aGFlcHBzbHp3Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAxMTgzMDAsImV4cCI6MjA0NTY5NDMwMH0.QY-EVOhlyYJXIJqzummyUblLmGQR3JPt2U0IWfPXLwY";

// Kiểm tra xem email có được truyền vào từ form không
if (isset($_POST['email'])) {
    $email = $_POST['email'];
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Lỗi PHP request!"
    ]);
    exit();
}


// Khởi tạo cURL để kiểm tra sự tồn tại của email trong hệ thống
$query = "SELECT * FROM get_email_user(:id_or_phone)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_or_phone', $email);
$stmt->execute();
$responseData = $stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra nếu không tìm thấy email trong hệ thống
if ($responseData) {
    // Nếu email tồn tại, gửi yêu cầu khôi phục mật khẩu
$data = ["email" => $email];
$chRecover = curl_init($apiUrlRecover);
curl_setopt($chRecover, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chRecover, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'apikey: ' . $apiKey,
    'Authorization: Bearer ' . $apiKey
]);
curl_setopt($chRecover, CURLOPT_POST, true);
curl_setopt($chRecover, CURLOPT_POSTFIELDS, json_encode($data));

// Gửi yêu cầu khôi phục mật khẩu và nhận phản hồi
$responseRecover = curl_exec($chRecover);
$httpCodeRecover = curl_getinfo($chRecover, CURLINFO_HTTP_CODE);
curl_close($chRecover);

// Ghi log vào file log.txt
// file_put_contents("log.txt", "HTTP Code: $httpCodeRecover\nResponse: $responseRecover\n", FILE_APPEND);

// Kiểm tra mã trạng thái HTTP và phản hồi cho người dùng
if ($httpCodeRecover == 200) {
    echo json_encode([
        "status" => "success",
        "message" => "Đã gửi email khôi phục mật khẩu. Vui lòng kiểm tra hộp thư để tiếp tục."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Không thể gửi email khôi phục mật khẩu. Vui lòng thử lại sau. ($httpCodeRecover)"
    ]);
}
    exit();
}else{
    echo json_encode([
        "status" => "error",
        "message" => "Email không tồn tại trong hệ thống."
    ]);
    exit();
}
?>
