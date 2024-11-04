<?php
session_start();

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
    error_log('Lỗi kết nối: ' . $e->getMessage());
    die('Không thể kết nối đến cơ sở dữ liệu.'); // Kết thúc script
}

// Xử lý yêu cầu đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra xem các khóa có tồn tại không
    $username = $_POST["username"]; // Lấy tên đăng nhập từ form
    $password = $_POST["password"]; // Lấy mật khẩu từ form

    // Thực hiện truy vấn SQL
    $query = "SELECT * FROM get_email_user(:id_or_phone)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_or_phone', $username);
    $stmt->execute();
    $responseData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($responseData) {
        // Lấy email và tên bảng từ kết quả trả về
        $email = $responseData['email'];
        $table_name = $responseData['table_name'];

        // Lưu tên bảng vào session
        $_SESSION['temp_role'] = $table_name;

        // Kiểm tra mật khẩu
        if (check_password($email, $password)) {
            // Đăng nhập thành công
            $_SESSION['is_logged_in'] = true;
            $_SESSION['user'] = [
<<<<<<< HEAD
                'username' => $username,
                'role' => $table_name,
                'email' => $email,
=======
                'username' => $check_username,
                'role' => $user['role']
                
>>>>>>> c7fb3121a1fb2c8fb936a7b5aac091272d473712
            ];

            echo "success"; // Trả về chuỗi thành công
        } else {
            echo "error: Mật khẩu không chính xác."; // Trả về chuỗi lỗi mật khẩu
        }
    } else {
        echo "error: Không tìm thấy người dùng.";
    }
    exit();
} else {
    echo "error: Lỗi PHP request";
}

// Hàm kiểm tra mật khẩu
function check_password($email, $password) {
    // Thông tin kết nối đến Supabase
    $apiUrl = "https://iwelyvdecathaeppslzw.supabase.co/auth/v1/token?grant_type=password"; // URL của Supabase Auth
    $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Iml3ZWx5dmRlY2F0aGFlcHBzbHp3Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAxMTgzMDAsImV4cCI6MjA0NTY5NDMwMH0.QY-EVOhlyYJXIJqzummyUblLmGQR3JPt2U0IWfPXLwY"; // Thay thế bằng API Key của bạn

    // Tạo dữ liệu để gửi yêu cầu đăng nhập
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

    // Kiểm tra mã phản hồi
    if ($httpCode == 200) {
        return true; // Mật khẩu đúng
    } else {
        return false; // Mật khẩu sai
    }
}
?>
