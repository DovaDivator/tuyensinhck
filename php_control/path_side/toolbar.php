<!-- Thanh bar trên cùng -->
<div class="navbar">
    <div class="navbar-content">
        <!-- thông tin người dùng -->
        <div class="user-info info" >
            <img class="avatar" src="../../assets/images/guest.png">
            <div class="user-details details">
                <p class="username"> <?php echo $_SESSION['user']['username']; ?>
                    <!-- TODO: (all) Truy vấn tìm tên người dùng -->
                </p>
                <p class="user-id">ID: <?php echo $_SESSION['user']['id']; ?>
                    <!-- TODO: (all) Truy vấn tìm ID-->
                </p>
                <p class="user-role">Vai trò: <?php echo $_SESSION['user']['role']; ?>
                    <!-- TODO: (all) Truy vấn hiện vai trò -->
                </p>
            </div>
        </div>
        <button type="submit" class="icon-button" id="notification">
            <img src="../assets/icon/noti_icon.png?v=<?php echo filemtime("../assets/icon/noti_icon.png"); ?>" 
            alt="Thông báo" title="Thông báo" onclick="showChartOption('notification layout', 'notification', 'show', event); loadUINotifications(null)">            
        </button>
        <form method="POST">
        <button type="submit" class="icon-button" name="logout">
            <img src="../assets/icon/logout_icon.png?v=<?php echo filemtime("../assets/icon/logout_icon.png"); ?>" alt="Đăng xuất" title="Đăng xuất">            
        </button>
        </form>
    </div>
</div>

<?php include "../php_control/backend/Logout.php";?>