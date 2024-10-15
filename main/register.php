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
    <title>Tuyển sinh - Đăng ký tài khoản</title>
    <link rel="icon" href="../assets/images/logo.png?v=<?php echo filemtime('../assets/images/logo.png'); ?>" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css?v=<?php echo filemtime("../assets/style/style.css") ?>">
    <link rel="stylesheet" href="../assets/style/login.css?v=<?php echo filemtime("../assets/style/login.css") ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body id="login">
    <div class=blur></div>
    <div class="registerDiv">
        <div class="registerDivForm ">
            <img src="../assets/images/logo-01.png?v=<?php echo filemtime("../assets/images/logo-01.png") ?>" class="uniLogo">
            <h1>Đăng ký</h1>
            <!-- TODO: Tạm thời chuyển sang index.php sau khi đăng nhập hợp lệ -->
            <form action="" method="POST" id=registerForm>
                <input type="text" name="username" id="username" placeholder="Họ Tên sinh viên" required>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="text" name="phone" id="phone" placeholder="Số điện thoại">
                <input type="password" name="password" id="password" placeholder="Mật khẩu" minlength="6" value="" maxlength="20" pattern="[\x21-\x7E]+">
                <input type="password" name="password_check" id="password_check" placeholder="Nhập lại mật khẩu" minlength="6" maxlength="20" pattern="[\x21-\x7E]+">
                <div class="linediv" style="margin-bottom: 10px;">
                    <input type="checkbox" name="accept" id="accept">
                    <label for="accept">Bằng việc đăng ký, bạn đồng ý với <a href="chinhsachsudung.php">Chính sách sử dụng</a> của chúng tôi!</label>
                </div>
                <input type="submit" value="Đăng ký">
            </form>
            <a href="login.php" style="margin-top: 10px;">Đã có tài khoản, đăng nhập tại đây!</a>
        </div>
    </div>


    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault(); 
            const formData = new FormData(this);
            fetch('../php_control/backend/registerCheck.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json(); 
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: data.message,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: data.message,
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Có lỗi xảy ra: ' + error.message,
                });
            });
        });
    </script>

</body>

</html>