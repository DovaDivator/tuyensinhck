<!-- Hàm kiểm tra trang đã đăng nhập chưa -->
<?php
// Bắt đầu session để truy cập trạng thái đăng nhập
session_start();

// Kiểm tra nếu biến session tồn tại và giá trị là true
// if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
//     // echo "Đã đăng nhập thành công!";
// } else {
//     // Nếu chưa đăng nhập hoặc đăng nhập thất bại, chuyển hướng về trang đăng nhập
//     header("Location: login.php");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Tuyển sinh - Trang chủ</title>
    <link rel="icon" href="../assets/images/logo.png?v=<?php echo filemtime('../assets/images/logo.png'); ?>" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css?v=<?php echo filemtime('../assets/style/style.css'); ?>">
    <script src="../js_backend/events.js?v=<?php echo filemtime('../js_backend/events.js'); ?>"></script>
</head>
<body>
    <div class="body_container">
        <?php include '../php_control/path_side/nav_toggle.php'; ?>
        <?php include '../php_control/path_side/sidebar.php'; ?>

        <div class="notification layout">
            <?php include '../php_control/path_side/notification.php'; ?>
        </div>
        
        <div class="right-side">
            <?php include '../php_control/path_side/toolbar.php'; ?>
            <!-- Nội dung chính kết nối trang -->
            <div class="main-content">
                <?php include '../php_control/admin_path/Thongke.php'; ?>    
            </div>
        </div>
    </div>
</body>
</html>