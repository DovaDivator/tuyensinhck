<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Thiết lập Content-Type để phản hồi dưới dạng JSON
header('Content-Type: application/json');

// Kiểm tra nếu người dùng yêu cầu xóa tất cả file
if (isset($_GET['action']) && $_GET['action'] === 'delete_all') {
    if (isset($_SESSION['file_path']) && is_array($_SESSION['file_path'])) {
        $errors = [];

        foreach ($_SESSION['file_path'] as $fileType => $filePaths) {
            // Kiểm tra xem $filePaths có phải là mảng hay không
            if (is_array($filePaths)) {
                foreach ($filePaths as $filePath) {
                    // Kiểm tra xem file có tồn tại không
                    if (!empty($filePath) && file_exists($filePath)) {
                        if (!unlink($filePath)) {
                            $errors[] = "Không thể xóa file: $filePath";
                        }
                    }
                }
            } else {
                // Trường hợp $filePaths là một chuỗi thay vì mảng
                if (!empty($filePaths) && file_exists($filePaths)) {
                    if (!unlink($filePaths)) {
                        $errors[] = "Không thể xóa file: $filePaths";
                    }
                }
            }
        }

        // Xóa tất cả các file_path trong session sau khi xóa file
        $_SESSION['file_path'] = [];

        // Kiểm tra nếu có lỗi khi xóa file
        if (empty($errors)) {
            echo json_encode(['success' => true, 'message' => 'Tất cả file đã được xóa thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Một số file không thể xóa', 'errors' => $errors]);
        }
    } else {
        echo json_encode(['success' => true, 'message' => 'Không có file nào để xóa']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ']);
}
?>
