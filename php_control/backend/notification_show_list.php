<?php
session_start();
if (!empty($_SESSION['notifications'])) {
    foreach ($_SESSION['notifications'] as $notification) {
        $form_id = 'notificationForm_' . $notification['id'];
        echo '<form method="post" id="' . $form_id . '" class="notificationForm">';
        echo '<input type="hidden" name="notification_id" value="' . $notification['id'] . '">';

        echo '<button type="button" name="openInfo" class="button-container" onclick="loadUIDetailNotification(' . $notification['id'] . ')">';
        echo '<div class="listview notification_info">';
        
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
} else {
    echo "<p style='text-align: center;'>Không có tin nhắn nào!</p>";
}
?>

