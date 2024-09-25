<?php
session_start();
$Role = isset($_SESSION['Role']) ? $_SESSION['Role'] : '';

//var_dump($Role); 

switch ($Role) {
    case "admin":
        header("location: ../admin_path/admin_QLHS.php");
        break;

    case "Student":
        header("location: ../Student_path/Student_NHS.php");
        break;

    case "Teacher":
        header("location: ../teacher_path/Teacher_NHS.php");
        break;

    default:
        echo "Lựa chọn không hợp lệ!";
        break;
}
?>
