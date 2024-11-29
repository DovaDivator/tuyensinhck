<!-- Hàm kiểm tra trang đã đăng nhập chưa -->
<?php

session_start();
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] !== "Admin") {
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
    <link rel="stylesheet" href="../assets/style/admin_path.css?v=<?php echo filemtime("../assets/style/admin_path.css")?>">
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
                <div class="body_path">
                    <h1>Danh sách người dùng</h1>
                    <div class="UI_qlnd_container">
                        <div class='linediv'>
                            <h2 class='title_heading'>Danh sách: </h2>
                            <form method="get"  style='margin-left: 20px;' >
                                <select name='ma_nganh_sv' style=' width: 150px; font-weight: bold; font-size: 16px;' onchange="this.form.submit()">
                                    <option value='sinhvien'
                                        <?php
                                            if(!isset($_GET['ma_nganh_sv']) || $_GET['ma_nganh_sv'] ==='sinhvien'){
                                                echo "selected";
                                            }
                                        ?>
                                    >Sinh viên</option>
                                    <option value='giaovien'
                                        <?php
                                            if(isset($_GET['ma_nganh_sv']) && $_GET['ma_nganh_sv'] === 'giaovien'){
                                                echo "selected";
                                            }
                                        ?>
                                    >Giáo viên</option>
                                </select>
                            </form>
                        </div>

                                    <!-- Đọc GET trong URL để hiển thị UI tương ứng, không có gì mặc định là sinh viên -->

                        <form action="" id="search_form" class='linediv' method="GET" style='margin-bottom: 10px;'>
                            <div class="search-container">
                                <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm..." class="search-input">
                                <button type="submit" class="search-button">
                                    <img src="../assets/icon/search.png?v=<?php echo filemtime('../assets/icon/search.png'); ?>" 
                                    title="Tìm kiếm" class="search-icon">
                                </button>
                            </div>
                            <button type="button" class="icon-button" id="filter_option">
                                <img src="../assets/icon/filter_tag.png?v=<?php echo filemtime("../assets/icon/filter_tag.png"); ?>" 
                                alt="Bộ lọc" title="Bộ lọc" onclick="showChartOption('options layout filter_div_options', 'chart_option', 'show', event); GiveForm('search_form')">
                            </button>
                            <div style="position: relative;">
                                <div class="filter_div_options options layout" id="filter_tag_options">
                                <div class="linediv">
                                    <h3>Bộ lọc tìm kiếm:</h3>
                                    <?php if(!isset($_GET['ma_nganh_sv']) || $_GET['ma_nganh_sv'] ==='sinhvien'): ?>
                                    <div class="button_div">
                                        <input type="button" value="Bỏ chọn tất cả" onclick='uncheckAllCheckboxes("filter_tag_options"); uncheckAllRadio("filter_tag_options", true)'>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php if(!isset($_GET['ma_nganh_sv']) || $_GET['ma_nganh_sv'] === 'sinhvien'): ?>
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="chuyen_nganh" name="status[]" value="chuyen_nganh" onclick="toggleRadios('chuyen_nganh', 'chuyennganh')">
                                        <label for="chuyen_nganh">Chuyên ngành:</label><br>
                                        <div style='display:grid; grid-template-columns: repeat(2, 1fr); margin-right: 25px;'>
                                            <label><input type="radio" name="chuyennganh" value="da_dang_ky" disabled> Đã đăng ký</label>
                                            <label><input type="radio" name="chuyennganh" value="tam_thoi" disabled> Tạm thời</label>
                                            <label><input type="radio" name="chuyennganh" value="chua_dang_ky" disabled> Chưa đăng ký</label>
                                        </div>

                                        <input type="checkbox" id="ho_so" name="status[]" value="ho_so"  onclick="toggleRadios('ho_so', 'hoso')">
                                        <label for="ho_so">Hồ sơ:</label><br>
                                        <div style='display:grid; grid-template-columns: repeat(2, 1fr); margin-right: 25px;'>
                                            <label><input type="radio" name="hoso" value="da_xac_thuc" disabled> Đã xác thực</label>
                                            <label><input type="radio" name="hoso" value="cho_xet_duyet" disabled> Chờ xét duyệt</label>
                                            <label><input type="radio" name="hoso" value="chua_nop" disabled> Chưa nộp</label>
                                        </div>

                                        <input type="checkbox" id="dinh_chi_sv" name="status[]" value="dinh_chi_sv">
                                        <label for="dinh_chi_sv">Đang bị đình chỉ</label><br>
                                    </div>  

                                    <?php elseif(isset($_GET['ma_nganh_sv']) && $_GET['ma_nganh_sv'] === 'giaovien'): ?>
                                    <div class="checkbox-group">
                                        <input type="radio" id="default" name="status" value="default" checked>
                                        <label for="default">Tất cả giáo viên</label><br>

                                        <input type="radio" id="nganh_true" name="status" value="nganh_true">
                                        <label for="nganh_true">Đang phụ trách</label><br>

                                        <input type="radio" id="nganh_false" name="status" value="nganh_false">
                                        <label for="nganh_false">Chưa phụ trách</label><br>

                                        <input type="radio" id="dinh_chi_gv" name="status" value="dinh_chi_gv">
                                        <label for="dinh_chi_gv">Đang bị đình chỉ</label><br>
                                    </div>  
                                    <?php endif;?>
                                </div>
                            </div>
                        </form>
                    
                        <?php if(isset($_GET['ma_nganh_sv']) && $_GET['ma_nganh_sv'] === 'giaovien'): ?>
                        <div class="table_body_scroll" style="height:600px;">
                        <table class="choose_list danh_sach_ng" id="danh_sach_giao_vien">
                                <thead>
                                <tr>
                                    <th id='ma_gv'>Mã giáo viên</th>
                                    <th id='ten_gv'>Tên giáo viên</th>
                                    <th id='khoa'>Khoa</th>
                                    <th id='nganh_quan_ly'>Ngành phụ trách</th>
                                </tr>
                            </thead>
                                <tbody id="body_danh_sach_giao_vien" >
                                <script>
                                    var userRole = <?php echo json_encode($_SESSION['user']['role']); ?>;
                                    loadAndRenderCoursesGV(userRole);
                                    </script>
                                </tbody>
                            </table>
                        </div>
                        <?php elseif(!isset($_GET['ma_nganh_sv']) || $_GET['ma_nganh_sv'] ==='sinhvien'): ?>
                        <div class="table_body_scroll" style="height: 600px;">
                        <table class="choose_list danh_sach_ng" id="danh_sach_sinh_vien">
                            <thead>
                                <tr>
                                    <th id='ma_sv'>Mã tuyển sinh</th>
                                    <th id='ten_sv'>Tên sinh viên</th>
                                    <th id='date_reg'>Ngày đăng ký</th>
                                    <th id='khoi_xt'>Khối xét tuyển</th>
                                    <th id='dk'>Chuyên nghành đăng ký</th>
                                    <th id='hoso'>Trạng thái</th>
                                    
                                </tr>
                            </thead>
                                <tbody id="course_table_dssv" >
                                <script>
                                    var userRole = <?php echo json_encode($_SESSION['user']['role']); ?>;
                                    loadAndRenderCoursesSV(userRole);
                                    </script>
                                </tbody>
                            </table>
                        </div>
                        <?php endif;?>
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