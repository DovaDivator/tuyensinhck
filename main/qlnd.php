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
    $trang_thai = isset($_GET['trang_thai']) ? $_GET['trang_thai'] : "0";
    $date_created = isset($_GET['date_created']) ? $_GET['date_created'] : "0";
    $hinh_thuc = isset($_GET['hinh_thuc']) ? $_GET['hinh_thuc'] : "0";
    $ds_sv = getDSSV($query, $trang_thai, $date_created, $hinh_thuc);
    echo $trang_thai."\n".$date_created."\n".$hinh_thuc;
    print_r($ds_sv);
}else if($_GET['ma_nganh_sv'] ==='giaovien'){
    $khoa = isset($_GET['khoa']) ? $_GET['khoa'] : "";
    $ma_nganh = isset($_GET['ma_nganh']) ? $_GET['ma_nganh'] : "";
    $ds_gv = getDSGV($query, $khoa, $ma_nganh);
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
                            <button type="button" class="icon-button" id="filter_option">
                                <img src="../assets/icon/filter_tag.png?v=<?php echo filemtime("../assets/icon/filter_tag.png"); ?>" 
                                alt="Bộ lọc" title="Bộ lọc" onclick="showChartOption('options layout filter_div_options', 'chart_option', 'show', event); GiveForm('search_form')">
                            </button>
                            <div style="position: relative;">
                                <div class="filter_div_options options layout" id="filter_tag_options">
                                <div class="linediv">
                                    <h3>Bộ lọc tìm kiếm:</h3>
                                </div>
                                <?php if(!isset($_GET['ma_nganh_sv']) || $_GET['ma_nganh_sv'] === 'sinhvien'): ?>
                                    <label for="trang_thai">Trạng thái:</label><br>
                                    <div style="height: 10px"></div>
                                    <select id="trang_thai" name="trang_thai">
                                        <option value="0" <?php echo $trang_thai == "0" ? "selected" : ""; ?>>Tất cả trạng thái</option>
                                        <option value="1" <?php echo $trang_thai == "1" ? "selected" : ""; ?>>Chưa đăng ký hồ sơ</option>
                                        <option value="2" <?php echo $trang_thai == "2" ? "selected" : ""; ?>>Đang chờ xét duyệt hồ sơ</option>
                                        <option value="3" <?php echo $trang_thai == "3" ? "selected" : ""; ?>>Yêu cầu chỉnh sửa lại hồ sơ</option>
                                        <option value="4" <?php echo $trang_thai == "4" ? "selected" : ""; ?>>Đã xác thực hồ sơ, chưa chọn ngành</option>
                                        <option value="5" <?php echo $trang_thai == "5" ? "selected" : ""; ?>>Đang chờ xác nhận đăng ký ngành</option>
                                        <option value="6" <?php echo $trang_thai == "6" ? "selected" : ""; ?>>Đã đăng ký thành công</option>
                                    </select><br>
                                    <div style="height: 10px"></div>

                                    <label for="date_created">Thời gian đăng ký:</label><br>
                                    <div style="height: 10px"></div>
                                    <select id="date_created" name="date_created">
                                        <option value="0" <?php echo $date_created == "0" ? "selected" : ""; ?>>Từ trước đến nay</option>
                                        <option value="1" <?php echo $date_created == "1" ? "selected" : ""; ?>>1 ngày</option>
                                        <option value="2" <?php echo $date_created == "2" ? "selected" : ""; ?>>1 tuần</option>
                                        <option value="3" <?php echo $date_created == "3" ? "selected" : ""; ?>>1 tháng</option>
                                        <option value="4" <?php echo $date_created == "4" ? "selected" : ""; ?>>3 tháng</option>
                                    </select><br>
                                    <div style="height: 10px"></div>

                                    <label for="hinh_thuc">Hình thức xét tuyển:</label><br>
                                    <div style="height: 10px"></div>
                                    <select id="hinh_thuc" name="hinh_thuc">
                                        <option value="0" <?php echo $hinh_thuc == "0" ? "selected" : ""; ?>>Tất cả</option>
                                        <option value="1" <?php echo $hinh_thuc == "1" ? "selected" : ""; ?>>Chưa có ngành</option>
                                        <?php foreach (GetHinhThucXetTuyen() as $row): ?>
                                            <option value="<?php echo $row['ma_htts']; ?>" 
                                                <?php echo $hinh_thuc == $row['ma_htts'] ? "selected" : ""; ?>>
                                                <?php echo $row['ma_htts']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select><br>
                                    <div style="height: 10px"></div>

                                    <?php elseif(isset($_GET['ma_nganh_sv']) && $_GET['ma_nganh_sv'] === 'giaovien'): ?>
                                    <label for="khoa">&nbsp;Khoa:</label><br><div style="height: 10px"></div>
                                    <input type="text" id="khoa" name="khoa" readonly placeholder="Tất cả" value="<?php echo $khoa; ?>"><br>
                                    <div class="dropdown_container">
                                        <div class="dropdown" id="dropdown_khoa" style='top: -25px; width: 250px;'>
                                            <input type="text" id="searchInput_khoa" placeholder="Tìm kiếm..." class="dropdown-search">
                                            <div class="dropdown-list">
                                                <div class="dropdown-item default" data-id="default">Tất cả</div>
                                                <?php foreach (GetKhoaDaoTao() as $row): ?>
                                                    <div data-id="<?php echo $row['khoa']; ?>">
                                                        <?php echo $row['khoa']; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <label for="ma_nganh">&nbsp;Mã ngành:</label><br><div style="height: 10px"></div>
                                    <input type="text" id="ma_nganh" name="ma_nganh" readonly placeholder="Tất cả" value="<?php echo $ma_nganh; ?>"><br>
                                    <div class="dropdown_container">
                                        <div class="dropdown" id="dropdown_ma_nganh" style='top: -25px; width: 250px;'>
                                            <input type="text" id="searchInput_ma_nganh" placeholder="Tìm kiếm..." class="dropdown-search">
                                            <div class="dropdown-list">
                                                <div class="dropdown-item default" data-id="default">Tất cả</div>
                                                <div class="dropdown-item" data-id="Chưa phụ trách">Chưa phụ trách</div>
                                                <?php foreach (GetMaNganh() as $row): ?>
                                                    <div data-id="<?php echo $row['nganh_id']; ?>">
                                                        <?php echo $row['nganh_id']; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
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