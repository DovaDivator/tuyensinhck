<?php
session_start();
if (isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}
$passwordrequired = isset($_SESSION['passwordrequired']) ? $_SESSION['passwordrequired'] : '';
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
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
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
                <input type="text" name="username" id="username" placeholder="Họ Tên sinh viên">
                <input type="contactinfo" name="email" id="email" placeholder="Email">
                <span id='emailerror'></span>
                <input type="password" name="password" id="password" placeholder="Mật khẩu" pattern="[\x21-\x7E]+">
                <!-- <span class="alert-message"><?php echo $passwordrequired; ?></span> -->
                <span class="alert-message"></span>
                <input type="password" name="password_check" id="password_check" placeholder="Nhập lại mật khẩu" pattern="[\x21-\x7E]+">
                <div class="linediv" style="margin-bottom: 10px;">
                    <input type="checkbox" name="accept" id="accept">
                    <label for="accept">Bằng việc đăng ký, bạn đồng ý với <a href="chinhsachsudung.php">Chính sách sử dụng</a> của chúng tôi!</label>
                </div>
                <input type="submit" value="Đăng ký" name="register">
            </form>
            <a href="login.php" style="margin-top: 10px;">Đã có tài khoản, đăng nhập tại đây!</a>
        </div>
    </div>
    <?php
    // Xóa thông báo sau khi hiển thị
    unset($_SESSION['passwordrequired']);
    ?>


    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('../php_control/backend/registerCheck.php', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
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
                            icon: "success",
                            title: data.message,
                            showClass: {
                                popup: `
                                    animate__animated
                                    animate__fadeInUp
                                    animate__faster
                                    `
                                    },
                                    hideClass: {
                                        popup: `
                                    animate__animated
                                    animate__fadeOutDown
                                    animate__faster
                                    `
                            } 
                        });
                    } else {
                        Swal.fire({
                            title: data.message,
                            showClass: {
                                popup: `
                                    animate__animated
                                    animate__fadeInUp
                                    animate__faster
                                    `
                                    },
                                    hideClass: {
                                        popup: `
                                    animate__animated
                                    animate__fadeOutDown
                                    animate__faster
                                    `
                            }   
                        }).then(() => {

                            document.getElementById('password').value = '';
                            document.getElementById('password_check').value = '';
                            const emailSpan = document.getElementById('emailerror');
                            emailSpan.textContent = data.contact;
                            emailSpan.style.color = 'red'; // Đặt màu chữ
                            emailSpan.style.fontSize = '12px'; // Đặt kích thước chữ
                            emailSpan.style.paddingLeft = '10px'; // Sửa thuộc tính paddingLeft
                            emailSpan.style.marginBottom = '10px'; // Sửa thuộc tính marginBottom

                            const alertMessageSpan = document.querySelector('.alert-message');
                            alertMessageSpan.textContent = data.passwordcheck; // Cập nhật nội dung của span
                            alertMessageSpan.style.color = 'red'; // Đặt màu chữ
                            alertMessageSpan.style.fontSize = '12px'; // Đặt kích thước chữ
                            alertMessageSpan.style.paddingLeft = '10px'; // Sửa thuộc tính paddingLeft
                            alertMessageSpan.style.marginBottom = '10px'; // Sửa thuộc tính marginBottom
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Có lỗi xảy ra: ' + error.message,
                    });
                    console.log(error.message);
                });
        });
    </script>

</body>

</html>