<!-- Hàm kiểm tra trang đã đăng nhập chưa -->
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Tuyển sinh - Trang chủ</title>
    <link rel="icon" href="../assets/images/logo.png" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css">
</head>
<body>
    
</body>
</html>