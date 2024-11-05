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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"  />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js_backend/dialog.js?v=<?php echo filemtime('../js_backend/dialog.js'); ?>"></script>
    <script src="../js_backend/events.js?v=<?php echo filemtime('../js_backend/events.js'); ?>"></script>

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
                <input type="email" name="email" id="email" placeholder="Email">
                <!-- <span id='emailerror'></span> -->
                <input type="password" name="password" id="password" placeholder="Mật khẩu" pattern="[\x21-\x7E]+">
                <!-- <span class="alert-message"><?php //echo $passwordrequired; ?></span> -->
                <!-- <span class="alert-message"></span> -->
                <input type="password" name="password_check" id="password_check" placeholder="Nhập lại mật khẩu" pattern="[\x21-\x7E]+">
                <div class="linediv" style="margin-bottom: 10px;">
                    <input type="checkbox" name="accept" id="accept">
                    <label for="accept">Bằng việc đăng ký, bạn đồng ý với <a href="chinhsachsudung.php" target="_blank">Chính sách sử dụng</a> của chúng tôi!</label>
                </div>
                <input type="submit" value="Đăng ký">
            </form>
            <a href="login.php" style="margin-top: 10px;">Đã có tài khoản, đăng nhập tại đây!</a>
        </div>
    </div>
    <?php
    // Xóa thông báo sau khi hiển thị
    unset($_SESSION['passwordrequired']);
    ?>
    
    <?php include '../php_control/path_side/LoadBar.php'; ?>
</body>

</html>

<script>
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault();
        //     const formData = new FormData(this);
        //     fetch('../php_control/backend/registerCheck.php', {
        //             method: 'POST',
        //             body: formData,
        //             headers: {
        //                 'X-Requested-With': 'XMLHttpRequest'
        //             }
        //         })
        //         .then(response => {
        //             if (!response.ok) {
        //                 throw new Error('Network response was not ok: ' + response.statusText);
        //             }
        //             return response.json();
        //         })
        //         .then(data => {
        //             if (data.success) {
        //                 Swal.fire({
        //                     icon: "success",
        //                     title: data.message,
        //                     showClass: {
        //                         popup: `
        //                             animate__animated
        //                             animate__fadeInUp
        //                             animate__faster
        //                             `
        //                             },
        //                             hideClass: {
        //                                 popup: `
        //                             animate__animated
        //                             animate__fadeOutDown
        //                             animate__faster
        //                             `
        //                     } 
        //                 });
        //             } else {
        //                 Swal.fire({
        //                     title: data.message,
        //                     showClass: {
        //                         popup: `
        //                             animate__animated
        //                             animate__fadeInUp
        //                             animate__faster
        //                             `
        //                             },
        //                             hideClass: {
        //                                 popup: `
        //                             animate__animated
        //                             animate__fadeOutDown
        //                             animate__faster
        //                             `
        //                     }   
        //                 }).then(() => {

        //                     document.getElementById('password').value = '';
        //                     document.getElementById('password_check').value = '';
        //                     const emailSpan = document.getElementById('emailerror');
        //                     emailSpan.textContent = data.contact;
        //                     emailSpan.style.color = 'red'; // Đặt màu chữ
        //                     emailSpan.style.fontSize = '12px'; // Đặt kích thước chữ
        //                     emailSpan.style.paddingLeft = '10px'; // Sửa thuộc tính paddingLeft
        //                     emailSpan.style.marginBottom = '10px'; // Sửa thuộc tính marginBottom

        //                     const alertMessageSpan = document.querySelector('.alert-message');
        //                     alertMessageSpan.textContent = data.passwordcheck; // Cập nhật nội dung của span
        //                     alertMessageSpan.style.color = 'red'; // Đặt màu chữ
        //                     alertMessageSpan.style.fontSize = '12px'; // Đặt kích thước chữ
        //                     alertMessageSpan.style.paddingLeft = '10px'; // Sửa thuộc tính paddingLeft
        //                     alertMessageSpan.style.marginBottom = '10px'; // Sửa thuộc tính marginBottom
        //                 });
        //             }
        //         })
        //         .catch(error => {
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Lỗi!',
        //                 text: 'Có lỗi xảy ra: ' + error.message,
        //             });
        //             console.log(error.message);
        //         });
            
        ShowLoading();

        // Lấy giá trị từ các trường input
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const password_check = document.getElementById('password_check').value.trim();
        const checker = document.getElementById('accept');

        // Kiểm tra xem các trường có được nhập hay chưa
        if (!username || !password || !password_check || !email) {
            HideLoading();
            WarmingDialog("Thiếu thông tin","Vui lòng điền đầy đủ thông tin đăng nhập!");
            return; // Kết thúc nếu thiếu thông tin
        }

        if(password != password_check) {
            HideLoading();
            ErrorDialog("Lỗi thông tin","Mật khẩu không khớp!");
            return; // Kết thúc nếu mật khẩu không kh��p
        }

        if(!checker.checked){
            HideLoading();
            WarmingDialog("Thông báo","Vui lòng đọc điều khoản dịch vụ rồi đánh dấu!");
            return; // Kết thúc nếu thiếu thông tin
        }

        // Tạo đối tượng XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../php_control/data/registerCheck.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        // Xử lý phản hồi
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = xhr.responseText; // Lấy dữ liệu phản hồi

                // Nếu bạn không trả về JSON, xử lý phản hồi như một chuỗi
                if (response.trim() === "success") {
                    HideLoading();
                    window.location.href = 'login.php?register=true';
                } else {
                    const errorMessage = response.replace("error: ", "");
                    HideLoading();
                    ErrorDialog("Lỗi đăng ký", errorMessage);
                }
            } else {
                HideLoading();
                ErrorDialog("Lỗi kết nối", "Không thể kết nối đến máy chủ. Vui lòng thử lại sau.");
            }
        };

        // Gửi dữ liệu đến server
        xhr.send(`username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}&email=${encodeURIComponent(email)}`);
    });
    </script>