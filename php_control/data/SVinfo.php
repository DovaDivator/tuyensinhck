<?php
session_start();
include 'db_connect.php';

// Hàm lấy dữ liệu từ bảng nganh
function fetchNganhData($pdo) {
    $query = "SELECT *
              FROM sinh_vien";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$coursesSV = fetchNganhData($pdo);



header('Content-Type: application/json');

echo json_encode($coursesSV);
?>

