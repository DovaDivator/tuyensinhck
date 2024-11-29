<?php
include 'db_connect.php';

function GetToHop(){
    global $pdo;

    $sql = "SELECT * FROM get_to_hop()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}?>