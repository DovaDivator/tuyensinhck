<?php
session_start();

$response = [
    'success' => false,
    'message' => '',
    'contact' => '',
    'passwordcheck' => ''
];

function validateInput($input) {
    // Biểu thức chính quy cho email
    $emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    // Biểu thức chính quy cho số điện thoại (có thể thay đổi theo định dạng bạn muốn)
    $phonePattern = '/^\d{10,15}$/'; // 10 đến 15 chữ số

    if (preg_match($emailPattern, $input)) {
        return "email";
    } elseif (preg_match($phonePattern, $input)) {
        return "phone";
    } else {
        return "invalid";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //$name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $contactinfor = trim($_POST['email']);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["password_check"]);
    $result = validateInput($contactinfor);
    // Kiểm tra các trường bắt buộc
    if ( empty($username)) {
        $response['message'] = 'username is required';
    }elseif(empty($contactinfor)){
        $response['message'] = 'enter the contactinfor';
    } 
    elseif(empty($password)){
        $response['message'] = 'enter the password';
    }
    elseif(empty($confirm_password)){
        $response['message'] = 'enter the password check';
    }
    elseif (!isset($_POST['accept'])) {
        $response['message'] = "please accept our terms and conditions";
    }
    elseif($result === 'invalid'){
        $response['message'] ='Invalid contactinfor';
        $response['contact'] = ' email/phone number';
    }
    elseif (strlen($password) < 6 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $response['message'] = 'Invalid password';
        $response['passwordcheck'] = 'password must > 6 and have atleast 1 uppercase, 1 number';;
    } elseif ($password !== $confirm_password) {
        $response['message'] = 'password and confirm password not match';
    }  else {
        $response['success'] = true;
        $response['message'] = 'Đăng ký thành công!';
    }

    // Đảm bảo không có nội dung nào khác ngoài JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    $response['message'] = 'Phương thức không hợp lệ.';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>