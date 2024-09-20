<?php

session_start();


$test_username = "admin";
$test_password = "123456789";


$is_logged_in = false;

if ($_SERVER["REQUEST_METHOD"] == "POST"){

// Lấy dữ liệu từ form POST
$check_username = $_POST["username"];
$check_password = $_POST["password"];

// Kiểm tra username và password
if ($test_username == $check_username && $test_password == $check_password) {
    // Đăng nhập thành công
    $is_logged_in = true;  // Đặt biến thành true

    // Lưu trạng thái đăng nhập vào session
    $_SESSION['is_logged_in'] = $is_logged_in;

    // Chuyển hướng đến trang index.php
    header("Location: index.php");
    exit();
} else {
    // Đăng nhập thất bạ    i
    $is_logged_in = false;  // Đặt biến thành false

    // Lưu trạng thái đăng nhập thất bại vào session (có thể không cần thiết)
    $_SESSION['is_logged_in'] = $is_logged_in;

    // Chuyển hướng về trang login với thông báo lỗi
    echo "<script>alert('Invalid username or password.');</script>";
    exit();
}
} 
exit();

?>

