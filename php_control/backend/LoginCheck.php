<?php

session_start();


$test_username = "admin";
$test_password = "123456";
$Role = "Student"; // đổi role ở đây (admin, Student, Teacher)

$is_logged_in = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $check_username = $_POST["username"];
    $check_password = $_POST["password"];


    if ($test_username == $check_username && $test_password == $check_password) {

        $is_logged_in = true;
        $_SESSION['is_logged_in'] = $is_logged_in;
        $_SESSION['user'] = [
            'username' => $check_username,
            'role' => 'admin', //cái này là tạm thời
        ];
        // $_SESSION['message'] = "Login succes, Welcom";
        header("Location: index.php");
        //echo '<meta http-equiv="refresh" content="0;url=login.php">'; cái này load sẽ nhanh hơn nhưng bị lỗi  anh có thể xem thử 
        exit();
    } else {

        $is_logged_in = false;
        $_SESSION['is_logged_in'] = $is_logged_in;
        echo "<script>alert('Invalid username or password.');</script>";
        exit();
    }
}

