<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include "db_connect.php";
    include "refresh_token.php";

    function GetPublicLink($bucket, $name){
        return "https://iwelyvdecathaeppslzw.supabase.co/storage/v1/object/".$bucket."/".$name;
    }
?>