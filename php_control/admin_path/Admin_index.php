<?php
session_start();
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    //echo "<script>alert('welcom');</script>";
} else {
    echo "<script>alert('pls login');</script>";
    header("Location: ../../main/login.php");
    exit();
}
?>