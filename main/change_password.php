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
                        <div class="info_layout change_layout_div" id="change_pass_path">
                            <h1>Thay đổi mật khẩu</h1>
                            <form action="post">
                                <div class="form-fields">
                                    <label for="password">Mật khẩu hiện tại</label>
                                    <input type="password" id="password" name="password" placeholder="Nhập mật khẩu hiện tại" pattern="[\x21-\x7E]+" required>
                                    <label for="newpassword">Mật khẩu mới</label>
                                    <input type="password" id="newpassword" name="newpassword" placeholder="Mật khẩu tối thiểu 6 chữ cái!" pattern="[\x21-\x7E]+" required>
                                    <label for="newpassword1">Nhập lại mật khẩu</label>
                                    <input type="password" id="newpassword1" name="newpassword1" placeholder="Điền lại mật khẩu mới" pattern="[\x21-\x7E]+" required>
                                    <div class="linediv checkbox_div">
                                        <input type="checkbox" id="showPassword" onclick="togglePassword()">
                                        <label for="showPassword">Hiện mật khẩu</label>
                                    </div>
                                    <input type="submit" value="Xác nhận" name="change-pass-sumbit" class="custom-button">
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