<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "db_connect.php";
include "refresh_token.php";

// Xử lý yêu cầu đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu JSON từ php://input
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    // Kiểm tra xem dữ liệu có hợp lệ không
    if ($data) {
        $file = 'pushhs.txt';
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
    if (isset($_SESSION['file_path']) && is_array($_SESSION['file_path'])) {
        $uploadedFiles = [];
        $errors = [];
        
        foreach ($_SESSION['file_path'] as $fileType => $filePaths) {
            // Nếu filePaths là chuỗi, chuyển nó thành mảng để xử lý thống nhất
            if (is_string($filePaths)) {
                $filePaths = [$filePaths];
            }
    
            // Duyệt qua từng file trong mảng con
            if (is_array($filePaths)) {
                foreach ($filePaths as $filePath) {
                    // Kiểm tra và tải file lên
                    if (!empty($filePath)) {
                        $filePath = str_replace('../../assets/temp_uploads/', '', $filePath);
                        $pushResult = push_file($filePath);
                        
                        if ($pushResult['httpCode'] == 200) {
                            $uploadedFiles[] = $filePath; // Thêm file vào danh sách đã tải lên
                        } else {
                            // Xử lý lỗi tải file lên
                            if ($pushResult['response']['statusCode'] == 403) {
                                if (strpos($pushResult['response']['message'], 'row-level security policy')) {
                                    $errors[] = "RLS Error for file: $filePath";
                                } else {
                                    $errors[] = "Auth Error for file: $filePath";
                                }
                            } elseif ($pushResult['response']['statusCode'] == 409) {
                                $errors[] = "Conflict Error for file: $filePath";
                            } else {
                                $errors[] = "HTTP Error ({$pushResult['response']['statusCode']}) for file: $filePath";
                            }
                        }
                    }
                }
            }
        }
    
        // Nếu có lỗi, xóa các file đã tải lên
        if (!empty($errors)) {
            foreach ($uploadedFiles as $uploadedFile) {
                delete_uploaded_file($uploadedFile); // Hàm xóa file đã tải lên
            }
            echo json_encode([
                'success' => false,
                'message' => 'Some files failed to upload',
                'errors' => $errors,
            ]);
            exit();
        }
    
        // Nếu tất cả file tải lên thành công
        echo json_encode([
            'success' => true,
            'message' => 'All files uploaded successfully',
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No files to upload',
        ]);
    }

} else {
    echo "error: Lỗi PHP request";
}
exit();

function delete_uploaded_file($fileName) {
    $supabase_url = 'https://iwelyvdecathaeppslzw.supabase.co';
    $bucket_name = 'protect_files';
    $endpoint = $supabase_url . "/storage/v1/object/" . $bucket_name . "/" . $fileName;

    $headers = [
        "Authorization: Bearer " . $_SESSION['access_token']
    ];

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        'httpCode' => $httpCode,
        'response' => json_decode($response, true)
    ];
}

function push_file($fileName ){
    $supabase_url = 'https://iwelyvdecathaeppslzw.supabase.co';    
    $bucket_name = 'protect_files';

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
    file_put_contents("log.txt", "filename: $fileName\n access: ".$_SESSION['access_token']." \nResponse: $response\n", FILE_APPEND);
    return [
        'httpCode' => $httpCode,
        'response' => json_decode($response, true)
    ];
}
?>