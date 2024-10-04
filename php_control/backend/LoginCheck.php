<?php
session_start();

$users = [
    'student' => [
        'username' => 'student',
        'password' => '123456',
        'role' => 'Student'
    ],
    'teacher' => [
        'username' => 'teacher',
        'password' => '123456',
        'role' => 'Teacher'
    ],
    'admin' => [
        'username' => 'admin',
        'password' => '123456',
        'role' => 'Admin'
    ]
];

$response = [
    'success' => false
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check_username = $_POST["username"];
    $check_password = $_POST["password"];

    foreach ($users as $user) {
        if ($user['username'] == $check_username && $user['password'] == $check_password) {
            $_SESSION['is_logged_in'] = true;
            $_SESSION['user'] = [
                'username' => $check_username,
                'role' => $user['role']
            ];

            $response['success'] = true;
            break;
        }
    }

    echo json_encode($response);
    exit();
}
?>

