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
    <title>Web Tuyển sinh - Trang chủ</title>
    <link rel="icon" href="../assets/images/logo.png?v=<?php echo filemtime('../assets/images/logo.png'); ?>" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css?v=<?php echo filemtime('../assets/style/style.css'); ?>">
    <link rel="stylesheet" href="../assets/style/taikhoan.css?v=<?php echo filemtime('../assets/style/taikhoan.css'); ?>">
    <link rel="stylesheet" href="../assets/style/table.css?v=<?php echo filemtime('../assets/style/table.css'); ?>">
    <link rel="stylesheet" href="../assets/style/CSTT.css?v=<?php echo filemtime('../assets/style/CSTT.css'); ?>">

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
                                <h1>Chỉnh sửa thông tin</h1>
                            </div>

                            <div class="container">
                                <div class="text">
                                    Thông tin cá nhân
                                </div>
                                <form action="#">
                                    <?php
                                       // echo $_SESSION['user']['role'];
                                        if (isset($_SESSION['user']) && $_SESSION['user']['role']  === "Admin") {
                                            echo '<div class="form-row">
                                            <div class="input-data">
                                            <input type="text" value=" cái này lấy trong CSDL " required>
                                            <div class="underline"></div>
                                            <label for="">'. 'ID' .'</label>
                                            </div>
                                            </div>';
                                        } 
                                    ?>
                                    <div class="form-row">
                                        <div class="input-data">
                                            <input type="text" value="sau này chuyển thành php trong này lấy dữ liệu bên CSDL" required>
                                            <div class="underline"></div>
                                            <label for="">Họ và tên </label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-data">
                                            <input type="date" value="2024-10-28" required>
                                            <div class="underline"></div>
                                            <label for="">Ngày sinh</label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-data">
                                            <input type="text" value="" required>
                                            <div class="underline"></div>
                                            <label for="">Email</label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-data">
                                            <input type="text" value="" required>
                                            <div class="underline"></div>
                                            <label for="">SDT</label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-data">
                                            <input type="text" value="" required>
                                            <div class="underline"></div>
                                            <label for="">Website Name</label>
                                        </div>
                                    </div>

                                    <div class="form-row submit-btn">
                                        <div class="input-data">
                                            <div class="inner"></div>
                                            <input type="submit" value="submit">
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>

                </div>
            </div>


        </div>
    </div>
    </div>
</body>

</html>