<?php
// registerCheck.php
session_start();

$response = [
    'success' => false,
    'message' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $_checkbox =trim($_POST['accept']);

    // Kiểm tra các trường bắt buộc
    if (empty($name) || empty($username) || empty($password) || empty($confirm_password) || empty($_checkbox)) {
        $response['message'] = 'Tất cả các trường là bắt buộc.';
    } elseif (strlen($username) < 5) {
        $response['message'] = 'Tên đăng nhập phải có ít nhất 5 ký tự.';
    } elseif ($password !== $confirm_password) {
        $response['message'] = 'Mật khẩu không khớp.';
    } elseif (strlen($password) < 8) {
        $response['message'] = 'Mật khẩu phải có ít nhất 8 ký tự.';
    } else {
        
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Lưu vào cơ sở dữ liệu...

        $response['success'] = true;
        $response['message'] = 'Đăng ký thành công!';
    }
    
    // Trả về phản hồi dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>
