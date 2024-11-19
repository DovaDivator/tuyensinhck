<?php
session_start();

include "db_connect.php";
include "refresh_token.php";

// Xử lý yêu cầu đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra xem các khóa có tồn tại không
    $name = $_POST["name"]; 
    $email = $_POST["email"]; 
    $phone = $_POST["phone"];
    unset($_POST);
    $_POST = array();

    // Thực hiện truy vấn SQL
    $query = "SELECT * FROM get_user_info(:info)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':info', $email);
    $stmt->execute();
    $responseData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($responseData) {
        $id_query = $responseData['id'];
        if($id_query !== $_SESSION['user']['id'] ){
            echo "warming: Email này đã được sử dụng, vui lòng thay bằng email khác.";
            exit();
        }
    }

    $query = "SELECT * FROM get_email_user(:id_or_phone)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_or_phone', $phone);
    $stmt->execute();
    $responseData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($responseData) {
        $id_query = $responseData['id'];
        if($id_query !== $_SESSION['user']['id'] ){
            echo "warming: Số điện thoại này đã được sử dụng, vui lòng thay bằng số khác.";
            exit();
        }
    }

    if (isset($_SESSION['file_path']['avatar_temp']) && $_SESSION['file_path']['avatar_temp'] !== '') {  
        $push_ava_http = push_avatar();

        // Kiểm tra kết quả trả về từ cURL
        if($push_ava_http['httpCode'] == 400){
            if($push_ava_http['response']['statusCode'] == 403){
                get_token();
                if($_SESSION['access_token'] == ''){
                    echo "errorAuth: Phiên hoạt động của bạn đã hết hạn, vui lòng đăng nhập lại để sử dụng các chức năng";
                    exit();
                }else{
                    $push_ava_http = push_avatar();
                    if ($push_ava_http['httpCode'] != 200) {
                        if($push_ava_http['response']['statusCode'] == 403){
                            echo "errorAuth: Phiên hoạt động của bạn đã hết hạn, vui lòng đăng nhập lại để sử dụng các chức năng";
                        }else{
                            echo "error: Lỗi tải tệp lên. HTTP Code: ".$push_ava_http['response']['statusCode'];
                        }
                        exit();
                    }
                }
            }else{
                echo "error: Lỗi tải tệp lên. HTTP Code: ".$push_ava_http['response']['statusCode'];
                exit();
            }
        } else if($push_ava_http['httpCode'] != 200){
            echo "error: Lỗi kết nối HTTP Code: ".$push_ava_http['response']['statusCode'];
            exit();
        }
    }

    $_SESSION['user']['avatar_name'] = $_SESSION['file_path']['avatar_temp'];
    $_SESSION['file_path']['avatar_temp'] = '';
    
//     $push_ava_http = push_avatar();

//     // Kiểm tra kết quả trả về từ cURL
//     if($push_ava_http['statusCode'] === 403){
//         refresh_token();
//         if($push_ava_http['statusCode'] === ''){
//             echo "errorAuth: Phiên hoạt động của bạn đã hết hạn, vui lòng đăng nhập lại để sử dụng các chức năng";
//             exit();
//         }else{
//             $push_ava_http = push_avatar();
//             if ($push_ava_http['statusCode'] !== 200 && $push_ava_http['statusCode'] !== 201) {
//                 echo "error: Lỗi tải tệp lên. HTTP Code: ".$push_ava_http['statusCode'];
//                 exit();
//             }
//         }
//     } else if($push_ava_http['statusCode'] !== 200 && $push_ava_http['statusCode'] !== 201){
//         echo "error: Lỗi tải tệp lên. HTTP Code: ".$push_ava_http['statusCode'];
//         exit();
//     }
    echo 'success: Cập nhật thành công!';
} else {
    echo "error: Lỗi PHP request";
}
exit();

function push_avatar(){
    $supabase_url = 'https://iwelyvdecathaeppslzw.supabase.co';    
    $bucket_name = 'avatar';

    // Lấy đường dẫn file tạm từ session
    $filePath = $_SESSION['file_path']['avatar_temp'];
    $fileName = str_replace('../../assets/temp_uploads/', '', $filePath);

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
    file_put_contents("log.txt", "filename: $fileName\nResponse: $response\n", FILE_APPEND);
    return [
        'httpCode' => $httpCode,
        'response' => json_decode($response, true)
    ];
}

function updateEmail($newEmail) {
    // URL của Supabase Auth API để cập nhật thông tin người dùng
    $apiUrl = "https://iwelyvdecathaeppslzw.supabase.co/auth/v1/user";  // Endpoint để cập nhật thông tin người dùng

    // Dữ liệu gửi đi bao gồm email mới
    $data = [
        "email" => $newEmail
    ];

    // Khởi tạo cURL
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Đặt header yêu cầu, bao gồm Authorization header với Access Token
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $_SESSION['access_token'],
        'Content-Type: application/json',
    ]);

    // Đặt phương thức PUT và dữ liệu gửi đi
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Gửi yêu cầu và nhận phản hồi
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Ghi log vào file log.txt
    file_put_contents("log.txt", "filename: Response: $response\n", FILE_APPEND);

    return [
        'httpCode' => $httpCode,
        'response' => json_decode($response, true)
    ];
}
?>


