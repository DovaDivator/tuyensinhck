<?php
    session_start(); 

    if(isset($_POST['request'])){
        switch($_POST['request']){
            case 'markAllAsRead':
                break;
            case 'cleanNotification':
                break;
            case 'delete':
                break;
            default:
                break;
        }
        unset($_POST['request']);
    }

    // Dữ liệu tạm thời
    $notifications = [
        [
            'id' => 1,
            'title' => 'Thắng duut deet vit ban tum lum ứ ứ ứ',
            'type' => 'Không xác định',
            'date' => '12/10/2024',
            'isRead' => false
        ],
    ];

$_SESSION['notifications'] = $notifications;
?>
