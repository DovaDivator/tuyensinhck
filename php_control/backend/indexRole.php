<?php
session_start();
$Role = isset($_SESSION['Role']) ? $_SESSION['Role'] : '';

//var_dump($Role); 

switch ($Role) {
    case "admin":
        header("location: ../admin_path/admin_index.php");
        break;

    case "Student":
        header("location: ../Student_path/Student_index.php");
        break;

    case "Teacher":
        header("location: ../teacher_path/Teacher_index.php");
        break;

    default:
        echo "Lựa chọn không hợp lệ!";
        break;
}
?>
