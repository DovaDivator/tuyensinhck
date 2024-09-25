<?php
    // Dữ liệu tạm thời
    $notifications = [
        [
            'id' => 1,
            'title' => 'Thắng duut deet vit ban tum lum ứ ứ ứ',
            'type' => 'Không xác định',
            'date' => '12/10/2024',
            'content' => 'Đây là một đoạn văn mẫu để kiểm tra việc xuống dòng. Nếu có từ dài, nó sẽ tự động xuống dòng. Còn nếu nó không xuống được thì <font color="red">TẤT CẢ TẠI THẮNG</font>',
            'credit' => 'Lê Ngọt Thén',
            'isRead' => false
        ],
    ];

$_SESSION['notifications'] = $notifications;

if (isset($_SESSION['notifications']) && !empty($_SESSION['notifications'])) {
    foreach ($_SESSION['notifications'] as $notification) {
        // Tạo id duy nhất cho mỗi form
        $form_id = 'notificationForm_' . $notification['id'];
        echo '<form method="post" id="' . $form_id . '" class="notificationForm">';
        echo '<input type="hidden" name="notification_id" value="' . $notification['id'] . '">';
        echo '<button type="submit" name="openInfo" class="button-container">';
        echo '<div class="listview notification_info">';
        // Nếu cần đánh dấu thông báo chưa đọc
        if ($notification['id'] == 1) {
            echo '<div class="red_dots mark_notification"></div>';
        }
        echo '<div class="notification_details details">';
        echo '<p class="title">' . $notification['title'] . '</p>';
        echo '<p class="type">' . $notification['type'] . '</p>';
        echo '<p class="date">' . $notification['date'] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</button>';
        echo '</form>';
    }
}
?>
