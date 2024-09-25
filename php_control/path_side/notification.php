<link rel="stylesheet" href="../assets/style/notification.css?v=<?php echo filemtime('../assets/style/notification.css')?>">
<?php include "../php_control/backend/notification_control.php"; ?>
<div>
    <div class="linediv notifi">
        <h1>Thông báo</h1>
        <!-- Nút cho danh sách tin nhắn -->
        <div class='group_button' id='list_group'>
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
        <div class='group_button' id='info_group'>
        <form method="post">
        <button type="submit" class="icon-button" name="undo">
            <img src="../assets/icon/undo.png?v=<?php echo filemtime("../assets/icon/undo.png"); ?>" 
            alt="Quay về" title="Quay về">            
        </button>
        <button type="submit" class="icon-button" name="delete">
            <img src="../assets/icon/delete.png?v=<?php echo filemtime("../assets/icon/delete.png"); ?>" 
            alt="Xóa tin nhắn" title="Xóa tin nhắn">            
        </button>
        </form>
        </div>  
    </div>
    <div class='notifi_content' id='list_noti'>
        <?php //include "list_noti.php";?>              
    </div>
    <div class='notifi_content' id='info_noti'>
        <?php include "info_noti.php";?>          
    </div>
</div>

<script src="../js_backend/notification.js?v=<?php echo filemtime('../js_backend/notification.js'); ?>"></script>