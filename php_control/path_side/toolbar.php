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
                <img src="../assets/icon/noti_icon.png?v=<?php echo filemtime("../assets/icon/noti_icon.png"); ?>" alt="Thông báo" title="Thông báo">
            </button>
            <button type="submit" class="icon-button" name="changeinfo">
                <img src="../assets/icon/info_icon.png?v=<?php echo filemtime("../assets/icon/info_icon.png"); ?>" alt="Chỉnh sửa thông tin" title="Chỉnh sửa thông tin">
            </button>
            <button type="submit" class="icon-button" name="logout">
                <img src="../assets/icon/logout_icon.png?v=<?php echo filemtime("../assets/icon/logout_icon.png"); ?>" alt="Đăng xuất" title="Đăng xuất">
            </button>
        </form>
    </div>
</div>