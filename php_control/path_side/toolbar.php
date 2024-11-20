<!-- Thanh bar trên cùng -->
<div class="navbar">
    <div class="navbar-content">
        <!-- thông tin người dùng -->
        <div class="user-info info">

            <?php
            $tempFilePath = '../assets/images/temp_downloads/'. $_SESSION['temp_avatar'];
            $defaultFilePath = '../assets/images/Guest_user.png';
            $imagePath = file_exists($tempFilePath) ? $tempFilePath : $defaultFilePath;
            $imageWithTimestamp = $imagePath . '?v=' . filemtime($imagePath);
            ?>

            <img class="avatar" src="<?php echo $imageWithTimestamp; ?>">
            <!-- <img class="avatar" src="../assets/images/Guest_user.png?v=<?php echo filemtime('../assets/images/Guest_user.png'); ?>"> -->
            <div class="user-details details">
                <p class="username"> <?php echo $_SESSION['user']['username']; ?>
                    <!-- TODO: (all) Truy vấn tìm tên người dùng -->
                </p>
                <p class="user-id">ID: <?php echo $_SESSION['user']['id']; ?>
                    <!-- TODO: (all) Truy vấn tìm ID-->
                </p>
                <p class="user-role">Vai trò:
                    <?php
                    if ($_SESSION['user']['role'] == 'Admin') {
                        echo "Quản trị viên";
                    } else if ($_SESSION['user']['role'] == 'Teacher') {
                        echo "Giáo viên";
                    } else if ($_SESSION['user']['role'] == 'Student') {
                        echo "Sinh viên";
                    } else {
                        echo "Không xác định";
                    }
                    ?>
                </p>
            </div>
        </div>
        <button type="submit" class="icon-button" id="notification">
            <img src="../assets/icon/noti_icon.png?v=<?php echo filemtime("../assets/icon/noti_icon.png"); ?>"
                alt="Thông báo" title="Thông báo" onclick="showChartOption('notification layout', 'notification', 'show', event); loadUINotifications(null)">
        </button>
        <form method="POST" style="margin: 0">
            <button type="submit" class="icon-button" name="logout">
                <img src="../assets/icon/logout_icon.png?v=<?php echo filemtime("../assets/icon/logout_icon.png"); ?>" alt="Đăng xuất" title="Đăng xuất">
            </button>
        </form>
    </div>
</div>

<?php include "../php_control/backend/Logout.php"; ?>