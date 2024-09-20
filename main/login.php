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
            <form action="index.php" method="POST">
                <input type="text" name="username" id="username" placeholder="Tên đăng nhập" required>
                <input type="password" name="password" id="password" placeholder="Mật khẩu" minlength="6" maxlength="20">
                <input type="submit" value="Đăng nhập">
            </form>
        </div>
    </div>
</body>
</html>