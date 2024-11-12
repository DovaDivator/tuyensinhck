<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực thành công</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">

</head>
<body>

<div class="container text-center mt-5">
    <div class="card shadow-lg p-3 mb-5 bg-white rounded">
        <div class="card-body">
            <h1 class="text-success"><i class="fas fa-check-circle fa-2x"></i></h1>
            <h2 class="card-title">Xác Nhận Thành Công!</h2>
            <p class="card-text mt-3">Tài khoản của bạn đã được xác thực thành công, vui lòng ấn vào nút ở dưới để quay về trang web.</p>
            <a href="../main/login.php" class="btn btn-primary mt-3">Quay về trang chủ</a>
        </div>
        
        <!-- Phần Footer Chia Làm Hai -->
        <div class="card-footer justify-content-between align-items-center">
            <!-- Logo -->
            <img src="../assets/images/logo-01.png?v=<?php echo filemtime('../assets/images/logo-01.png'); ?>" alt="Logo" style="height: 40px;">
            
            <!-- Text bản quyền -->
            <p class="mb-0" style="font-size:12px">© 2024 Tuyển sinh by Vương and Thịnh.</p>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
