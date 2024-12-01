<?php


session_start();
if (isset($_SESSION['user'])) {
    //echo "<script>alert('welcom');</script>";
} else {
    //echo "<script>alert('pls login');</script>";
    header("Location: login.php");
    exit();
}

if (isset($_GET['rolecheck'])) {
    $role = $_GET['rolecheck'];
    echo "<script>console.log('PHP Data: " .  $role . "');</script>";

    if ($role === 'gv') {
        if (isset($_GET['ma_gv'])) {
            $id = $_GET['ma_gv'];
            echo "<script>console.log('PHP Data: " .  $_GET['ma_gv'] . "');</script>";
        } else {
            echo "Thiếu tham số!";
        }
    }

    if ($role === 'sv') {
        if (isset($_GET['masv'])) {
            $id = $_GET['masv'];
            echo "<script>console.log('PHP Data: " .  $_GET['masv'] . "');</script>";

        }else {
            echo "khong nhan duoc du lieu";
            
        }
    }
}
echo "<script>console.log('id: " .  $id . "');</script>";

 include "../php_control/data/get_infomation.php";
 $course = get_user_info($id);
 echo "<script>console.log('sdt: " .  $course['ten'] . "');</script>";

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
                                <h1>Thông tin chi tiết id: <?php echo $course['id']; ?></h1> 
                                    <button type="submit" class="icon-button" id="blockAcc">
                                        <img src="../assets/icon/banning.png?v=<?php echo filemtime("../assets/icon/banning.png"); ?>"
                                            alt="Đình chỉ tài khoản" title="Đình chỉ tài khoản" onclick="">
                                    </button>
                            </div>
                            <div class="linediv" style="gap:30px; align-items:flex-start;">
                                <div class="avatar_container disable" style="width: 200px; height: 200px; 
                                background-image: url('<?php if ($_SESSION['user']['avatar_name'] != '') {
                                                            echo $_SESSION['user']['avatar_name'];
                                                        } else {
                                                            echo "../assets/images/Guest_user.png?v=" . filemtime('../assets/images/Guest_user.png');
                                                        }   ?>'); background-size: cover; background-position: center;" onclick="MovePage('')">
                                </div>
                                <div class="info_text_container">
                                    <h2 style='margin-top: 0;'><?php echo $course['ten']; ?></h2>
                                    <p id="id_user">ID: <?php echo $course['id']; ?></p>
                                    <p id="role">Vai trò:
                                        <?php
                                        if ($role === 'sv') {
                                            echo 'Sinh viên';
                                        } elseif ($role === 'gv') {
                                            echo 'Giáo viên';
                                        }
                                        ?>
                                    </p>
                                    <p id="email">Email: <a href="#" title="Liên hệ email"><?php echo $course['email']; ?></a></p>
                                    <p id="sdt">SĐT: <a
                                            <?php if ($course['phone'] !== null) {
                                                echo 'href="#" title="Liên hệ số điện thoại">' . $course['phone'];
                                            } else {
                                                echo 'href="#" title="Người dùng chưa cập nhật số điện thoại"> Không có';
                                            }
                                            ?></a></p>                  
                                    <?php if ($role === 'gv'): ?>
                                        <p id='khoa'>Khoa: </p>
                                    <?php endif; ?>
                                    <p id='date_created'>Ngày đăng ký: 
                                  
                                </div>
                            </div>
                        </div>
                        <?php if ( $role == 'sv'): ?>
                            <div class="info_layout" id="hoso_path">
                                <div class="linediv">
                                    <h1>Hồ sơ sinh viên</h1>
                                <?php
                                $chitietsv = getSV($id);
                                echo "<script>console.log('id sv: " .  $chitietsv['date_of_birth'] . "');</script>";

                                ?>
                                </div>                        
                                <P id='cccd'>CCCD:     <?php echo !empty($chitietsv['cccd']) ? $chitietsv['cccd'] : "Chưa nhập"; ?>
                                </p>
                                <p id='gender'>Giới tính:</p>
                                <p id='birth_date'>Ngày sinh: <?php echo !empty($chitietsv['date_of_birth']) ? date('d/m/Y', strtotime($chitietsv['date_of_birth'])) : "Chưa nhập"; ?>
                                </p>
                                <p id='address'>Địa chỉ:    <?php echo !empty($chitietsv['address']) ? $chitietsv['address'] : "Chưa nhập"; ?>
                                </p>
                                <p id='hinhthucts'>Hình thức tuyển sinh:     <?php echo !empty($chitietsv['ma_htts']) ? $chitietsv['ma_htts'] : "Chưa nhập"; ?>
                                </p>
                                <p id='id_ts'>Mã tuyển sinh:    <?php echo !empty($chitietsv['ma_tuyen_sinh']) ? $chitietsv['ma_tuyen_sinh'] : "Chưa nhập"; ?>
                                </p>
                                <p>Danh sách điểm:</p>
                                <p id='diem_list'>(Toán: 9, Văn: 8.5, Anh: 4.5)</p>
                            </div>
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
                                        <tbody id="course_table_tuyen_sinh">
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
                        <!-- Chỉ hiển thị với giáo viên -->
                        <?php if ( $role === 'gv'): ?>
                            <div class="info_layout" id="nganh_pt">
                                <div class="linediv">
                                    <h1>Ngành phụ trách</h1>
                                    <?php if ($_SESSION['user']['role'] === 'Admin'): ?>
                                        <button type="submit" class="icon-button" id="qlnpt">
                                            <img src="../assets/icon/info_icon.png?v=<?php echo filemtime("../assets/icon/info_icon.png"); ?>"
                                                alt="Quản lý ngành phụ trách" title="Quản lý ngành phụ trách" onclick="MovePage(' ')">
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
                                        <tbody id="course_table_tuyen_sinh">
                                            <script>
                                                var userRole = <?php echo json_encode($role); ?>;
                                                

                                            </script>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>
                        <!-- chỉ hiển thị với chính người dùng -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>