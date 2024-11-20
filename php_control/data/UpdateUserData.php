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
    $avatarTemp = isset($_SESSION['file_path']['avatar_temp']) ? $_SESSION['file_path']['avatar_temp'] : '';
    $avatarTemp = str_replace('../../assets/temp_uploads/', '', $avatarTemp);
    file_put_contents("log.txt", "phone: $phone\n", FILE_APPEND);
    // unset($_POST);
    // $_POST = array();

    // Thực hiện truy vấn SQL
    if($email !== ''){
        $query = "SELECT * FROM get_id_user(:id_or_phone)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_or_phone', $email);
        $stmt->execute();
        $responseData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($responseData) {
            $id_query = $responseData['id'];
            if($id_query !== $_SESSION['user']['id'] ){
                echo "warming: Email này đã được sử dụng, vui lòng thay bằng email khác.";
                exit();
            }
        }
    }

    if($phone !== ''){
        $query = "SELECT * FROM get_id_user(:id_or_phone)";
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
    }

    if ($avatarTemp !== '') {  
        $push_ava_http = push_avatar($avatarTemp);

        // Kiểm tra kết quả trả về từ cURL
        if($push_ava_http['httpCode'] == 400){
            if($push_ava_http['response']['statusCode'] == 403){
                get_token();
                if($_SESSION['access_token'] == ''){
                    echo "errorAuth: Phiên hoạt động của bạn đã hết hạn, vui lòng đăng nhập lại để sử dụng các chức năng";
                    exit();
                }else{
                    $push_ava_http = push_avatar($avatarTemp);
                    if ($push_ava_http['httpCode'] != 200) {
                        if($push_ava_http['response']['statusCode'] == 403){
                            if(strpos($push_ava_http['response']['message'] , 'row-level security policy')){
                                echo "error: Lỗi liên quan đến RLS, hãy liên hệ với chúng tôi để xử lý";
                            }else{
                                echo "errorAuth: Phiên hoạt động của bạn đã hết hạn, vui lòng đăng nhập lại để sử dụng các chức năng";
                            }
                        }else if($push_ava_http['response']['statusCode'] == 409){
                            $avatarTemp = '';
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

    try {
        $query = "SELECT update_user_info(:filename, :id, :role, :name, :email, :phone)";
        $stmt = $pdo->prepare($query);

        // Ràng buộc các tham số
        $stmt->bindParam(':filename', $avatarTemp);
        $stmt->bindParam(':id', $_SESSION['user']['id']);
        $stmt->bindParam(':role', $_SESSION['user']['role']);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);

        // Thực hiện câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error: Cập nhật thông tin thất bại";
        }
    } catch (PDOException $e) {
        // Xử lý lỗi
        echo "error: có sự cố khi cập nhật $e";
    }
} else {
    echo "error: Lỗi PHP request";
}
exit();

function push_avatar($fileName ){
    $supabase_url = 'https://iwelyvdecathaeppslzw.supabase.co';    
    $bucket_name = 'avatar';

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


