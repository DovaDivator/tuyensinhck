<?php
include 'db_connect.php';
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    $querySelect = "SELECT isenable FROM nganh WHERE nganh_id = :id";
    $stmtSelect = $pdo->prepare($querySelect);
    $stmtSelect->bindParam(':id', $id);
    $stmtSelect->execute();

    $currentValue = $stmtSelect->fetchColumn();

    $newValue = $currentValue == 1 ? 0 : 1;

    $query = "UPDATE nganh SET isenable = :isenable WHERE nganh_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':isenable', $newValue);
    $stmt->execute();
?>