<?php
if (!isset($pdo)) {
    $host = 'localhost'; // Host mặc định cho phpMyAdmin
    $username = 'root';  // Tên người dùng MySQL
    $password = '';      // Mật khẩu của MySQL (để trống nếu không có)
    $dbname = 'k71_715105225_dongvanthinh'; // Tên cơ sở dữ liệu

    // Tạo chuỗi kết nối DSN
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

    try {   
        // Kết nối đến MySQL bằng PDO
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Xử lý lỗi kết nối
        echo "Kết nối thất bại: " . $e->getMessage();
        return;
    }
}
?>
