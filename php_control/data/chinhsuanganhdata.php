<?php
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "db_connect.php";
include "refresh_token.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận dữ liệu từ form


    
    $id_nganh = $_POST['id_nganh'];
    $ten = $_POST['ten'] ?? '';
    $chi_tieu = $_POST['chi_tieu'] ?? '';
    $chuong_trinh = $_POST['chuong_trinh'] ?? '';
    $to_hop = $_POST['to_hop'] ?? '';
    $date_end_day = $_POST['date_end_day'] ?? '';
    $date_end_time = $_POST['date_end_time'] ?? '';
    $diem_chuan = $_POST['diem_chuan'] ?? '';

    // Ghi nội dung vào file getajax.txt

    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    // Kiểm tra xem dữ liệu có hợp lệ không
    if ($data) {
        $file = 'getajax.txt';
        if (file_put_contents($file, print_r($data, true)) !== false) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Dữ liệu đã được ghi vào file thành công!',
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Lỗi khi ghi dữ liệu vào file.',
            ]);
        }
    }
} else {
    // Nếu không phải POST, hiển thị form
    echo json_encode([
        'status' => 'error',
        'message' => 'Yêu cầu không hợp lệ.',
    ]);
}

function push_image_nganh($fileName){
    $supabase_url = 'https://iwelyvdecathaeppslzw.supabase.co';    
    $bucket_name = 'nganh_image';

    // Lấy đường dẫn file tạm từ session
    $filePath = '../../assets/temp_uploads/'.$fileName;

    // Tạo endpoint cho việc tải lên file
    $endpoint = $supabase_url . "/storage/v1/object/" . $bucket_name . "/" . $fileName;

    // Đọc nội dung của file
    $fileContent = file_get_contents($filePath);

    // Thiết lập headers cho cURL
    $headers = [
        "Authorization: Bearer " . $_SESSION['access_token'],
        "Content-Type: image/*"
    ];

    // Khởi tạo cURL và thiết lập các tùy chọn
    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  // POST request
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fileContent); // Đính kèm nội dung file
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Thêm headers vào yêu cầu

    // Gửi yêu cầu và nhận phản hồi
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Ghi log vào file log.txt
    // file_put_contents("log.txt", "filename: $fileName\n access: ".$_SESSION['access_token']." \nResponse: $response\n", FILE_APPEND);
    return [
        'httpCode' => $httpCode,
        'response' => json_decode($response, true)
    ];
}
?>
