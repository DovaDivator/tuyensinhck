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
                <input type="text" name="username" id="username" placeholder="Tên đăng nhập" required>
                <input type="password" name="password" id="password" placeholder="Mật khẩu" minlength="6" maxlength="20" pattern="[\x21-\x7E]+">
                <input type="submit" value="Đăng nhập">
            </form>
            <a href="register.php" style="margin-top: 10px;">Đăng ký tài khoản sinh viên ở đây!</a>
        </div>
    </div>

</body>

</html>

<script>
    // Ngăn chặn hành vi mặc định của sự kiện submit form
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();

        // Lấy giá trị từ các trường input
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        // Kiểm tra xem các trường có được nhập hay chưa
        if (!username || !password) {
            Swal.fire({
                title: "Thiếu thông tin",
                text: "Vui lòng nhập đầy đủ tài khoản và mật khẩu.",
                icon: "warning",
                confirmButtonText: "OK"
            });
            return; // Kết thúc nếu thiếu thông tin
        }

        // Tạo đối tượng XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../php_control/backend/LoginCheck.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        // Xử lý phản hồi
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = xhr.responseText; // Lấy dữ liệu phản hồi

                // Nếu bạn không trả về JSON, xử lý phản hồi như một chuỗi
                if (response.trim() === "success") {
                    window.location.href = 'index.php'; // Chuyển hướng nếu đăng nhập thành công
                } else {
                    const errorMessage = response.replace("error: ", "");
                    Swal.fire({
                        title: "Lỗi đăng nhập",
                        text: errorMessage,
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            } else {
                Swal.fire({
                    title: "Lỗi kết nối",
                    text: "Không thể kết nối đến máy chủ. Vui lòng thử lại sau.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        };

        // Gửi dữ liệu đến server
        xhr.send(`username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`);
    });
</script>
