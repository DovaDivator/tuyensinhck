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
    <title>Web Tuyển sinh - Hồ sơ thông tin</title>
    <link rel="icon" href="../assets/images/logo.png?v=<?php echo filemtime('../assets/images/logo.png'); ?>" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css?v=<?php echo filemtime('../assets/style/style.css'); ?>">
    <link rel="stylesheet" href="../assets/style/taikhoan.css?v=<?php echo filemtime('../assets/style/taikhoan.css'); ?>">
    <link rel="stylesheet" href="../assets/style/table.css?v=<?php echo filemtime('../assets/style/table.css'); ?>">
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
                        <div class="info_layout" id="nguoidung_path">
                            <div class="linediv">
                                <h1>Thông tin cá nhân</h1>
                                <button type="submit" class="icon-button" id="changeInfo">
                                    <img src="../assets/icon/info_icon.png?v=<?php echo filemtime("../assets/icon/info_icon.png"); ?>" 
                                    alt="Chỉnh sửa thông tin" title="Chỉnh sửa thông tin" onclick="MovePage('chinhsuathongtin.php')">            
                                </button>
                                <?php if($_SESSION['user']['role'] === 'Admin'): ?>
                                <button type="submit" class="icon-button" id="blockAcc">
                                    <img src="../assets/icon/info_icon.png?v=<?php echo filemtime("../assets/icon/info_icon.png"); ?>" 
                                    alt="Đình chỉ tài khoản" title="Đình chỉ tài khoản" onclick="">            
                                </button>
                                <?php endif; ?>
                            </div>
                            <div class="linediv" style="gap:30px; align-items:flex-start;">
                                <div class="avatar_container disable" style="width: 200px; height: 200px;" onclick="MovePage('chinhsuathongtin.php')">
                                    <?php if($_SESSION['user']['avatar_name'] == null): ?>
                                    
                                    <?php endif; ?>
                                </div>
                                <div class="info_text_container">
                                    <h2 style='margin-top: 0;'><?php echo $_SESSION['user']['username']; ?></h2>
                                    <p id="id_user">ID: <?php echo $_SESSION['user']['id']; ?></p>
                                    <p id="role">Vai trò:
                                        <?php 
                                        if ($_SESSION['user']['role'] === 'Admin') {
                                            echo 'Quản trị viên';
                                        } elseif ($_SESSION['user']['role'] === 'Student') {
                                            echo 'Sinh viên';
                                        }
                                        elseif ($_SESSION['user']['role'] === 'Teacher') {
                                            echo 'Giáo viên';
                                        }
                                        ?>
                                    </p>
                                    <p id="email">Email: <a href="#" title="Liên hệ email"><?php echo $_SESSION['user']['email']; ?></a></p>
                                    <p id="sdt">SĐT: <a 
                                    <?php if($_SESSION['user']['phone'] !== null){
                                        echo 'href="#" title="Liên hệ số điện thoại">'.$_SESSION['user']['phone'];
                                    }else{
                                        echo 'href="#" title="Người dùng chưa cập nhật số điện thoại"> Không có';
                                    }
                                    ?></a></p>
                                    <p td="trang_thai">Trạng thái: <font color="red">Chưa đăng ký hồ sơ</font></p>
                                    <P td='date_created'>Ngày đăng ký: 12/09/2024 </p>
                                </div>
                            </div>
                        </div>
                        <div class="info_layout" id="hoso_path">
                            <div class="linediv">
                                <h1>Hồ sơ sinh viên</h1>
                                <?php if($_SESSION['user']['role'] === 'Admin'): ?>
                                <button type="submit" class="icon-button" id="kiemduyetsv">
                                    <img src="../assets/icon/info_icon.png?v=<?php echo filemtime("../assets/icon/info_icon.png"); ?>" 
                                    alt="Kiểm duyệt hồ sơ" title="Kiểm duyệt hồ sơ" onclick="MovePage('kiem-duyet-ho-so.php')">            
                                </button>
                                <?php endif; ?>
                            </div>
                            <!-- sau này thêm điều kiện hiển thị -->
                             <?php
                                include '../php_control/admin_path/db_connect.php';
                                function fetchGVforNgang($pdo) {
                                    $x = $_SESSION['user']['id'];
                                   // echo $x;
                                    $query = "Select
                                                *
                                                From
                                                sinh_vien 
                                               WHERE stu_id = :stu_id";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->bindParam(':stu_id', $x, PDO::PARAM_INT);
                                    $stmt->execute();
                                    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
                                }
                                $test = fetchGVforNgang($pdo);
                                // vì  bảng ko có thông tin về cccd giới tính địa chỉ nên em chưa thay vào được đâu  
                             ?>
                            <p id='hoso_log'><b><font color="red">Bạn chưa đăng ký hồ sơ! </font><a href="nop-ho-so.php">Ấn vào đây để đăng ký</a></b></p>
                            <?php if($_SESSION['user']['role'] !== 'Student'): ?>
                            <P id='cccd'>CCCD: 0123456789012 </p>
                            <?php endif;?>
                            <p id='gender'>Giới tính: Nữ</p>
                            <p id='birth_date'>Ngày sinh: 16/07/2002</p>
                            <p id='address'>Địa chỉ: 123 đường 45, Quận 1, TP. Hồ Chí Minh</p>
                            <p id='hinhthucts'>Hình thức tuyển sinh: THPTQG - KHTN</p>
                            <?php if($_SESSION['user']['role'] !== 'Student'): ?>
                            <p id='id_ts'>Mã tuyển sinh: 0123456789012 </p>
                            <?php endif;?>
                            <p>Danh sách điểm:</p>
                            <p id='diem_list'>(Toán: 9, Văn: 8.5, Anh: 4.5)</p>
                        </div>  
                        <!-- chỉ hiển thị với sinh viên -->
                        <?php if($_SESSION['user']['role'] === 'Student'): ?>
                        <div class="info_layout" id="nganh_dky">
                            <div class="linediv">
                                <h1>Ngành xét tuyển</h1>
                            </div>
                            <div class="table_body_scroll" style="max-height:500px;">
                               <table class="choose_list" id="list_nganh_sv">
                                   <thead>
                                        <tr>
                                            <th id='ma_nganh'>Mã ngành</th>
                                            <th id='ten_nganh'>Tên ngành</th>
                                            <th id='tt_dky_nganh'>Tình trạng</th>
                                        </tr>
                                </thead>
                                   <tbody id="course_table_tuyen_sinh" >
                                       <script>
                                           var userRole = <?php echo json_encode($_SESSION['user']['role']); ?>;
                                        //    loadAndRenderCourses(userRole);
                                        //    Tương lai sẽ hiển thị kiểu khác
                                        </script>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif;?>
                         <!-- Chỉ hiển thị với giáo viên -->
                         <?php if($_SESSION['user']['role'] === 'Teacher'||$_SESSION['user']['role'] === 'Admin'): ?>
                        <div class="info_layout" id="nganh_pt">
                            <div class="linediv">
                                <h1>Ngành phụ trách</h1>
                                <?php if($_SESSION['user']['role'] === 'Admin'): ?>
                                <button type="submit" class="icon-button" id="qlnpt">
                                    <img src="../assets/icon/info_icon.png?v=<?php echo filemtime("../assets/icon/info_icon.png"); ?>" 
                                    alt="Quản lý ngành phụ trách" title="Quản lý ngành phụ trách" onclick="MovePage('quan-ly-phu-trach.php')">            
                                </button>
                                <?php endif; ?>
                            </div>
                            <div class="table_body_scroll" style="max-height:500px;">
                               <table class="choose_list" id="list_nganh_sv">
                                   <thead>
                                        <tr>
                                            <th id='ma_nganh'>Mã ngành</th>
                                            <th id='ten_nganh'>Tên ngành</th>
                                            <th id='chi_tieu'>Tình trạng</th>
                                            <th id='sl_sv'>Số lượng sinh viên</th>
                                        </tr>
                                    </thead>
                                   <tbody id="course_table_tuyen_sinh" >
                                       <script>
                                           var userRole = <?php echo json_encode($_SESSION['user']['role']); ?>;
                                        //    loadAndRenderCourses(userRole);
                                        //    Tương lai sẽ hiển thị kiểu khác
                                        </script>
                                    </tbody>
                                </table>
                            </div>  
                        </div> 
                        <?php endif; ?>
                        <!-- chỉ hiển thị với chính người dùng -->
                        <div style="margin-top: 10px; display: flex; justify-content: center; align-items: center;">
                        <button class="custom-button" onclick="location.href='change_password.php'">&#9998; THAY ĐỔI MẬT KHẨU</button>
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
