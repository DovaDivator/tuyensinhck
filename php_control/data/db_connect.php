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
    // Ghi chú: Không nên sử dụng echo để in ra console từ phía server
    // Việc này không hoạt động trong môi trường web. 
    // Bạn có thể sử dụng log file để ghi nhận thông tin thay vì echo
} catch (PDOException $e) {
    // Ghi lỗi vào log file hoặc xử lý theo cách phù hợp
    error_log('Lỗi kết nối: ' . $e->getMessage());
    // Thay vì echo, bạn có thể thông báo lỗi cho người dùng nếu cần
    die('Không thể kết nối đến cơ sở dữ liệu.'); // Kết thúc script
}

// Bạn có thể sử dụng $pdo để thực hiện các truy vấn sau này
?>