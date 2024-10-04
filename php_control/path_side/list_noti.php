<?php

// Thực hiện xóa thông báo dựa trên POST
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];   
    deleteNotification($notifications, $delete_id);
}


// Hiển thị danh sách thông báo
// if (isset($_SESSION['notifications']) && !empty($_SESSION['notifications'])) {
//     foreach ($_SESSION['notifications'] as $notification) {
//         // Tạo id duy nhất cho mỗi form
//         $form_id = 'notificationForm_' . $notification['id'];
//         echo '<form method="post" id="' . $form_id . '" class="notificationForm">';
//         echo '<input type="hidden" name="notification_id" value="' . $notification['id'] . '">';
//         echo '<button type="submit" name="openInfo" class="button-container">';
//         echo '<div class="listview notification_info">';
//         // Nếu cần đánh dấu thông báo chưa đọc
//         if ($notification['id'] == 1) {
//             echo '<div class="red_dots mark_notification"></div>';
//         }
//         echo '<div class="notification_details details">';
//         echo '<p class="title">' . $notification['title'] . '</p>';
//         echo '<p class="type">' . $notification['type'] . '</p>';
//         echo '<p class="date">' . $notification['date'] . '</p>';
//         echo '</div>';
//         echo '</div>';
//         echo '</button>';
//         echo '</form>';
//     }
// }
?>


    <p class="note">Lưu ý: tin nhắn sẽ tự động xóa sau 6 tháng tính từ ngày gửi đi</p>

    <?php
    if (isset($_POST['openInfo'])) {
        $notificationId = $_POST['notification_id'];
        error_log('Notification ID: ' . $notificationId);
        $_SESSION['NotifiInfo'] = $notificationId;
}
?>

<!-- hàm xóa thông báo -->  
<?php
function deleteNotification($notifications, $delete_id) {
    return array_filter($notifications, function($notification) use ($delete_id) {
        return $notification['id'] != $delete_id;
    });
}
?>