<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include "db_connect.php";

    function GetHoSo($id){
        global $pdo;

        $sql = "SELECT cccd, address, date_of_birth, ma_htts, diem, ma_tuyen_sinh, ten, gender 
        FROM sinh_vien 
        WHERE stu_id = :stu_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':stu_id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>