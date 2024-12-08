<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include "db_connect.php";

    function GetHoSo($id){
        global $pdo;

        return [];
    }
?>