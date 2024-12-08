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
include '../php_control/data/ds_tuyen_sinh.php';

$query = isset($_GET['query']) ? $_GET['query'] : "";

if(!isset($_GET['ma_nganh_sv']) || $_GET['ma_nganh_sv'] === 'sinhvien'){
    $ds_sv = getDSSV($query);
}else if($_GET['ma_nganh_sv'] ==='giaovien'){
    $ds_gv = getDSGV($query);
}else{
    header("Location: qlnd.php");
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
                            <input type="hidden" name="ma_nganh_sv" value="<?php echo isset($_GET['ma_nganh_sv']) ? $_GET['ma_nganh_sv'] : 'sinhvien'; ?>">
                            <div class="search-container">
                                <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm..." class="search-input" value="<?php echo $query; ?>">
                                <button type="submit" class="search-button">
                                    <img src="../assets/icon/search.png?v=<?php echo filemtime('../assets/icon/search.png'); ?>" 
                                    title="Tìm kiếm" class="search-icon">
                                </button>
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
                                <?php if(!is_array($ds_gv)): ?>
                                        <script>renderErrorGV("<?php echo $ds_gv; ?>", "body_danh_sach_giao_vien", "danh_sach_giao_vien")</script>
                                    <?php else: ?>
                                        <script>renderCoursesGV(<?php echo json_encode($ds_gv); ?>, "<?php echo $_SESSION['user']['role'];?>")</script>
                                    <?php endif; ?>
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
                                    <th id='khoi_xt'>Hình thức xét tuyển</th>
                                    <th id='dk'>Chuyên ngành đăng ký</th>
                                    <th id='hoso'>Trạng thái</th>
                                    
                                </tr>
                            </thead>
                                <tbody id="course_table_dssv" >
                                <?php if(!is_array($ds_sv)): ?>
                                        <script>renderErrorSV("<?php echo $ds_sv; ?>", "course_table_dssv", "danh_sach_sinh_vien")</script>
                                    <?php else: ?>
                                        <script>renderCoursesSV(<?php echo json_encode($ds_sv); ?>)</script>
                                    <?php endif; ?>
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

<scrpit>

</scrpit>

<?php if(isset($_GET['ma_nganh_sv']) && $_GET['ma_nganh_sv'] === 'giaovien'): ?>
<script>
    //Chọn khoa
    const khoaInput = document.getElementById('khoa');
    const dropdownKhoa = document.getElementById('dropdown_khoa');
    const dropdownListKhoa = dropdownKhoa.querySelector('.dropdown-list');

    const searchInputKhoa = document.getElementById('searchInput_khoa');
    const itemsKhoa = Array.from(dropdownListKhoa.children);
    handleSearch(searchInputKhoa, itemsKhoa);
    
    khoaInput.addEventListener('click', () => {
        dropdownKhoa.style.display = dropdownKhoa.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', (e) => {
        if (!dropdownKhoa.contains(e.target) && e.target !== khoaInput) {
            dropdownKhoa.style.display = 'none';
        }
    });

    dropdownKhoa.addEventListener('click', (e) => {
    if (e.target.tagName === 'DIV') {
        if (e.target.classList.contains('default')) {
            khoaInput.value = ''; 
        } else {
            khoaInput.value = e.target.textContent.trim(); // Lấy nội dung của mục được chọn
        }
    
        dropdownKhoa.style.display = 'none';
        }   
    });
        //Chọn mã chuyên ngành
    const nganhInput = document.getElementById('ma_nganh');
    const dropdownNganh = document.getElementById('dropdown_ma_nganh');
    const dropdownListNganh = dropdownNganh.querySelector('.dropdown-list');

    const searchInputNganh = document.getElementById('searchInput_ma_nganh');
    const itemsNganh = Array.from(dropdownListNganh.children);
    handleSearch(searchInputNganh, itemsNganh);
    
    nganhInput.addEventListener('click', () => {
        dropdownNganh.style.display = dropdownNganh.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', (e) => {
        if (!dropdownNganh.contains(e.target) && e.target !== nganhInput) {
            dropdownNganh.style.display = 'none';
        }
    });

    dropdownNganh.addEventListener('click', (e) => {
    if (e.target.tagName === 'DIV') {
        if (e.target.classList.contains('default')) {
            nganhInput.value = ''; 
        } else {
            nganhInput.value = e.target.textContent.trim(); // Lấy nội dung của mục được chọn
        }
    
        dropdownNganh.style.display = 'none';
    }
});
</script>
<?php endif; ?>

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