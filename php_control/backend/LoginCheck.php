<?php
session_start();

$test_username = "admin";
$test_password = "123456";

$response = [
    'success' => false
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check_username = $_POST["username"];
    $check_password = $_POST["password"];

    if ($test_username == $check_username && $test_password == $check_password) {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['user'] = [
            'username' => $check_username,
            'role' => 'Admin', // Tạm thời đặt là admin
        ];

        $response['success'] = true;
    }

    echo json_encode($response);
    exit();
}
?>
