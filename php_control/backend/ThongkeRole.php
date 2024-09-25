<?php
session_start();
$Role = isset($_SESSION['Role']) ? $_SESSION['Role'] : '';

//var_dump($Role); 

switch ($Role) {
    case "admin":
     //   $_SESSION['message'] = "Welcom to controler, BIG COCK";
        header("location: ../admin_path/Thongke.php");
    
        break;

    case "Student":
        echo "U have no role";
        $_SESSION['message'] = "U are Student, u have no Role to access";
        header("location: ../../main/index.php");
        break;

    case "Teacher":
        echo "U have no role";
        $_SESSION['message'] = "U are Teacher, u have no Role to access";
        header("location: ../../main/index.php");

    default:
        echo "faile choice";
        $_SESSION['message'] = "U sus, u have no Role to access";
        header("location: ../../main/index.php");
        break;
}
?>
