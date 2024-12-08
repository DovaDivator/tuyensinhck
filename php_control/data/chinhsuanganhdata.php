<?php
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    file_put_contents('log.txt', print_r($_POST, true));
    // Nhận dữ liệu từ form

    $id_nganh = $_POST['id_nganh'];
    $ten = $_POST['ten'] ?? null;
    $chi_tieu = $_POST['chi_tieu'] ?? null;
    $chuong_trinh = $_POST['chuong_trinh'] ?? null;
    $to_hop = $_POST['to_hop'] ?? null;

    $date_open_day = $_POST['date_open_day'] ?? null;
    $date_open_time = $_POST['date_open_time'] ?? null;

    if ($date_open_day && $date_open_time) {
        $datetime_str = $date_open_day . ' ' . $date_open_time;
        $date_open = DateTime::createFromFormat('d/m/Y H:i', $datetime_str);
        if (!$date_open) {
            $date_open = new DateTime();
        }
    } else {
        $date_open = new DateTime();
    }

    $date_end_day = $_POST['date_end_day'] ?? null;
    $date_end_time = $_POST['date_end_time'] ?? null;

    if ($date_end_day && $date_end_time) {
        $datetime_str = $date_end_day . ' ' . $date_end_time;
        $date_end = DateTime::createFromFormat('d/m/Y H:i', $datetime_str);
        if (!$date_end) {
            $date_end = null;
        }
    } elseif ($date_end_day || $date_end_time) {
        $date_end = null;
    } else {
        $date_end = null;
    }

    $diem_chuan = $_POST['diem_chuan'] ?? null;

    $diem_loc = $_POST['diem_loc'] ?? [];
    $diem = $_POST['diem'] ?? [];
    $ghi_chu = !empty($diem) && !empty($diem_loc) ? array_combine($diem, $diem_loc) : [];

    $gv_full = $_POST['gv_id'] ?? '';
    $parts = explode(' - ', $gv_full);
    $gv_id = $parts[0] ?? null;

    $mo_ta = $_POST['mo_ta']?? null;

    $img_link = null;
    $iframe = null;
    if(isset($_POST['phuong_tien'])){
        if($_POST['phuong_tien'] == 'media'){
            $iframe = $_POST['url']?? null;
            $chu_thich = $_POST['chu_thich'] ?? null;
        } elseif($_POST['phuong_tien'] == 'image'){
            $img_link = $_POST['file_temp']?? null;
            $chu_thich = $_POST['chu_thich'] ?? null;
        }
    }

    $enable = isset($_POST['enable']) && $_POST['enable'] === 'on' ? 1 : 0;

    unset($_POST);
    
    if(isset($_GET['update'])){
        $result = UpdateNganh($id_nganh, $ten, $chi_tieu, $to_hop, $chuong_trinh, $diem_chuan, $date_open, $date_end, $gv_id, $ghi_chu, $mo_ta, $iframe, $img_link, $chu_thich, $enable);
    }

    if(isset($result) && $result){
        echo json_encode([
            'status' => 'success',
            'message' => 'Dữ liệu đã được ghi vào file thành công!',
        ]);
    }else{
        echo json_encode([
            'status' => 'error',
            'message' => $result,
        ]);
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

function extractSrc($input) {
    // Kiểm tra xem đầu vào có phải là iframe hay không
    if (strpos($input, '<iframe') !== false) {
        // Tìm src trong thẻ iframe bằng regex
        preg_match('/src="([^"]+)"/', $input, $matches);
        return $matches[1] ?? ''; // Trả về src nếu tìm thấy
    }
    // Nếu không phải thẻ iframe, kiểm tra xem nó có phải URL
    elseif (filter_var($input, FILTER_VALIDATE_URL)) {
        return $input; // Trả về URL
    }
    return ''; 
}

function UpdateNganh($id_nganh, $ten, $chi_tieu, $to_hop, $chuong_trinh, $diem_chuan, $date_open, $date_end, $gv_id, $ghi_chu, $mo_ta, $iframe, $img_link, $chu_thich, $enable){
    global $pdo;

    $sql = "UPDATE nganh SET 
    ten_nganh = :ten, 
    chi_tieu = :chi_tieu, 
    id_tohop = :to_hop, 
    chuong_trinh = :chuong_trinh, 
    diem_chuan = :diem_chuan, 
    date_open = :date_open, 
    date_end = :date_end, 
    gv_id = :gv_id, 
    ghi_chu = :ghi_chu, 
    mo_ta = :mo_ta, 
    iframe = :iframe, 
    id_img = :id_img, 
    chu_thich = :chu_thich, 
    isenable = :isenable 
WHERE nganh_id = :id_nganh";

    // Sử dụng prepared statement để bảo vệ khỏi SQL injection
    $stmt = $pdo->prepare($sql);

    // Gán giá trị cho các tham số
    $stmt->bindParam(':ten', $ten);
    $stmt->bindParam(':chi_tieu', $chi_tieu);
    $stmt->bindParam(':to_hop', $to_hop);
    $stmt->bindParam(':chuong_trinh', $chuong_trinh);
    $stmt->bindParam(':diem_chuan', $diem_chuan);

    $date_open_formatted = $date_open ? $date_open->format('Y-m-d H:i:s') : null;
    $date_end_formatted = $date_end ? $date_end->format('Y-m-d H:i:s') : null;
    $stmt->bindParam(':date_open', $date_open_formatted);
    $stmt->bindParam(':date_end', $date_end_formatted);

    $stmt->bindParam(':gv_id', $gv_id);
    
    $ghi_chu_json = json_encode($ghi_chu);
    $stmt->bindParam(':ghi_chu', $ghi_chu_json);

    $stmt->bindParam(':mo_ta', $mo_ta);
    $stmt->bindParam(':iframe', $iframe);

    $id_img_value = $img_link ? file_get_contents($img_link) : null;
    $stmt->bindParam(':id_img', $id_img_value);

    $stmt->bindParam(':chu_thich', $chu_thich);
    $stmt->bindParam(':isenable', $enable, PDO::PARAM_INT); // Chuyển đổi giá trị thành kiểu int
    $stmt->bindParam(':id_nganh', $id_nganh);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        return true;
    } else {
        $errorInfo = $stmt->errorInfo();
        return $errorInfo[2];
    }
}
?>
