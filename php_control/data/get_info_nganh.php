<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db_connect.php';

function getInfoNganh($id){
    global $pdo;
    switch($_SESSION['user']['role']){
        case 'Student':
            $query = "SELECT * FROM get_nganh_info_sv(:id)";
            break;
        case 'Teacher':
            $query = "SELECT * FROM get_nganh_info_gv(:id)";
            break;
        case 'Admin':
            $query = "SELECT * FROM get_nganh_info_ad(:id)";
            break;
        default:
            return [];
    }

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}
?>