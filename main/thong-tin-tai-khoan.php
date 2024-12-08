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
include "../php_control/data/get_infomation.php";

if($_SESSION['user']['role'] === 'Student'){
    include "../php_control/data/get_ho_so.php";
    $info = GetHoSo($_SESSION['user']['id']);
}

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
                            </div>
                            <div class="linediv" style="gap:30px; align-items:flex-start;">
                                <div class="avatar_container disable" style="width: 200px; height: 200px; 
                                background-image: url('<?php if ($_SESSION['user']['avatar_name'] != '') {
                                                            echo $_SESSION['user']['avatar_name'];
                                                        } else {
                                                            echo "../assets/images/Guest_user.png?v=" . filemtime('../assets/images/Guest_user.png');
                                                        }   ?>'); background-size: cover; background-position: center;" onclick="MovePage('chinhsuathongtin.php')">
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
                                        } elseif ($_SESSION['user']['role'] === 'Teacher') {
                                            echo 'Giáo viên';
                                        }
                                        ?>
                                    </p>
                                    <p id="email">Email: <a href="#" title="Liên hệ email"><?php echo $_SESSION['user']['email']; ?></a></p>
                                    <p id="sdt">SĐT: <a
                                            <?php if ($_SESSION['user']['phone'] !== null) {
                                                echo 'href="#" title="Liên hệ số điện thoại">' . $_SESSION['user']['phone'];
                                            } else {
                                                echo 'href="#" title="Người dùng chưa cập nhật số điện thoại"> Không có';
                                            }
                                            ?></a></p>
                                        <?php if ($_SESSION['user']['role'] === 'Student'){
                                            echo '<p td="trang_thai">Trạng thái: ';
                                            switch ($_SESSION['user']['trang_thai']){
                                                case 1:
                                                    echo "<font color='red'>Chưa đăng ký hồ sơ</font>";
                                                    break;
                                                case 2:
                                                    echo "<font color='orange'>Đang chờ xét duyệt hồ sơ</font>";
                                                    break;
                                                case 3:
                                                    echo "<font color='red'>Yêu cầu chỉnh sửa lại hồ sơ</font>";
                                                    break;
                                                case 4:
                                                    echo "<font color='yellow'>Đã xác thực hồ sơ, chưa chọn ngành</font>";
                                                    break;
                                                case 5:
                                                    echo "<font color='yellow'>Đang chờ xác nhận đăng ký ngành</font>";
                                                    break;
                                                case 6:
                                                    echo "<font color='green'>Đã đăng ký thành công</font>";
                                                    break;
                                                default:
                                                    echo "<font color='red'>Không xác định</font>";
                                                    break;
                                            }
                                            echo "</p>";
                                        }
                                        ?>
                                    <?php if ($_SESSION['user']['role'] === 'Teacher'): ?>
                                        <p id='khoa'>Khoa: <b><?php echo GetKhoaDaoTao($_SESSION['user']['id'])?> </b></p>
                                    <?php endif; ?>
                                    <p id='date_created'>Ngày đăng ký: 
                                    <?php 
                                        $created_acc = GetDateAccCreated($_SESSION['user']['id']);
                                        if($created_acc != ''){
                                            echo (new DateTime(substr($created_acc, 0, 19)))->format('(H\hi) d/m/Y');
                                        }else{
                                            echo $created_acc;
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($_SESSION['user']['role'] == 'Student'): ?>
                            <div class="info_layout" id="hoso_path">
                                <div class="linediv">
                                    <h1>Hồ sơ sinh viên</h1>
                                    <?php if ($_SESSION['user']['role'] === 'Admin'): ?>
                                        <button type="submit" class="icon-button" id="kiemduyetsv">
                                            <img src="../assets/icon/info_icon.png?v=<?php echo filemtime("../assets/icon/info_icon.png"); ?>"
                                                alt="Kiểm duyệt hồ sơ" title="Kiểm duyệt hồ sơ" onclick="MovePage('kiem-duyet-ho-so.php')">
                                        </button>
                                    <?php endif; ?>
                                </div>
                                <!-- sau này thêm điều kiện hiển thị -->
                                <?php
                                include '../php_control/data/db_connect.php';
                                function fetchGVforNgang($pdo)
                                {
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
                                <p id='hoso_log'><b>
                                        <font color="red">Bạn chưa đăng ký hồ sơ! </font><a href="nop-ho-so.php">Ấn vào đây để đăng ký</a>
                                    </b></p>
                                <p id='cccd'>CCCD: <?php echo !empty($info['cccd']) ? $info['cccd'] : "Chưa nhập"; ?></p>
                                <p id='gender'>Giới tính: <?php echo !empty($info['gender']) ? $info['gender'] : "Chưa nhập"; ?></p>
                                <p id='birth_date'>Ngày sinh: <?php echo !empty($info['date_of_birth']) ? date('d/m/Y', strtotime($info['date_of_birth'])) : "Chưa nhập"; ?></p>
                                <p id='address'>Địa chỉ: <?php echo !empty($info['address']) ? $info['address'] : "Chưa nhập"; ?></p>
                                <p id='hinhthucts'>Hình thức tuyển sinh: <?php echo !empty($info['ma_htts']) ? $info['ma_htts'] : "Chưa nhập"; ?></p>
                                <p id='id_ts'>Mã tuyển sinh: <?php echo !empty($info['ma_tuyen_sinh']) ? $info['ma_tuyen_sinh'] : "Chưa nhập"; ?></p>
                                <p>Danh sách điểm:</p>
                                <p id='diem_list'><?php echo !empty($info['diem']) ? $info['diem'] : "(Chưa nhập)"; ?></p>
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
                        <?php if ($_SESSION['user']['role'] === 'Teacher'): ?>
                            <div class="info_layout" id="nganh_pt">
                                <div class="linediv">
                                    <h1>Ngành phụ trách</h1>
                                    <?php if ($_SESSION['user']['role'] === 'Admin'): ?>
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