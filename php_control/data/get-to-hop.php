<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db_connect.php';

function GetToHop(){
    global $pdo;

    $sql = "SELECT * FROM get_to_hop()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function GetListHinhThucXetTuyen(){
    global $pdo;

    $sql = "SELECT * FROM public.hinh_thuc_xet_tuyen";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
?>