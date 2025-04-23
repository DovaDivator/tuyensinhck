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

$data_arr = json_decode($json_output, true);

if($data_arr['phuong_tien'] == 'image'){
    $push_ava_http = push_image_nganh($data_arr['file_temp']);

        // Kiểm tra kết quả trả về từ cURL
        if($push_ava_http['httpCode'] == 400){
            if($push_ava_http['response']['statusCode'] == 403){
                get_token();
                if($_SESSION['access_token'] == ''){
                    echo json_encode([
                        "success" => false,
                        "message" => "errorAuth: Phiên hoạt động của bạn đã hết hạn, vui lòng đăng nhập lại để sử dụng các chức năng"
                    ]);
                    exit();
                }else{
                    $push_ava_http = push_image_nganh($json_output['file_temp']);
                    if ($push_ava_http['httpCode'] != 200) {
                        if($push_ava_http['response']['statusCode'] == 403){
                            if(strpos($push_ava_http['response']['message'] , 'row-level security policy')){
                                echo json_encode([
                                "success" => false,
                                "message" => "Lỗi liên quan đến RLS, hãy liên hệ với chúng tôi để xử lý"
                            ]);
                            exit();
                            }else{
                                echo json_encode([
                                    "success" => false,
                                    "message" => "errorAuth: Phiên hoạt động của bạn đã hết hạn, vui lòng đăng nhập lại để sử dụng các chức năng"
                                ]);
                                exit();
                            }
                        }else if($push_ava_http['response']['statusCode'] == 409){
                            $avatarTemp = '';
                        }else{
                            echo json_encode([
                                "success" => false,
                                "message" => "errorAuth: Phiên hoạt động của bạn đã hết hạn, vui lòng đăng nhập lại để sử dụng các chức năng"
                            ]);
                            exit();
                        }
                        exit();
                    }
                }
            }else{
                echo json_encode([
                    "success" => false,
                    "message" => "error: Lỗi tải tệp lên. HTTP Code: ".$push_ava_http['response']['statusCode']
                ]);
                exit();
            }
        } else if($push_ava_http['httpCode'] != 200){
            echo json_encode([
                "success" => false,
                "message" => "Lỗi kết nối HTTP Code: "
            ]);
            exit();
        }
}

    // Kiểm tra dữ liệu 'phuong_tien' và file tạm trong SESSION
    try {
        if(isset($_GET['update'])){
            $query = "
    SELECT update_nganh_info(
        :id,
        :ten,
        :chitieu,
        :chuongtrinh,
        :gvid,
        :mota,
        :ghichu::jsonb,
        :chuthich,
        :link,
        :ismedialink,
        :tohop,
        :diemchuan,
        :isenable,
        :dateopen,
        :dateend
    )
";
        }else{
            $query = "
        SELECT insert_nganh_info(
            :id, :ten, :chitieu, :tohop, :dateopen, :dateend, 
            :diemchuan, :chuongtrinh, :ghichu::jsonb, :gvid, :mota, 
            :ismedialink, :link, :chuthich, :isenable
        );
    ";
        }

        $stmt = $pdo->prepare($query);

        // Gán giá trị vào biến trước khi bindParam
        $day_open = $data_arr['day_open'];
        $day_close = $data_arr['day_close'];
        
        try {
            // Chuyển đổi day_open
            $dateopen = DateTime::createFromFormat('d/m/Y H:i', $day_open);
            if ($dateopen) {
                $dateopen = $dateopen->format('Y-m-d H:i:s');
            } else {
                throw new Exception("Định dạng day_open không hợp lệ: $day_open");
            }
        
            // Chuyển đổi day_close
            $dateend = DateTime::createFromFormat('d/m/Y H:i', $day_close);
            if ($dateend) {
                $dateend = $dateend->format('Y-m-d H:i:s');
            } else {
                throw new Exception("Định dạng day_close không hợp lệ: $day_close");
            }
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            $dateopen = null;
            $dateend = null;
        }


$diemchuan = (float)$data_arr['diem_chuan'];
$chuongtrinh = (int)$data_arr['chuong_trinh'];
$mon_diem = array_reduce($data_arr['mon_diem'], function ($result, $item) {
    $result[$item['mon']] = (float)$item['diem']; // Chuyển điểm thành số thực
    return $result;
}, []);

$ghichu = json_encode($mon_diem, JSON_UNESCAPED_UNICODE);
$gvid = explode(' - ', $data_arr['gv_id'])[0];
if(isset($_GET['update'])){
    if($data_arr['phuong_tien'] === 'media'){
        $ismedialink = 1;
        $link = $data_arr['url'];
    }else if($data_arr['phuong_tien'] === 'image'){
        $ismedialink = 2;
        $link = basename($data_arr['file_temp']);
    }else{
        $ismedialink = 0;
    }
}else{
    $ismedialink = ($data_arr['phuong_tien'] === 'media');
    if($ismedialink){
        $link = $data_arr['url'];
    }else{
        $link = isset($data_arr['file_temp']) ? basename($data_arr['file_temp']) : null;

    }
}
$isenable = $data_arr['isenable']; // Cờ kích hoạt

// Sau khi gán giá trị vào các biến, bindParam lại
$stmt->bindParam(':id', $data_arr['id_nganh'], PDO::PARAM_STR);
$stmt->bindParam(':ten', $data_arr['ten']);
$stmt->bindParam(':chitieu', $data_arr['chi_tieu'], PDO::PARAM_INT);
$stmt->bindParam(':tohop', $data_arr['to_hop']);
$stmt->bindParam(':dateopen', $dateopen);
$stmt->bindParam(':dateend', $dateend);
$stmt->bindParam(':diemchuan', $diemchuan);
$stmt->bindParam(':chuongtrinh', $chuongtrinh, PDO::PARAM_INT);
$stmt->bindParam(':ghichu', $ghichu);
$stmt->bindParam(':gvid', $gvid);
$stmt->bindParam(':mota', $data_arr['mo_ta']);
if(isset($_GET['update'])){
    $stmt->bindParam(':ismedialink', $ismedialink, PDO::PARAM_INT);
}else{
    $stmt->bindParam(':ismedialink', $ismedialink, PDO::PARAM_BOOL);
}
$stmt->bindParam(':link', $link);
$stmt->bindParam(':chuthich', $data_arr['chu_thich']);
$stmt->bindParam(':isenable', $isenable, PDO::PARAM_BOOL);


        // Thực hiện câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "redirect_url" => "chi-tiet-tuyen-sinh.php?ma_nganh=".$data_arr['id_nganh']
            ]);
            exit();
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Cập nhật thất bại"
            ]);
            exit();
        }
    } catch (PDOException $e) {
        echo json_encode([
            "success" => false,
            "message" =>"error: có sự cố khi cập nhật $e"
        ]);
        exit();
    }

function push_image_nganh($fileName)
{
    $supabase_url = 'https://iwelyvdecathaeppslzw.supabase.co';
    $bucket_name = 'nganh_image';

    // Lấy đường dẫn file tạm từ session
    $filePath = '../' . $fileName;



    // Tạo endpoint cho việc tải lên file
    $endpoint = $supabase_url . "/storage/v1/object/" . $bucket_name . "/" . basename($fileName);

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
    file_put_contents("log.txt", "filename: $fileName\nResponse: $response\n", FILE_APPEND);
    return [
        'httpCode' => $httpCode,
        'response' => json_decode($response, true)
    ];
}
