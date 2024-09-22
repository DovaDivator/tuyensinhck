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
?>