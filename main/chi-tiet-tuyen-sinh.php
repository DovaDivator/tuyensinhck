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
    include '../php_control/data/get_info_nganh.php';
    $info = getInfoNganh($_GET['ma_nganh']);
    include '../php_control/data/db_connect.php';
    include '../php_control/data/get_infomation.php';
} else {
    $info = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Tuyển sinh -&nbsp;
        <?php
            if(isset($info['ten'])){
                echo $info['ten'];
            }
        ?>
    </title>
    <link rel="icon" href="../assets/images/logo.png?v=<?php echo filemtime('../assets/images/logo.png'); ?>" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css?v=<?php echo filemtime('../assets/style/style.css'); ?>">
    <link rel="stylesheet" href="../assets/style/chitiet.css?v=<?php echo filemtime('../assets/style/chitiet.css'); ?>">
    <script src="../js_backend/events.js?v=<?php echo filemtime('../js_backend/events.js'); ?>"></script>
    <script src="../js_backend/control.js?v=<?php echo filemtime('../js_backend/control.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js_backend/dialog.js?v=<?php echo filemtime('../js_backend/dialog.js'); ?>"></script>
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
                            if(isset($info['ten'])){
                                echo $_GET['ma_nganh']. " - ". $info['ten'];
                            }
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
                                    <p><?php echo isset($info['chi_tieu']) ?  $info['chi_tieu'] : ""; ?> sinh viên</p>
                                </div>
                                <div class="divine-line"></div>
                            </div>
                            <div class="path_info_container">
                                <div class="icon">
                                <img src="../assets/icon/to_hop_xet_tuyen_icon.png?v=<?php echo filemtime('../assets/icon/to_hop_xet_tuyen_icon.png'); ?>">
                                </div>
                                <div class="path_info_text">
                                    <h4>Tổ hợp xét tuyển:</h4>
                                    <p><?php echo isset($info['to_hop']) ?  $info['to_hop'] : ""; ?></p>
                                </div>
                                <div class="divine-line"></div>
                            </div>
                            <div class="path_info_container">
                                <div class="icon">
                                <img src="../assets/icon/chuong_trinh_dao_tao_icon.png?v=<?php echo filemtime('../assets/icon/chuong_trinh_dao_tao_icon.png'); ?>">
                                </div>
                                <div class="path_info_text">
                                    <h4>Chương trình đào tạo:</h4>
                                    <p><?php  echo isset($info['chuong_trinh']) ?  $info['chuong_trinh'] : "" ?> năm</p>
                                </div>
                            </div>
                        </div>

                        <div class="date_div">
                            <p><b>Hạn đăng ký: từ&nbsp;
                                <font color="red"><?php echo isset($info['date_open']) ?  (new DateTime(substr($info['date_open'], 0, 19)))->format('H\hi d/m/Y'): "";?></font>
                                &nbsp;đến&nbsp;
                                <font color="red"><?php echo isset($info['date_end']) ?  (new DateTime(substr($info['date_end'], 0, 19)))->format('H\hi d/m/Y'): "";?></font>
                            </b></p>
                        </div>
                        <?php if($_SESSION['user']['role'] !== 'Student'):?>
                        <div class="dangkysl_div">
                            <p><b>Số lượng đăng ký: <?php echo isset($info['sl_dky']) ?  $info['sl_dky'] : "" ;?></b></p>
                        </div>
                        <?php endif; ?>
                        <div class="dangkysl_div">
                            <p><b>Giáo viên phụ trách: <?php echo isset($info['gv_id']) ?  getNameGV($info['gv_id']) : ""; ?> </b></p>
                        </div>
                        <div class="note_div">
                            <h4>Ghi chú: </h4>
                            <?php if($_SESSION['user']['role'] === "Student" && isset($info['is_full']) && $info['is_full']): ?>
                                <p style='color: red;'><b><i>- Số lượng đăng ký đủ!</i></b></p>
                            <?php endif; ?>
                            <p><b>- Điểm xét tuyển: <font color="red"><?php echo isset($info['diem_chuan']) ?  $info['diem_chuan'] : "" ;?></font></b></p>
                            <?php
                                if(isset($info['ghi_chu'])){
                                    $diem = json_decode($info['ghi_chu'], true);
                                    if (is_array($diem)) {
                                        echo "<p><b>- Yêu cầu:</p></b>";
                                        foreach ($diem as $key => $value) {
                                            // In ra dưới dạng "Điểm $key >= $value"
                                            echo "<p style='margin-left: 60px !important;'>Điểm $key >= <font color='red'>$value</font></p>";
                                        }
                                    }
                                }
                            ?>
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
                            <button class="custom-button-dktc" onclick="window. location.href = 'chinhsuanganh.php?ma_nganh=<?php echo $_GET['ma_nganh']; ?>'">&#128203; CHỈNH SỬA HỒ SƠ TUYỂN SINH</button>
                        </div>
                        <div style='margin-top: 10px; margin-left: 10px;'>
                            <button class="custom-button-dktc" onclick="SetEnable()">
                                <?php
                                     if($info['isenable']){
                                        echo "ẨN CHUYÊN NGÀNH";
                                     }else{
                                        echo "HIỂN THỊ CHUYÊN NGÀNH";
                                     }
                                ?>
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="div_path_web linedown">
                        <h3 style='margin: 10px 0;'>Mô tả về chuyên ngành:</h3>
                        <?php if(isset($info['mo_ta']) || isset($info['iframe']) || isset($info['img_link'])): ?>
                            <?php 
                            if(isset($info['mo_ta'])){
                                $paragraphs = explode("\n", $info['mo_ta']); 
                                foreach ($paragraphs as $paragraph) {
                                    $paragraph = trim($paragraph); 
                                    if (!empty($paragraph)) { 
                                        echo "<p>$paragraph</p>"; 
                                    }
                                }
                            }
                            ?>
                        <div class="media">
                            <?php if(isset($info['iframe']) && $info['iframe'] != null): ?>
                                <iframe src="<?php echo $info['iframe']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                            <?php elseif(isset($info['img_link']) && $info['img_link'] != null): ?>
                                <img src="<?php echo 'data:image/png;base64,' . base64_encode( $info['img_link'] ); ?>">
                            <?php endif;?>
                            <p><?php echo isset($info['chu_thich']) ?  $info['chu_thich'] : ""  ?></p>
                        </div>
                        <?php else:?>
                            <p class='none_info'>Chưa có mô tả về ngành này!</p>
                        <?php endif;?>
                    </div>
                </div>
                        
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php if(empty($info)): ?>
    <script>
        ErrorDialog("Thông báo lỗi", "Ngành <?php echo isset($_GET['ma_nganh']) ? $_GET['ma_nganh'] : ""; ?> không tồn tại!");
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 3500);
    </script>
<?php endif; ?>

<script>
    function SetEnable() {
        // Gán giá trị id vào textInput (tránh trùng lặp)

        const xhr2 = new XMLHttpRequest();
        xhr2.open("POST", "../php_control/data/switch-enable.php", true);
        xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr2.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr2.onload = function() {
            if (xhr2.status === 200) {
                window.location.reload();               
            } else {
                // Xử lý lỗi nếu có
                console.error('Error:', xhr2.status);
            }
        };
        const currentUrl = new URL(window.location.href);

        // Lấy giá trị của tham số 'ma_nganh'
        const ma_nganh = currentUrl.searchParams.get('ma_nganh');


        xhr2.send(`id=${ma_nganh}`);
    }
</script>

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
