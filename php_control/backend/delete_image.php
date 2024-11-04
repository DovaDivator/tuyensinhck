<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Kiểm tra xem file_type có được gửi đến hay không
if (isset($_GET['file_type'])) {
    $filetype = $_GET['file_type']; // Sửa từ $POST thành $_POST

    // Kiểm tra xem đường dẫn của file có tồn tại trong session
    if (isset($_SESSION['file_path'][$filetype]) && $_SESSION['file_path'][$filetype] !== '') {
        $filePath = $_SESSION['file_path'][$filetype];

        // Kiểm tra xem file có tồn tại không
        if (file_exists($filePath)) {
            // Xóa file
            if (unlink($filePath)) {
                // Xóa đường dẫn file khỏi session sau khi xóa thành công
                $_SESSION['file_path'][$filetype] = '';
                echo json_encode(['success' => true, 'message' => 'Ảnh đã được xóa thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể xóa ảnh']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Ảnh không tồn tại: ' . $filePath]);
        }
    } else {
        echo json_encode(['success' => true, 'message' => 'Không có ảnh nào để xóa']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Không nhận được file_type']);
}
?>
