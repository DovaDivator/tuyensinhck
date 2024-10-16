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

if (isset($_GET['ma_nganh'])) {
    //echo "<script>alert('welcom');</script>";
} else {
    //echo "<script>alert('pls login');</script>";
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Tuyển sinh -&nbsp;
        <?php
            echo "Ngành công nghệ";
        ?>
    </title>
    <link rel="icon" href="../assets/images/logo.png?v=<?php echo filemtime('../assets/images/logo.png'); ?>" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css?v=<?php echo filemtime('../assets/style/style.css'); ?>">
    <link rel="stylesheet" href="../assets/style/chitiet.css?v=<?php echo filemtime('../assets/style/chitiet.css'); ?>">
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
                    <h1>Thông tin chi tiết ngành</h1> 
                    <h2 style="padding-left: 50px; color:#DC143C;">
                        <?php 
                            echo $_GET['ma_nganh'].": Ngành công nghệ";
                        ?>
                    </h2>

                    <div class="div_path_web" style="margin-bottom: 20px;">
                        <div class="container_grid">
                            <div class="path_info_container">
                                <div class="icon">
                                <img src="../assets/icon/chi_tieu_xet_tuyen_icon.png?v=<?php echo filemtime('../assets/icon/chi_tieu_xet_tuyen_icon.png'); ?>">
                                </div>
                                <div class="path_info_text">
                                    <h4>Chỉ tiêu xét tuyển:</h4>
                                    <p>700 sinh viên</p>
                                </div>
                                <div class="divine-line"></div>
                            </div>
                            <div class="path_info_container">
                                <div class="icon">
                                <img src="../assets/icon/to_hop_xet_tuyen_icon.png?v=<?php echo filemtime('../assets/icon/to_hop_xet_tuyen_icon.png'); ?>">
                                </div>
                                <div class="path_info_text">
                                    <h4>Tổ hợp xét tuyển:</h4>
                                    <p>A00, A01</p>
                                </div>
                                <div class="divine-line"></div>
                            </div>
                            <div class="path_info_container">
                                <div class="icon">
                                <img src="../assets/icon/chuong_trinh_dao_tao_icon.png?v=<?php echo filemtime('../assets/icon/chuong_trinh_dao_tao_icon.png'); ?>">
                                </div>
                                <div class="path_info_text">
                                    <h4>Chương trình đào tạo:</h4>
                                    <p>4 năm</p>
                                </div>
                            </div>
                        </div>
                        <div class="date_div">
                            <p><b>Hạn đăng ký: </b></p>
                        </div>
                        <?php if($_SESSION['user']['role'] !== 'Student'):?>
                        <div class="dangkysl_div">
                            <p><b>Số lượng đăng ký: </b></p>
                        </div>
                        <?php endif; ?>
                        <?php if($_SESSION['user']['role'] === 'Admin'):?>
                        <div class="dangkysl_div">
                            <p><b>Giáo viên phụ trách: </b></p>
                        </div>
                        <?php endif; ?>
                        <div class="note_div">
                            <h4>Ghi chú: </h4>
                            <p style='color: red;'><b><i>- Số lượng đăng ký đủ!</i></b></p>
                            <p><b>- Điểm xét tuyển:</b></p>
                        </div>
                        <?php if($_SESSION['user']['role'] === 'Student'): ?>
                        <div style='margin-top: 10px; margin-left: 10px;'>
                            <button class="custom-button-dktc da_dang_ky" title="Bạn đã đăng ký môn này!">&#128393; ĐĂNG KÝ CHUYÊN NGÀNH!</button>
                        </div>
                        <?php endif; ?>
                        <?php if($_SESSION['user']['role'] !== 'Student'):?>
                        <div style='margin-top: 10px; margin-left: 10px;'>
                            <button class="custom-button-dktc">&#9881; XEM DANH SÁCH SINH VIÊN ĐĂNG KÝ</button>
                        </div>
                        <?php endif; ?>
                        <?php if($_SESSION['user']['role'] === 'Admin'):?>
                        <div style='margin-top: 10px; margin-left: 10px;'>
                            <button class="custom-button-dktc">&#128203; CHỈNH SỬA HỒ SƠ TUYỂN SINH</button>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="div_path_web linedown">
                        <h3 style='margin: 10px 0;'>Mô tả về chuyên ngành:</h3>
                        <p>Hiện nay, ngành công nghệ thông tin là một trong những ngành học được chú trọng trong hệ thống đào tạo của trường Đại học Công nghệ thông tin cũng như các trường Đại học khác có đào tạo ngành học này. Nó được xem là ngành đào tạo mũi nhọn hướng đến sự phát triển của công nghệ và khoa học kỹ thuật trong thời đại số hóa ngày nay.</p>

                        <p>Công nghệ thông tin là một ngành học được đào tạo để sử dụng máy tính và các phần mềm máy tính để phân phối và xử lý các dữ liệu thông tin, đồng thời dùng để trao đổi, lưu trữ và chuyển đổi các dữ liệu thông tin dưới nhiều hình thức khác nhau.</p>

                        <div class="media">
                            <iframe src="https://www.youtube.com/embed/Fv9wuC_bSTU?si=xcVlHC-WGBoLqRis" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                            <p>Video giới thiệu khoa Công nghệ thông tin</p>
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
