<?php
if (!isset($pdo)) {
    $host = 'localhost'; 
    $username = 'root';  
    $password = '';      
    $dbname = 'nhom_24'; 


    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

    try {   
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Xử lý lỗi kết nối
        echo "Kết nối thất bại: " . $e->getMessage();
        return;
    }
}
?>
