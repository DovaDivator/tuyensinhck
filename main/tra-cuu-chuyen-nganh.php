<!-- Hàm kiểm tra trang đã đăng nhập chưa -->
<?php
session_start();
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] == "Admin") {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}

include '../php_control/data/ds_tuyen_sinh.php';


$ds_tuyen_sinh = fetachListNganhUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Tuyển sinh - Trang chủ</title>
    <link rel="icon" href="../assets/images/logo.png?v=<?php echo filemtime('../assets/images/logo.png'); ?>" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css?v=<?php echo filemtime('../assets/style/style.css'); ?>">
    <link rel="stylesheet" href="../assets/style/trangchu.css?v=<?php echo filemtime('../assets/style/trangchu.css'); ?>">
    <link rel="stylesheet" href="../assets/style/table.css?v=<?php echo filemtime("../assets/style/table.css")?>"> 

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
                            if($_SESSION['user']['role'] === 'Student'){
                                echo "Danh sách các ngành hiện tại đang mở!";
                            } else if($_SESSION['user']['role'] === 'Teacher'){
                                echo "Danh sách các ngành đảm nhiệm";
                            } else if($_SESSION['user']['role'] === 'Admin'){
                                echo "Danh sách chương trình đào tạo";
                            } else {
                                echo "<script>console.log('Lỗi xác định SESSION['user']['role']')</script>";
                            }
                        ?>
                    </h3>
                    <div class="table_hold">
                        <form action="" id="search_form" class='linediv' method="GET" style='margin-bottom: 10px;'>
                            <div class="search-container">
                                <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm..." class="search-input">
                                <button type="submit" class="search-button">
                                    <img src="../assets/icon/search.png?v=<?php echo filemtime('../assets/icon/search.png'); ?>" 
                                    title="Tìm kiếm" class="search-icon">
                                </button>
                            </div>
                        </form>
                        <div class="table_body_scroll" style="height:600px;">
                            <table class="choose_list nganh_hoc" id="top_list_nganh">
                                <thead>
                                    <tr>
                                        <th id='ma_nganh'>Mã tuyển sinh</th>
                                        <th id='ten_nganh'>Tên ngành</th>
                                        <?php if ($_SESSION['user']['role'] == 'Admin') { 
                                            echo "<th id='trangthai'>Trạng thái</th>";
                                        }?>
                                        <th id='to_hop_xet_tuyen'>Tổ hợp xét tuyển</th>
                                        <th id='thoi_gian'>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody id="course_table_list_nganh" >
                                    <?php if(!is_array($ds_tuyen_sinh)): ?>
                                        <script>renderError("<?php echo $ds_tuyen_sinh; ?>", "course_table_list_nganh", "top_list_nganh")</script>
                                    <?php else: ?>
                                        <script>renderCoursesLN(<?php echo json_encode($ds_tuyen_sinh); ?>)</script>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                        
                </div>
            </div>
        </div>
    </div>
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