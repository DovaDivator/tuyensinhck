<!-- Hàm kiểm tra trang đã đăng nhập chưa -->
<?php

session_start();
if (isset($_SESSION['user'])) {
    //echo "<script>alert('welcom');</script>";
} else {
    //echo "<script>alert('pls login');</script>";
    header("Location: login.php");
    exit();
}
// if (isset($_SESSION['message'])) {
//     echo "<script>alert('" . $_SESSION['message'] . "');</script>"; 
//     unset($_SESSION['message']); 
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
    <script src="../js_backend/control.js?v=<?php echo filemtime('../js_backend/control.js'); ?>"></script>
</head>
<body>
    <div class="body_container">
        <?php include '../php_control/path_side/nav_toggle.php'; ?>
        <?php include '../php_control/path_side/sidebar.php'; ?>

        <div class="notification layout" id="notificationLayout">
            <?php include '../php_control/path_side/notification.php'; ?>
        </div>
        
        <div class="right-side">
            <?php include '../php_control/path_side/toolbar.php'; ?>
            <!-- Nội dung chính kết nối trang -->
            <div class="main-content">
            <div class="body_container">
                <?php 
                    if($_SESSION['user']['role'] === 'Student'){
                        include '../php_control/path_side/DangKyBar.php';
                    } 
                ?>
                <div class="body_path">
                    <h1>Trang chủ tuyển sinh</h1> 
                    <h3 style="padding-left: 50px; color:#DC143C;">
                        <?php 
                            if($_SESSION['user']['role'] === 'Teacher'){
                                echo "Danh sách các ngành hiện tại đang mở!";
                            } else if($_SESSION['user']['role'] === 'Student'){
                                echo "Danh sách các ngành đảm nhiệm";
                            } else if($_SESSION['user']['role'] === 'Admin'){
                                echo "Danh sách chương trình đào tạo";
                            } else {
                                echo "<script>console.log('Lỗi xác định SESSION['user']['role']')</script>";
                            }
                        ?>
                    </h3>
                        <form action="search.php"  class='linediv' method="GET" style='margin:0 0 10px 30px;'>
                            <div class="search-container">
                            <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm..." class="search-input">
                            <button type="submit" class="search-button">
                                <img src="../assets/icon/search.png?v=<?php echo filemtime('../assets/icon/search.png'); ?>" 
                                title="Tìm kiếm" class="search-icon">
                            </button>
                            </div>
                            <button type="button" class="icon-button">
                                <img src="../assets/icon/filter_tag.png?v=<?php echo filemtime("../assets/icon/filter_tag.png"); ?>" 
                                alt="Tùy chọn" title="Tùy chọn" class="chart_option" onclick="showChartOption('options layout chart_div_options')">
                            </button>
                        </form>
                    <div class="table_hold">
                        <?php 
                            include '../php_control/path_side/table_nganh.php'; 
                            if($_SESSION['user']['role'] === 'Student'){
                                echo '<a href="#">&gt;&gt; Tra cứu toàn bộ chương trình đào tạo</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../php_control/backend/Logout.php' ?> 
</body>
</html>


<!-- Log kiểm tra dữ liệu, không được xóa -->
<?php
echo '<script>';
echo 'var sessionData = ' . json_encode($_SESSION) . ';';
echo 'console.log("Session Data:", sessionData);';

echo 'var getData = ' . json_encode($_GET) . ';';
echo 'console.log("GET Data:", getData);';

echo 'var postData = ' . json_encode($_POST) . ';';
echo 'console.log("POST Data:", postData);';
echo '</script>';
?>