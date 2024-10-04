<link rel="stylesheet" href="../assets/style/notification.css?v=<?php echo filemtime('../assets/style/notification.css')?>">
<div>
    <div class="linediv notifi">
        <h1>Thông báo</h1>
        <!-- Nút cho danh sách tin nhắn -->
        <div class='group_button list_group'>
        <button type="submit" class="icon-button" name="markAsRead">
            <img src="../assets/icon/mark_as_read.png?v=<?php echo filemtime("../assets/icon/mark_as_read.png"); ?>" 
            alt="Đánh dấu đã đọc" title="Đánh dấu đã đọc">            
        </button>
        <button type="submit" class="icon-button" name="cleanNotification">
            <img src="../assets/icon/clean.png?v=<?php echo filemtime("../assets/icon/clean.png"); ?>" 
            alt="Dọn dẹp" title="Dọn dẹp">            
        </button>
        </div>
        <!-- Nút cho chi tiết tin nhắn -->
        <div class='group_button info_group'>
        <button type="submit" class="icon-button" name="undo">
            <img src="../assets/icon/undo.png?v=<?php echo filemtime("../assets/icon/undo.png"); ?>" 
            alt="Quay về" title="Quay về">            
        </button>
        <button type="submit" class="icon-button" name="delete">
            <img src="../assets/icon/delete.png?v=<?php echo filemtime("../assets/icon/delete.png"); ?>" 
            alt="Xóa tin nhắn" title="Xóa tin nhắn">            
        </button>
        </div>  
    </div>
    <?php include "../php_control/backend/get_notificatoin.php"; ?>
    <div class='notifi_content' id='notifi_content'>
        <?php include "list_noti.php"; ?>
    </div>
</div>
