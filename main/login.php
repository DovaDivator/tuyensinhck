<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header("location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web tuyển sinh - Đăng nhập</title>
    <link rel="icon" href="../assets/images/logo.png?v=<?php echo filemtime('../assets/images/logo.png'); ?>" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css?v=<?php echo filemtime("../assets/style/style.css") ?>">
    <link rel="stylesheet" href="../assets/style/login.css?v=<?php echo filemtime("../assets/style/login.css") ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js_backend/EC.js?v=<?php echo filemtime('../js_backend/EC.js'); ?>"></script>
    <script src="../js_backend/dialog.js?v=<?php echo filemtime('../js_backend/dialog.js'); ?>"></script>
    <script src="../js_backend/events.js?v=<?php echo filemtime('../js_backend/events.js'); ?>"></script>
</head>

<body id="login">
    <div class=blur></div>
    <div class="loginDiv">
        <div class="loginAnhDiv">
        </div>
        <div class="loginDivForm">
            <img src="../assets/images/logo-01.png?v=<?php echo filemtime("../assets/images/logo-01.png") ?>" class="uniLogo">
            <h1>Đăng nhập</h1>
            <!-- TODO: Tạm thời chuyển sang index.php sau khi đăng nhập hợp lệ -->
            <form action="" method="POST" id=loginForm>
                <input type="text" name="username" id="username" placeholder="Email/ SĐT/ ID người dùng">
                <input type="password" name="password" id="password" placeholder="Mật khẩu" minlength="6" maxlength="20" pattern="[\x21-\x7E]+">
                <div>
                    <input type="checkbox" id="showPassword" onclick="togglePassword()">
                    <label for="showPassword">Hiện mật khẩu</label>
                </div>
                <input type="submit" value="Đăng nhập">

            </form>
            <a href="register.php" style="margin-top: 10px;">Đăng ký tài khoản sinh viên ở đây!</a>
        </div>
    </div>

    <?php include '../php_control/path_side/LoadBar.php'; ?>
</body>

</html>

<script>
    // Ngăn chặn hành vi mặc định của sự kiện submit form
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();
        ShowLoading();

        // Lấy giá trị từ các trường input
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        // Kiểm tra xem các trường có được nhập hay chưa
        if (!username || !password) {
            HideLoading();
            WarmingDialog("Thiếu thông tin", "Vui lòng điền đầy đủ thông tin đăng nhập!");
            return; // Kết thúc nếu thiếu thông tin
        }

        // Tạo đối tượng XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../php_control/data/LoginCheck.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        // Xử lý phản hồi
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = xhr.responseText; // Lấy dữ liệu phản hồi

                // Nếu bạn không trả về JSON, xử lý phản hồi như một chuỗi
                if (response.trim() === "success") {
                    HideLoading();
                    window.location.href = 'index.php'; // Chuyển hướng nếu đăng nhập thành công
                } else if (response.trim().startsWith("confirm: ")) {
                    const errorMessage = response.replace("confirm: ", "");
                    HideLoading();
                    ConfirmDialog("Thông báo", errorMessage + " Bạn có muốn gửi lại thư xác nhận không?", "Gửi lại", "Bỏ qua").then((isConfirm) => {
                        if (isConfirm) {
                            const xhr2 = new XMLHttpRequest();
                            xhr2.open("POST", "../php_control/data/SendVerifyEmail.php", true);
                            xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr2.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                            xhr2.onload = function() {
                                const response2 = xhr2.responseText;
                                if (xhr2.status === 200) {
                                    if (response2.trim() == 200) {
                                        SuccessDialog("Thông báo!", "Đã gửi thư xác minh, vui lòng truy cập email để xác thực người dùng.");
                                    } else {
                                        ErrorDialog("Thông báo lỗi", "Đã có sự cố xảy ra, vui lòng thử lại sau! (" + response2 + ")");
                                    }
                                } else {
                                    ErrorDialog("Lỗi kết nối", "Không thể kết nối đến máy chủ. Vui lòng thử lại sau.");
                                }
                            }
                            xhr2.send();
                        } else {
                            <?php unset($_SESSION['email_confirm']); ?>
                        }
                    });
                } else {
                    const errorMessage = response.replace("error: ", "");
                    HideLoading();
                    ErrorDialog("Lỗi đăng nhập", errorMessage);
                }
            } else {
                HideLoading();
                ErrorDialog("Lỗi kết nối", "Không thể kết nối đến máy chủ. Vui lòng thử lại sau.");
            }
        };

        // Gửi dữ liệu đến server
        xhr.send(`username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`);
    });


    // Hiện MK

    function togglePassword() {
        var passwordInput = document.getElementById("password");
        var checkbox = document.getElementById("showPassword");


        if (checkbox.checked) {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
</script>