    <?php

    function get_token() {
        file_put_contents("log.txt", "Hàm refresh_token được gọi\n" , FILE_APPEND);
        $apiUrl = "https://iwelyvdecathaeppslzw.supabase.co/auth/v1/token?grant_type=refresh_token";
        $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Iml3ZWx5dmRlY2F0aGFlcHBzbHp3Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAxMTgzMDAsImV4cCI6MjA0NTY5NDMwMH0.QY-EVOhlyYJXIJqzummyUblLmGQR3JPt2U0IWfPXLwY";

        $data = [
            "refresh_token" => $_SESSION['refresh_token'],
        ];

        // Khởi tạo cURL
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "apikey: $apiKey",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Gửi yêu cầu
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Ghi log vào file log.txt
        file_put_contents("log.txt", "Response: $response\n", FILE_APPEND);

        if ($httpCode === 200) {
            $responseData = json_decode($response, true);
            $_SESSION['access_token'] = $responseData['access_token'];
        } else {
            $_SESSION['access_token'] = '';
        }
    }
    ?>