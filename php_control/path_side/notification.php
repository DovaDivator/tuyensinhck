<link rel="stylesheet" href="../assets/style/notification.css?v=<?php echo filemtime('../assets/style/notification.css')?>">
<div>
    <div class="linediv notifi">
        <h1>Thông báo</h1>
        <div class='group_button'>
        <button type="submit" class="icon-button" name="markAsRead">
            <img src="../assets/icon/mark_as_read.png?v=<?php echo filemtime("../assets/icon/mark_as_read.png"); ?>" 
            alt="Đánh dấu đã đọc" title="Đánh dấu đã đọc">            
        </button>
        <button type="submit" class="icon-button" name="cleanNotification">
            <img src="../assets/icon/clean.png?v=<?php echo filemtime("../assets/icon/clean.png"); ?>" 
            alt="Dọn dẹp" title="Dọn dẹp">            
        </button>
        </div>
    </div>
    <div class='notifi_content'>
        <?php include "info_noti.php"; ?>
    </div>
</div>