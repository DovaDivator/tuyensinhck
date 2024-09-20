<?php

// đăng  xuất 
session_start();


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['logout'])) {
    
    session_unset();  
    session_destroy();  
    header("Location: login.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
