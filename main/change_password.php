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
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var passwordInput1 = document.getElementById("newpassword");
            var passwordInput2 = document.getElementById("newpassword1");
            var checkbox = document.getElementById("showPassword");

           
            if (checkbox.checked) {
                passwordInput.type = "text"; 
                passwordInput1.type = "text";
                passwordInput2.type = "text";  
            } else {
                passwordInput.type = "password"; 
                passwordInput1.type = "password";
                passwordInput2.type = "password";  
            }
        }
    </script>
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
                                    <div class="form-row">
                                        <div class="input-data">
                                            <input type="password" id= "password" value="" required>
                                            <div class="underline"></div>
                                            <label for="">Mật khẩu hiện tại</label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-data">
                                            <input type="password" id="newpassword" value="" required>
                                            <div class="underline"></div>
                                            <label for="">Mật khẩu mới</label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-data">
                                            <input type="password" id="newpassword1" value="" required>
                                            <div class="underline"></div>
                                            <label for="">Nhập lại mật khẩu mới</label>
                                        </div>
                                    </div>

                                    <div class="form-row submit-btn">
                                        <div class="input-data">
                                            <div class="inner"></div>
                                            <input type="submit" value="submit">
                                        </div>
                                        <input type="checkbox" id="showPassword" onclick="togglePassword()">
                                        <label for="showPassword">Hiện mật khẩu</label>
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