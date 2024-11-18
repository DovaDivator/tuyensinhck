<?php 
session_start();
$apiUrlSignIn = 'https://iwelyvdecathaeppslzw.supabase.co/auth/v1/token?grant_type=password';
$apiUrlUpdatePassword = 'https://iwelyvdecathaeppslzw.supabase.co/auth/v1/user';
$apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Iml3ZWx5dmRlY2F0aGFlcHBzbHp3Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAxMTgzMDAsImV4cCI6MjA0NTY5NDMwMH0.QY-EVOhlyYJXIJqzummyUblLmGQR3JPt2U0IWfPXLwY";

// Kiểm tra nếu form gửi mật khẩu hiện tại, mật khẩu mới và email
if (isset($_POST['current_password'], $_POST['new_password'])) {
    $email = $_SESSION['user']['email'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    unset($_POST);
    $_POST = array();

    // Xác thực mật khẩu hiện tại bằng cách đăng nhập
    $dataSignIn = [
        "email" => $email,
        "password" => $currentPassword
    ];
    
    $chSignIn = curl_init($apiUrlSignIn);
    curl_setopt($chSignIn, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chSignIn, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'apikey: ' . $apiKey
    ]);
    curl_setopt($chSignIn, CURLOPT_POST, true);
    curl_setopt($chSignIn, CURLOPT_POSTFIELDS, json_encode($dataSignIn));
    
    // Gửi yêu cầu đăng nhập để xác thực mật khẩu hiện tại
    $responseSignIn = curl_exec($chSignIn);
    $httpCodeSignIn = curl_getinfo($chSignIn, CURLINFO_HTTP_CODE);
    $signInData = json_decode($responseSignIn, true);
    curl_close($chSignIn);

    // Nếu đăng nhập thành công
    if ($httpCodeSignIn == 200 && isset($signInData['access_token'])) {
        $accessToken = $signInData['access_token'];

        // Gửi yêu cầu cập nhật mật khẩu mới
        $dataUpdatePassword = [
            "password" => $newPassword
        ];
        
        $chUpdatePassword = curl_init($apiUrlUpdatePassword);
        curl_setopt($chUpdatePassword, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chUpdatePassword, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'apikey: ' . $apiKey,
            'Authorization: Bearer ' . $accessToken
        ]);
        curl_setopt($chUpdatePassword, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($chUpdatePassword, CURLOPT_POSTFIELDS, json_encode($dataUpdatePassword));

        // Thực hiện yêu cầu cập nhật mật khẩu
        $responseUpdatePassword = curl_exec($chUpdatePassword);
        $httpCodeUpdatePassword = curl_getinfo($chUpdatePassword, CURLINFO_HTTP_CODE);
        curl_close($chUpdatePassword);

        file_get_contents('log.txt', $responseUpdatePassword);

        // Kiểm tra phản hồi
        if ($httpCodeUpdatePassword == 200) {
            echo "success";
        } else {
            echo "error: Không thể cập nhật mật khẩu. Vui lòng thử lại sau. ($httpCodeUpdatePassword)";
        }
    } else {
        echo "error: Mật khẩu hiện tại không đúng.";
    }
} else {
    echo "error: Dữ liệu không hợp lệ.";
}
exit();
