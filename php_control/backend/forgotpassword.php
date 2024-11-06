<?php
// forgotpassword.php
header('Content-Type: application/json');

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    
    // Xử lý logic gửi email hoặc tìm kiếm email trong DB
    // Giả sử quá trình thành công:
    echo json_encode(array(
        'status' => 'success',
        'message' => 'An email has been sent to reset your password.'
    ));
} else {
    // Trường hợp lỗi: Không nhận được email
    echo json_encode(array(
        'status' => 'error',
        'message' => 'Email is required.'
    ));
}
