<!-- Hàm kiểm tra trang đã đăng nhập chưa -->
<?php

session_start();
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] !== "Teacher" && $_SESSION['user']['role'] !== "Admin") {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Tuyển sinh - Thống kê số liệu</title>
    <link rel="icon" href="../assets/images/logo.png?v=<?php echo filemtime('../assets/images/logo.png'); ?>" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css?v=<?php echo filemtime('../assets/style/style.css'); ?>">
    <link rel="stylesheet" href="../assets/style/teacher_path.css?v=<?php echo filemtime("../assets/style/teacher_path.css")?>">
    <script src="../js_backend/events.js?v=<?php echo filemtime('../js_backend/events.js'); ?>"></script>
    <link rel="stylesheet" href="../assets/style/table.css?v=<?php echo filemtime("../assets/style/table.css")?>">
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
                    <div class="body_path">
                        <h1>Danh sách sinh viên</h1>
                        <div class='linediv' style="align-items: flex-start;">
                            <h2 style='margin-left: 50px; color:#DC143C; margin-top: 0;'>Ngành đào tạo:</h2>
                            <form method="get"  style='margin-left: 20px;'>
                                <select name='ma_nganh_sv' style=' min-width: 350px;' onchange="this.form.submit()">
                                    <?php
                                        $danh_nganh = [
                                            (object) ['ma_nganh' => 'CNTT', 'ten_nganh' => 'Công nghệ thông tin'],
                                            (object) ['ma_nganh' => 'QTKD', 'ten_nganh' => 'Quản trị kinh doanh'],
                                            (object) ['ma_nganh' => 'KETOAN', 'ten_nganh' => 'Kế toán'],
                                            (object) ['ma_nganh' => 'LUAT', 'ten_nganh' => 'Luật'],
                                            (object) ['ma_nganh' => 'NN', 'ten_nganh' => 'Ngôn ngữ Anh']
                                    ];
                                ?>
                                <?php foreach($danh_nganh as $nganh): ?>
                                    <option value='<?php echo $nganh->ma_nganh;?>' <?php if(isset($_GET['ma_nganh_sv']) && $_GET['ma_nganh_sv'] === $nganh->ma_nganh) echo "selected";?>>
                                        <?php echo $nganh->ma_nganh;?> - <?php echo $nganh->ten_nganh;?>
                                    </option>
                                <?php endforeach;?>
                                </select>
                            </form>
                        </div>
                        <div class="UI_qlnd_container">
                            <div class="table_body_scroll" style="height:500px;">
                            <table class="choose_list danh_sach_ng" id="danh_sach_sv_nganh">
                                <thead>
                                        <tr>
                                        <th id='ma_sv'>Mã tuyển sinh</th>
                                        <th id='ten_sv'>Tên sinh viên</th>
                                        <th id='ngay_sinh'>Ngày sinh</th>
                                        <th id='que_quan'>Quê quán</th>
                                        <th id='khoi_xt'>Tổ hợp xét tuyển</th>
                                        <th id='diem'>Điểm</th>
                                        </tr>
                                </thead>
                                    <tbody id="course_table_tuyen_sinh" >
                                    <script>
                                        var userRole = <?php echo json_encode($_SESSION['user']['role']); ?>;
                                        loadAndRenderCourses(userRole);
                                        </script>
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