<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db_connect.php';

function GetToHop(){
    global $pdo;

    $sql = "SELECT 
    toh.id_tohop AS id
FROM 
    to_hop AS toh
JOIN 
    hinh_thuc_xet_tuyen AS htt
ON 
    toh.ma_htts = htt.ma_htts;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function GetListHinhThucXetTuyen(){
    global $pdo;

    $sql = "SELECT * FROM hinh_thuc_xet_tuyen";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
?>