<!-- Thanh Nav bên trái -->
<div class="sidebar">
    <!-- Logo -->
    <div class="logo">
        <img src="../assets/images/logo-01.png?v=<?php echo filemtime('../assets/images/logo-01.png'); ?>" alt="Logo">
    </div>
    <!-- Danh sách lựa chọn sidebar -->
    <ul class="nav-links">
        <li><a href="#" onclick="HideNavigation()">⇐ Ẩn thanh công cụ</a></li>
        <li><a href="../php_control/backend/indexRole.php">Trang chủ</a></li>
        <li><a href="../php_control/backend/QLHSRole.php">Quản lí hồ sơ</a></li>
        <li><a href="CTHS.php">Chi tiết hồ sơ</a></li>
        <?php
            if($_SESSION['user']['role'] === 'Admin'){
                echo '<li><a href="ThongKe.php">Thống kê hồ sơ</a></li>';
            }
        ?>
       <!-- <li><a href="../php_control/backend/QLHSRole.php">TEST</a></li> -->
    </ul>
    <!-- Phần footer -->
    <div class="footer">
        <p>&copy; Nhóm: <br>&emsp;&emsp;Đồng Văn Thịnh <br>&emsp;&emsp;Dương Văn Quý Vương</p>
    </div>
</div>