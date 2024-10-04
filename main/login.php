<?php
    session_start();
    if (isset($_SESSION['user'])){
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
    <link rel="stylesheet" href="../assets/style/style.css?v=<?php echo filemtime("../assets/style/style.css")?>">
    <link rel="stylesheet" href="../assets/style/login.css?v=<?php echo filemtime("../assets/style/login.css")?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body id="login">
    <div class=blur></div>
    <div class="loginDiv">
        <div class="loginAnhDiv">
        </div>
        <div class="loginDivForm">
            <img src="../assets/images/logo-01.png?v=<?php echo filemtime("../assets/images/logo-01.png")?>" class="uniLogo">
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
    document.getElementById('loginForm').addEventListener('submit', function(e) {
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