<!-- Hàm kiểm tra trang đã đăng nhập chưa -->
<?php
// session_start();

// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Tuyển sinh - </title>
    <link rel="icon" href="../assets/images/logo.png" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css">
    <script src="../js_backend/events.js"></script>
</head>
<body>
<div class="container">
        <?php include '../php_control/path_side/nav_toggle.php'; ?>
        <?php include '../php_control/path_side/sidebar.php'; ?>
        
        <div class="right-side">
            <?php include '../php_control/path_side/toolbar.php'; ?>
            <!-- Nội dung chính -->
            <div class="main-content">
                <h1>Chào mừng đến với Website</h1>
                <p>Đây là phần nội dung chính của trang web.</p>
            </div>

            <?php include '../php_control/path_side/footer.php'; ?>
        </div>
    </div>
</body>
</html>