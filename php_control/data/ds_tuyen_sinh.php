<?php
session_start();
include 'db_connect.php';
include '../backend/convert.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['action'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Tham số không hợp lệ']);
    exit();
}

$action = $_POST['action'];
unset($_POST['action']);

switch($_SESSION['user']['role']){
    case 'Student':
        $courses = fetchNganhSV();
        break;
    case 'Teacher':
        $courses = fetchNganhGV();
        break;
    case 'Admin':
        $courses = fetchNganhAD();
        break;
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Tham số không hợp lệ']);
        exit();
}

foreach ($courses as &$course) {
    if (isset($course['date_end'])) {
        $course['date_end'] = convert_date($course['date_end']);
    }
}


function fetchNganhSV(){
    global $pdo;
    $query = "SELECT * FROM get_list_nganh_sv()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

// Hàm lấy dữ liệu từ bảng nganh
function fetchNganhGV(){
    global $pdo;
    $query = "SELECT * FROM get_list_nganh_gv()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

function fetchNganhAD(){
    global $pdo;
    $query = "SELECT * FROM get_list_nganh_ad()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

header('Content-Type: application/json');

echo json_encode($courses);
?>

