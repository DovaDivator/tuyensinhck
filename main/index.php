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

$query = isset($_GET['query']) ? $_GET['query'] : "";
$status = isset($_GET['status']) ? $_GET['status'] : "";
$selectedToHop = isset($_GET['tohop']) ? (array)$_GET['tohop'] : [];

include '../php_control/data/ds_tuyen_sinh.php';
include '../php_control/data/get-to-hop.php';
$ds_tuyen_sinh = getDSTuyenSinh($query, $status, $selectedToHop);
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
                                <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm..." class="search-input" value="<?php echo isset($_GET['query']) ? $_GET['query'] : '' ?>">
                                <button type="submit" class="search-button">
                                    <img src="../assets/icon/search.png?v=<?php echo filemtime('../assets/icon/search.png'); ?>" 
                                    title="Tìm kiếm" class="search-icon">
                                </button>
                            </div>
                            <button type="button" class="icon-button" id="filter_option">
                                <img src="../assets/icon/filter_tag.png?v=<?php echo filemtime("../assets/icon/filter_tag.png"); ?>" 
                                alt="Bộ lọc" title="Bộ lọc" onclick="showChartOption('options layout filter_div_options', 'chart_option', 'show', event); GiveForm('search_form'), handleCheckboxClick('status')">
                            </button>
                            <button type="button" class="icon-button" id="filter_option">
                                <img src="../assets/icon/plus.png?v=<?php echo filemtime("../assets/icon/plus.png"); ?>" 
                                alt="Thêm chuyên ngành" title="Thêm chuyên ngành" onclick="window.location.href='chinhsuanganh.php'">
                            </button>
                            <div style="position: relative;">   
                                <div class="filter_div_options options layout" id="filter_tag_options">
                                    <div class="linediv">
                                        <h3>Bộ lọc tìm kiếm:</h3>
                                        <div class="button_div">
                                            <input type="button" value="Bỏ chọn tất cả" onclick='uncheckAllCheckboxes("filter_tag_options")'>
                                        </div>
                                    </div>

                                    <!-- Trạng thái tuyển sinh -->
                                    <?php if($_SESSION['user']['role'] == 'Admin'): ?>
                                    <div class="filter-group">
                                    <label>Trạng thái tuyển sinh:</label>
                                        <div class="checkbox-group">
                                            <input type="checkbox" id="sapmo" name="status" value="sapmo" <?php echo $status === 'sapmo' ? 'checked' : ''; ?>>
                                            <label for="sapmo">Sắp mở</label>

                                            <input type="checkbox" id="dangmo" name="status" value="dangmo" <?php echo $status === 'dangmo' ? 'checked' : ''; ?>>
                                            <label for="dangmo">Đang mở</label>

                                            <input type="checkbox" id="dadong" name="status" value="dadong" <?php echo $status === 'dadong' ? 'checked' : ''; ?>>
                                            <label for="dadong">Đã đóng</label>

                                            <input type="checkbox" id="dangan" name="status" value="dangan" <?php echo $status === 'dangan' ? 'checked' : ''; ?>>
                                            <label for="dangan">Đang ẩn</label>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <!-- Tổ hợp xét tuyển -->
                                    <div class="filter-group">
                                        <label>Tổ hợp xét tuyển:</label>
                                        <div class="checkbox-group tohopxettuyen">
                                            <?php foreach (GetToHop() as $row): 
                                                $isChecked = in_array($row['id'], $selectedToHop) ? 'checked' : '';
                                            ?>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="tohop[]" value="<?php echo $row['id']; ?>" <?php echo $isChecked; ?>>
                                                    <label for="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table_body_scroll" style="height:600px;">
                            <table class="choose_list nganh_hoc" id="top_tuyen_sinh">
                                <thead>
                                    <tr>
                                        <th id='ma_nganh'>Mã tuyển sinh</th>
                                        <th id='ten_nganh'>Tên ngành</th>
                                        <?php if ($_SESSION['user']['role'] == 'Admin') { 
                                            echo "<th id='trangthai'>Trạng thái</th>";
                                        }?>
                                        <?php if ($_SESSION['user']['role'] != 'Student') { 
                                            echo "<th id='so_luong_dang_ky'>Số lượng đăng ký</th>";
                                        }?>
                                        <th id='to_hop_xet_tuyen'>Tổ hợp xét tuyển</th>
                                        <th id='thoi_gian'>Thời gian tuyển sinh</th>
                                    </tr>
                                </thead>
                                <tbody id="course_table_tuyen_sinh" >
                                    <?php if(!is_array($ds_tuyen_sinh)): ?>
                                        <script>renderError("<?php echo $ds_tuyen_sinh; ?>", "course_table_tuyen_sinh", "top_tuyen_sinh")</script>
                                    <?php else: ?>
                                        <script>renderCoursesTuyenSinh(<?php echo json_encode($ds_tuyen_sinh); ?>, "<?php echo $_SESSION['user']['role'];?>")</script>
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