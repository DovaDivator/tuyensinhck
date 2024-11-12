<?php
include '../php_control/data/db_connect.php';

if(isset($_GET['email'])){
    $email = $_GET['email'];
}else{
    include "../php_control/path_side/fatal.php";
    exit();
}

// Thực thi truy vấn gọi hàm check_recovery_time
$sql = "SELECT check_recovery_time(:email) AS is_valid"; // Truy vấn SQL gọi hàm check_recovery_time
$stmt = $pdo->prepare($sql);

// Liên kết tham số với giá trị email
$stmt->bindParam(':email', $email, PDO::PARAM_STR);

// Thực thi câu lệnh
$stmt->execute();

// Lấy kết quả trả về
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra kết quả và quyết định hiển thị
if ($result['is_valid']) {
    include "../php_control/path_side/confirm.php";
} else {
    include "../php_control/path_side/fatal.php";
}
?>