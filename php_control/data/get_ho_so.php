<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include "db_connect.php";

    function getSignedUrl($bucket, $path, $expiresIn = 3600, $retry = true) {
        file_put_contents("log.txt", "run log", FILE_APPEND);
        // Thông tin kết nối Supabase
        $supabaseUrl = 'https://iwelyvdecathaeppslzw.supabase.co'; // Thay thế bằng URL Supabase của bạn
    
        // API endpoint để tạo Signed URL
        $apiEndpoint = "$supabaseUrl/storage/v1/object/sign/$bucket/$path";
    
        // Dữ liệu body
        $body = json_encode([
            "expiresIn" => $expiresIn
        ]);
    
        // Tạo cURL request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer ".$_SESSION['access_token'],
            "Content-Type: application/json"
        ]);
    
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        file_put_contents("log.txt", "Http: $httpCode    Response: $response\n", FILE_APPEND);
        $responseData = json_decode($response, true);

        // Xử lý phản hồi
        if ($httpCode === 200) {
            if (isset($responseData['signedURL'])) {
                return "https://iwelyvdecathaeppslzw.supabase.co/storage/v1".$responseData['signedURL'];
            }
        } elseif ($responseData['statusCode'] === 403) {
            // Xử lý lỗi "jwt expired"

            if (isset($responseData['message']) && $responseData['message'] == "jwt expired") {
                // Nếu chưa retry thì làm mới token và thử lại
                if ($retry) {
                    return getSignedUrl($bucket, $path, $expiresIn, false); // Gọi lại hàm và đánh dấu đã thử lại
                }
            }
        }
    
        // Nếu có lỗi, trả về chuỗi rỗng
        if($retry){
            return '';
        }else{
            return 'da_chay';
        }
    }
?>