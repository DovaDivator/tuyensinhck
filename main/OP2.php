<!-- Hàm kiểm tra trang đã đăng nhập chưa -->
<!-- <?php
// session_start();

// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit();
// }
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Tuyển sinh - Trang chủ</title>
    <link rel="icon" href="../assets/images/logo.png" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css">
    <script src="../js_backend/events.js"></script>
</head>
<body>
    <div class="container">
        <!-- Nút hiện ẩn thanh sidebar -->
        <div class="nav-toggle" onclick="ShowNavigation()">
            <div class="nav-toggle-icon"></div>
        </div>

        <!-- Thanh Nav bên trái -->
        <div class="sidebar">
            <!-- Logo -->
            <div class="logo">
                <img src="../assets/images/logo-01.png" alt="Logo">
            </div>
            <!-- Danh sách lựa chọn sidebar -->
            <ul class="nav-links">
                <li><a href="#" onclick="HideNavigation()">⇐ Ẩn thanh công cụ</a></li>
                <!-- TODO: Tạo trang danh mục chuyển trang sang các trang php khác, phân luồng hợp lý. Trang sử dụng cấu trúc này-->
                <li><a href="OP1.php">Lựa chọn 1</a></li>
                <li><a href="OP2.php">Lựa chọn 2</a></li>
                <li><a href="Thongke.php">Thống kê hồ sơ</a></li>
                <li><a href="#">lựa chọn</a></li>
                <li><a href="login.php">Đăng xuất</a></li>
            </ul>
        </div>
        
        <div class="right-side">
            <!-- Thanh bar trên cùng -->
            <div class="navbar">
                <div class="navbar-content">
                    <!-- thông tin người dùng -->
                    <div class="user-info">
                        <img class="avatar" src="">
                        <div class="user-details">
                            <p class="username"> Nguyễn Trọng Quốc Việt
                                <!-- TODO: (all) Truy vấn tìm tên người dùng -->
                            </p>
                            <p class="user-id">ID: 2313131321
                                <!-- TODO: (all) Truy vấn tìm ID-->
                            </p>
                            <p class="user-role">Vai trò: Duck Hunter
                                <!-- TODO: (all) Truy vấn hiện vai trò -->
                            </p>
                        </div>
                    </div>
                    <!-- nút điều hướng -->
                    <form action="" method="GET" style="display: inline;">
                        <button type="submit" class="icon-button" name="notification">
                            <img src="../assets/icon/noti_icon.png" alt="Thông báo" title="Thông báo">
                        </button>
                        <button type="submit" class="icon-button" name="changeinfo">
                            <img src="../assets/icon/info_icon.png" alt="Chỉnh sửa thông tin" title="Chỉnh sửa thông tin">
                        </button>
                        <button type="submit" class="icon-button" name="logout">
                            <img src="../assets/icon/logout_icon.png" alt="Đăng xuất" title="Đăng xuất">
                        </button>
                    </form>
                </div>
            </div>

            <!-- Nội dung chính -->
            <div class="main-content">
                <h1>Chào mừng đến với lựa chọn 2</h1>
                <p>Đây là phần nội dung chính của trang web.</p>
            </div>
            
            <!-- Phần footer -->
            <div class="footer">
                <p>&copy; Nhóm: Đồng Văn Thịnh & Dương Văn Quý Vương</p>
            </div>
        </div>
    </div>
</body>
</html>