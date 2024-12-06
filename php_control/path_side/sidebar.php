<!-- Thanh Nav bên trái -->
<div class="sidebar">
    <!-- Logo -->
    <div class="logo">
        <img src="../assets/images/logo-01.png?v=<?php echo filemtime('../assets/images/logo-01.png'); ?>" alt="Logo">
    </div>
    <!-- Danh sách lựa chọn sidebar -->
    <ul class="nav-links">
        <li><a href="#" onclick="HideNavigation()">⇐ Ẩn thanh công cụ</a></li>
        <li><a href="index.php">Trang chủ</a></li>
        <?php
            if($_SESSION['user']['role'] === 'Teacher'){
                echo '<li><a href="tra-cuu-chuyen-nganh.php">Tra cứu chuyên ngành</a></li>';
                echo '<li><a href="dssv.php">Danh sách sinh viên</a></li>';
            }elseif($_SESSION['user']['role'] === 'Admin'){
                echo '<li><a href="dssv.php">Danh sách sinh viên</a></li>';
                echo '<li><a href="qlnd.php">Quản lý người dùng</a></li>';
            }elseif($_SESSION['user']['role'] === 'Student'){
                echo '<li><a href="tra-cuu-chuyen-nganh.php">Tra cứu chuyên ngành</a></li>';
            }
        ?>
       <li><a href="thong-tin-tai-khoan.php">Thông tin tài khoản</a></li>
    </ul>
    <!-- Phần footer -->
    <div class="footer">
        <p>&copy; Nhóm: <br>&emsp;&emsp;Đồng Văn Thịnh <br>&emsp;&emsp;Dương Văn Quý Vương</p>
    </div>
</div>