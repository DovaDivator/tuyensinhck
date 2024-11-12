<?php
session_start();

include "db_connect.php";

// Xử lý yêu cầu đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra xem các khóa có tồn tại không
    $username = $_POST["username"]; // Lấy tên đăng nhập từ form
    $password = $_POST["password"]; // Lấy mật khẩu từ form
    unset($_POST['password']);
    unset($_POST['username']);

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
        $id = $responseData['id'];
        $phone = $responseData['phone'];
        $avatar_name = $responseData['avatar_name'];
        $hoten = $responseData['ten'];
        $trang_thai = $responseData['trang_thai'];

        // Lưu tên bảng vào session
        $_SESSION['temp_role'] = $table_name;

        // Kiểm tra mật khẩu
        $httpAuth = check_password($email, $password);
        if ($httpAuth == 200) {
            // Đăng nhập thành công
            $_SESSION['is_logged_in'] = true;
            $_SESSION['user'] = [
                'username' => $hoten,
                'role' => $table_name,
                'email' => $email,
                'id' => $id,
                'phone' => $phone,
                'avatar_name' => $avatar_name,
                'trang_thai' => $trang_thai,
            ];
            echo "success"; // Trả về chuỗi thành công
        }else if($httpAuth == 401){
            echo "error: Tên đăng nhập hoặc mật khẩu sai.";
        }else{
            echo "error: Có lỗi xảy ra khi kết nối dữ liệu người dùng! $httpAuth";
        }
    } else {
        echo "error: Tên đăng nhập hoặc mật khẩu sai.";
    }
} else {
    echo "error: Lỗi PHP request";
}
exit();

// Hàm kiểm tra mật khẩu
function check_password($email, $password) {
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

    // Giải mã phản hồi JSON của Supabase để phân tích thông báo lỗi
    $responseData = json_decode($response, true);

    // Kiểm tra mã HTTP và nội dung phản hồi để phân biệt lỗi
    if ($httpCode == 400) {
        if (isset($responseData['error_code']) && $responseData['error_code'] === 'email_not_confirmed') {
            $_SESSION['email_confirm'] = $email;
            echo "confirm: Tài khoản chưa được xác thực!";
        } else {
            return "error: Mật khẩu không chính xác!";
        }
    }

    return $httpCode; // Trả về mã HTTP nếu không có lỗi 400
}

?>
