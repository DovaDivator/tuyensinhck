<?php
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "db_connect.php";
include "refresh_token.php";


header('Content-Type: application/json');

try {
    // Đọc dữ liệu JSON từ yêu cầu POST
    $input = file_get_contents("php://input");

// Bước 2: Giải mã dữ liệu JSON thành mảng PHP
$data = json_decode($input, true);

// Bước 3: Kiểm tra nếu dữ liệu là mảng hợp lệ
if (is_array($data)) {

    // Bước 4: Tạo mảng mới để lưu dữ liệu theo cấu trúc mới
    $newData = [];

    // Lọc các mục có key và value (từ chỉ mục 0 đến 6, 9 đến 14)
    foreach ($data as $key => $item) {
        // Kiểm tra nếu mảng có khóa 'key' và 'value'
        if (isset($item['key']) && isset($item['value'])) {
            // Thêm vào mảng mới theo tên trường
            $newData[$item['key']] = $item['value'];
        }
    }

    // Bước 5: Đảm bảo trường 'mon_diem' có cấu trúc đúng
    if (isset($data[8]) && is_array($data[8])) {
        $newData['mon_diem'] = $data[8];  // Gán trường 'mon_diem'
    }

    // Bước 6: Mã hóa lại thành JSON một bậc, giữ nguyên ký tự Unicode
    $json_output = json_encode($newData, JSON_UNESCAPED_UNICODE);

    // Đường dẫn file TXT để lưu dữ liệu
    $filePath = __DIR__ . "/data_output.txt";

    // Ghi dữ liệu vào tệp (append mode để không ghi đè)
    if (file_put_contents($filePath, $json_output . PHP_EOL, FILE_APPEND) === false) {
        echo json_encode(["success" => false, "message" => "Lỗi khi ghi vào tệp."]);
        exit();
    }

    // Trả về phản hồi thành công
    echo json_encode(["success" => true, "message" => "Dữ liệu đã được lưu thành công."]);

} else {
    // Trả về thông báo lỗi nếu dữ liệu không hợp lệ
    echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ"]);
    exit();
}
} catch (Exception $e) {
    // Trả về lỗi nếu xảy ra vấn đề
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
    exit();
}

    // Kiểm tra dữ liệu 'phuong_tien' và file tạm trong SESSION
if(isset($_GET['update'])){

}

function push_image_nganh($fileName)
{
    $supabase_url = 'https://iwelyvdecathaeppslzw.supabase.co';
    $bucket_name = 'nganh_image';

    // Lấy đường dẫn file tạm từ session
    $filePath = $fileName;

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
    file_put_contents("log.txt", "filename: $fileName\n access: ".$_SESSION['access_token']." \nResponse: $response\n", FILE_APPEND);
    return [
        'httpCode' => $httpCode,
        'response' => json_decode($response, true)
    ];
}
