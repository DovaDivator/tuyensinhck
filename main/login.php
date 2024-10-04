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
                <br>
                <input type="password" name="password" id="password" placeholder="Mật khẩu" minlength="6" maxlength="20" pattern="[\x21-\x7E]+">
                <br>
                <input type="submit" value="Đăng nhập">
            </form>
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

        // Tạo đối tượng FormData để gửi yêu cầu POST
        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);

        // Gửi yêu cầu POST qua fetch
        fetch('../php_control/backend/LoginCheck.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text()) // Chuyển đổi phản hồi thành văn bản
            .then(text => {
                try {
                    const data = JSON.parse(text); // Chuyển đổi thành JSON
                    return data;
                } catch (error) {
                    console.error('JSON parsing error:', error);
                    Swal.fire({
                        title: "Lỗi hệ thống",
                        text: "Đã xảy ra lỗi khi xử lý dữ liệu.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            })
            .then(data => {
                if (data && data.success) {
                    Swal.fire({
                        title: "Đăng nhập thành công!",
                        width: 600,
                        padding: "3em",
                        color: "#716add",
                        background: "#fff url(https://sweetalert2.github.io/#downloadimages/trees.png)",
                        html: `
                        <img src="../assets/animated/nyan-cat.gif" style="width: 100px; display: block; margin: 20px auto 0;" alt="GIF">
                        `,
                        backdrop: `rgba(0,0,123,0.4)`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php';
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Tên đăng nhập hoặc mật khẩu sai",
                        text: "Vui lòng kiểm tra lại thông tin đăng nhập.",
                        width: 600,
                        padding: "3em",
                        color: "#716add",
                        background: "#fff url(https://sweetalert2.github.io/#downloadimages/trees.png)",
                        html: `
                        <p>Vui lòng kiểm tra lại tài khoản mật khẩu.</p>
                        <img src="../assets/animated/nyan-cat.gif" style="width: 150px; display: block; margin: 20px auto 0;" alt="GIF">
                        `,
                        backdrop: `rgba(0,0,123,0.4)`
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: "Lỗi kết nối",
                    text: "Không thể kết nối đến máy chủ. Vui lòng thử lại sau.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
    });
</script>

