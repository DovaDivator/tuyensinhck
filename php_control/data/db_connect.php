<?php
// Thông tin kết nối đến Supabase
$username = "postgres.iwelyvdecathaeppslzw";
$password = "123456a@tuyensinh"; // Thay thế bằng mật khẩu thực tế của bạn
$host = "aws-0-ap-southeast-1.pooler.supabase.com"; // Host của Supabase
$port = "6543"; // Port mà Supabase sử dụng
$dbname = "postgres"; // Tên cơ sở dữ liệu

// Tạo chuỗi kết nối DSN (Data Source Name)
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

try {
    // Kết nối đến PostgreSQL bằng PDO
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Ghi lỗi vào log file hoặc xử lý theo cách phù hợp
    $errorMessage = 'Lỗi kết nối: ' . $e->getMessage();
    // error_log($errorMessage, 3, 'logfile.log');
    die('Không thể kết nối đến cơ sở dữ liệu.'); // Kết thúc script
}
?>
