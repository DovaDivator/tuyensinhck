<?php
session_start();

if (isset($_POST['notification_id'])) {
    $notification_id = $_POST['notification_id'];

    //Sau này sẽ thực hiện truy vấn sql lấy tin nhắn chi tiết

    // Hiển thị tạm thời
    echo '<div class="info_notifi_container text-content">';
    echo '<h2>Thắng duut deet vit ban tum lum ứ ứ ứ</h2>';
    echo '<p class="type">Không xác định</p>';
    echo '<p class="date">Ngày: 12/10/2024</p>';
    echo '<p>Đây là một đoạn văn mẫu để kiểm tra việc xuống dòng. Nếu có từ dài, nó sẽ tự động xuống dòng.';
    echo 'Còn nếu nó không xuống được thì <font color="red">TẤT CẢ TẠI THẮNG</font>';
    echo '</p>';
    echo '<h4 class="credit">Từ: Lê Ngọt Thén</h4>';
    echo '</div>';   
} 
?>
