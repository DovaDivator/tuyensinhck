<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include "db_connect.php";

    function blobToDataUrl($blobData, $mimeType = 'image/png') {
        $base64 = base64_encode($blobData);
        return 'data:' . $mimeType . ';base64,' . $base64;
    }
?>