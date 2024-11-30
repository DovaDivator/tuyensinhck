<?php


session_start();
if (isset($_SESSION['user'])) {
    //echo "<script>alert('welcom');</script>";
} else {
    //echo "<script>alert('pls login');</script>";
    header("Location: login.php");
    exit();
}

if (isset($_GET['rolecheck'])) {
    $role = $_GET['rolecheck'];
    if ($role === 'gv') {
        if (isset($_GET['ma_gv'])) {
            $ma_nganh = $_GET['ma_gv'];
            echo "<h2>Thông tin nhận được:</h2>";
            echo "<p>Mã giáo viên:". $_GET['ma_gv']."</p>";
            // unset($_GET['ma_gv']);
        } else {
            echo "Thiếu tham số!";
        }
    }

    if ($role === 'sv') {
        if (isset($_GET['masv'])) {
            $ma_sv = isset($_GET['masv']) ;
            echo "<h2>Thông tin nhận được:</h2>";
            echo "<p>Mã sinh viên:". $_GET['masv']."</p>";
        }else {
            echo "khong nhan duoc du lieu";
            
        }
    }
}
