<<<<<<< HEAD
<?php
    session_start();
    if (isset($_SESSION['user'])){
        header("location: index.php");
        exit();
    }
?>

=======
<<<<<<< HEAD
=======
<?php
session_start();
if (isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}
?>

>>>>>>> bfeae6c (add hộp thông báo)
>>>>>>> 51c38ec7c0d840cf9c9b80d30d8092b6a25fb44d
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
<<<<<<< HEAD
            <form action="" method="POST" id=loginForm>
=======
<<<<<<< HEAD
            <form action="" method="POST">
>>>>>>> 51c38ec7c0d840cf9c9b80d30d8092b6a25fb44d
                <input type="text" name="username" id="username" placeholder="Tên đăng nhập" required> 
=======
            <form action="" method="POST" id=loginForm>
                <input type="text" name="username" id="username" placeholder="Tên đăng nhập" required>
>>>>>>> bfeae6c (add hộp thông báo)
                <br>
                <input type="password" name="password" id="password" placeholder="Mật khẩu" minlength="6" maxlength="20" pattern="[\x21-\x7E]+">
                <br>
                <input type="submit" value="Đăng nhập">
            </form>
        </div>
    </div>

</body>
<<<<<<< HEAD
=======
<<<<<<< HEAD
</html>
=======

>>>>>>> 51c38ec7c0d840cf9c9b80d30d8092b6a25fb44d
</html>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
<<<<<<< HEAD
    e.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    const formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);

    fetch('../php_control/backend/LoginCheck.php', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(text => {
        console.log(text);
        return JSON.parse(text);
    })
    .then(data => {
        if (data.success) {
            window.location.href = 'index.php';
        } else {
            alert('Tên đăng nhập hoặc mật khẩu không chính xác.');
        }
    })
    .catch(error => console.error('Error:', error));
});

</script>
=======
        e.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);

        fetch('../php_control/backend/LoginCheck.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(text => {
                console.log(text);
                return JSON.parse(text);
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: "Đăng nhập thành công.",
                        width: 600,
                        padding: "3em",
                        color: "#716add",
                        background: "#fff url(https://sweetalert2.github.io/#downloadimages/trees.png)",
                        html: `
                        <img src="../assets/animated/nyan-cat.gif" style="width: 100px; display: block; margin: 20px auto 0;" alt="GIF">
                        `,
                        backdrop: `
                                    rgba(0,0,123,0.4)
                                `
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php';
                        }
                    });
                    //window.location.href = 'index.php';
                } else {
                    // Thông báo tk mk sai 
                    Swal.fire({
                        title: "Tên đăng nhập hoặc mật khẩu sai.",
                        width: 600,
                        padding: "3em",
                        color: "#716add",
                        background: "#fff url(https://sweetalert2.github.io/#downloadimages/trees.png)",
                        html: `
                        <p>Vui lòng kiểm tra lại tài khoản mật khẩu.</p>
                        <img src="../assets/animated/nyan-cat.gif" style="width: 150px; display: block; margin: 20px auto 0;" alt="GIF">
                        `,
                        backdrop: `
                                    rgba(0,0,123,0.4)
                                `
                    });

                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>
>>>>>>> bfeae6c (add hộp thông báo)
>>>>>>> 51c38ec7c0d840cf9c9b80d30d8092b6a25fb44d
