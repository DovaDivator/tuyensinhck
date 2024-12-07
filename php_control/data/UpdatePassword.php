<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "db_connect.php";

// Kiểm tra nếu form gửi mật khẩu hiện tại, mật khẩu mới và email
if (isset($_POST['current_password'], $_POST['new_password'])) {
    $email = $_SESSION['user']['email'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    unset($_POST);
    $_POST = array();

    try {
        global $pdo; // Biến PDO đã kết nối

        // Lấy hash mật khẩu hiện tại từ cơ sở dữ liệu
        $stmt = $pdo->prepare("SELECT password FROM user WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $hashedPassword = $stmt->fetchColumn();

        if (!$hashedPassword) {
            echo "Không tìm thấy người dùng với email này.";
            exit;
        }

        // Kiểm tra mật khẩu hiện tại
        if (!password_verify($currentPassword, $hashedPassword)) {
            echo "Mật khẩu hiện tại không đúng.";
            exit;
        }

        // Hash mật khẩu mới
        $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Cập nhật mật khẩu mới vào cơ sở dữ liệu
        $updateStmt = $pdo->prepare("UPDATE user SET password = :newPassword WHERE email = :email");
        $updateStmt->execute([
            ':newPassword' => $newHashedPassword,
            ':email' => $email
        ]);

        echo "suceess";
    } catch (PDOException $e) {
        error_log("Lỗi khi thay đổi mật khẩu: " . $e->getMessage());
        echo "Có lỗi xảy ra. Vui lòng thử lại.";
    }
} else {
    echo "error: Dữ liệu không hợp lệ.";
}
exit();
