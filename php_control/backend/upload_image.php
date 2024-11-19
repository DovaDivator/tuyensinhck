<?php
session_start();

// Kiểm tra sự tồn tại của tham số 'file_type' trong $_GET
if (isset($_GET['file_type'])) {
    $filetype = $_GET['file_type'];

    // Kiểm tra sự tồn tại của file trong $_FILES và không có lỗi
    if (isset($_FILES[$filetype]) && $_FILES[$filetype]['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../assets/temp_uploads/';

        // Đảm bảo thư mục tải lên tồn tại, nếu không thì tạo mới
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Tạo tên file duy nhất với phần mở rộng PNG
        $filename = uniqid() . "_" . time() . '.png';
        $uploadFile = $uploadDir . $filename;

        // Di chuyển file tải lên đến thư mục đích
        if (move_uploaded_file($_FILES[$filetype]['tmp_name'], $uploadFile)) {
            // Cập nhật đường dẫn ảnh vào session
            $_SESSION['file_path'][$filetype] = $uploadFile;

            // Phản hồi thành công với đường dẫn ảnh
            echo json_encode([
                'success' => true,
                'imagePath' => '../assets/temp_uploads/' . $filename
            ]);
        } else {
            // Thông báo lỗi khi tải lên không thành công
            echo json_encode(['success' => false, 'message' => 'Tải ảnh lên thất bại.']);
        }
    } else {
        // Kiểm tra có lỗi trong $_FILES và phản hồi thông điệp phù hợp
        if (isset($_FILES[$filetype])) {
            $errorMsg = 'Có lỗi xảy ra trong quá trình tải lên: ' . $_FILES[$filetype]['error'];
        } else {
            $errorMsg = 'Không có ảnh nào được tải lên.';
        }
        echo json_encode(['success' => false, 'message' => $errorMsg]);
    }
} else {
    // Thông báo nếu tham số file_type không được cung cấp
    echo json_encode(['success' => false, 'message' => 'Tham số file_type không được cung cấp.']);
}
?>
