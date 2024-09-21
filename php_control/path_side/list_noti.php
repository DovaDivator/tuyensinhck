<?php
// Mảng tạm thời
$notifications = [
    ['id' => 1, 'title' => 'Thắng duut deet vit ban tum lum ứ ứ ứ', 'type' => 'Lee Ngọc Thén', 'date' => '12/10/2024'],
    ['id' => 2, 'title' => 'Thắng ligmaball', 'type' => 'Lee Ngọc Thén', 'date' => '12/10/2024'],
    ['id' => 3, 'title' => 'Thắng ligmaball', 'type' => 'Lee Ngọc Thén', 'date' => '12/10/2024'],
    ['id' => 4, 'title' => 'Thắng ligmaball', 'type' => 'Lee Ngọc Thén', 'date' => '12/10/2024'],
    ['id' => 5, 'title' => 'Thắng ligmaball', 'type' => 'Lee Ngọc Thén', 'date' => '12/10/2024'],
    ['id' => 6, 'title' => 'Thắng ligmaball', 'type' => 'Lee Ngọc Thén', 'date' => '12/10/2024']
];

// Thực hiện xóa thông báo dựa trên POST
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];   
    deleteNotification($notifications, $delete_id);
}


// Hiển thị danh sách thông báo
    foreach ($notifications as $notification) {
        echo '<form method="post">';
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
?>


    <p class="note">Lưu ý: tin nhắn sẽ tự động xóa sau 6 tháng tính từ ngày gửi đi</p>

<!-- hàm xóa thông báo -->  
<?php
function deleteNotification($notifications, $delete_id) {
    return array_filter($notifications, function($notification) use ($delete_id) {
        return $notification['id'] != $delete_id;
    });
}
?>