<?php
// Kiểm tra xem token có tồn tại trong URL không
if (!isset($_GET['token']) || empty($_GET['token'])) {
    header("Location: fatal.php");
    exit();
}

// Lấy token từ URL
$token = $_GET['token'];

// Thông tin kết nối Supabase
$supabase_url = "https://iwelyvdecathaeppslzw.supabase.co";
$supabase_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Iml3ZWx5dmRlY2F0aGFlcHBzbHp3Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAxMTgzMDAsImV4cCI6MjA0NTY5NDMwMH0.QY-EVOhlyYJXIJqzummyUblLmGQR3JPt2U0IWfPXLwY";
$table = "tokens"; // Tên bảng chứa token
$user_table = "users"; // Tên bảng chứa thông tin người dùng

// Hàm kiểm tra token trong cơ sở dữ liệu Supabase
function checkToken($token) {
    global $supabase_url, $supabase_key, $table;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$supabase_url/rest/v1/$table?token=eq.$token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $supabase_key",
        "Authorization: Bearer $supabase_key",
        "Accept: application/json",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (curl_errno($ch)) {
        file_put_contents("log.txt", "cURL error: " . curl_error($ch));
        curl_close($ch);
        return false;
    }
    curl_close($ch);

    file_put_contents("log.txt", "Token check response: $response");

    if ($httpcode === 401 || $httpcode === 403) {
        return false; // Token không hợp lệ hoặc hết hạn
    }

    $data = json_decode($response, true);
    return !empty($data); // Trả về true nếu token hợp lệ
}

// Hàm cập nhật mật khẩu trong cơ sở dữ liệu Supabase
function updatePassword($token, $new_password) {
    global $supabase_url, $supabase_key, $user_table;

    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    $data = json_encode(["password" => $hashed_password]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$supabase_url/rest/v1/$user_table?token=eq.$token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $supabase_key",  // Thêm `apikey` vào tiêu đề
        "Authorization: Bearer $supabase_key",
        "Accept: application/json",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (curl_errno($ch)) {
        file_put_contents("log.txt", "cURL error during password update: " . curl_error($ch));
    }
    curl_close($ch);

    file_put_contents("log.txt", "Password update response: $response");
    return $httpcode === 200;
}

// Biến để lưu thông báo lỗi
$error_message = "";

// Xử lý khi người dùng ấn nút thay đổi mật khẩu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra token
    if (!checkToken($token)) {
        file_put_contents("log.txt", "Token không hợp lệ hoặc hết hạn: $token");
        header("Location: fatal.php");
        exit();
    }

    // Kiểm tra xem mật khẩu có khớp không
    if ($new_password !== $confirm_password) {
        $error_message = "Mật khẩu xác nhận không khớp!";
    } else {
        // Thực hiện cập nhật mật khẩu
        if (updatePassword($token, $new_password)) {
            header("Location: confirm.php?token=$token");
        } else {
            file_put_contents("log.txt", "Cập nhật mật khẩu thất bại cho token: $token");
            header("Location: fatal.php");
        }
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi Mật Khẩu</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .input-group-text {
            cursor: pointer;
        }

        .form-group small {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .form-control {
            border-radius: 0.375rem;
        }

        .btn-outline-secondary {
            border-radius: 0.375rem;
        }

        .btn-primary {
            border-radius: 0.375rem;
            width: 100%;
        }

        .container {
            margin-top: 80px;
        }

        .card-body {
            padding: 30px;
        }

        h2 {
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card shadow-lg p-4 mb-5 bg-white rounded">
        <div class="card-body">
            <h2 class="text-center">Đổi Mật Khẩu</h2>
            <p class="text-center text-muted">Vui lòng nhập mật khẩu mới và xác nhận mật khẩu để thay đổi.</p>

            <form method="POST" onsubmit="return validatePasswords()">
                <!-- Mật khẩu mới -->
                <div class="form-group">
                    <label for="password">Mật khẩu mới</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required minlength="6" maxlength="20" pattern="[\x21-\x7E]+" title="Mật khẩu từ 6 đến 20 ký tự ASCII (các ký tự từ ! đến ~)">
                        <div class="input-group-append">
                            <span class="input-group-text" onclick="togglePassword('password')"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                    <small class="form-text">Mật khẩu phải từ 6 đến 20 ký tự ASCII (bao gồm các ký tự từ ! đến ~).</small>
                </div>

                <!-- Xác nhận mật khẩu -->
                <div class="form-group">
                    <label for="confirm_password">Xác nhận mật khẩu</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
                        <div class="input-group-append">
                            <span class="input-group-text" onclick="togglePassword('confirm_password')"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Nút gửi -->
                <button type="submit" class="btn btn-primary mt-3">Xác nhận thay đổi mật khẩu</button>
            </form>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<script>
    // Hàm chuyển đổi giữa ẩn và hiển thị mật khẩu
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        field.type = field.type === "password" ? "text" : "password";
    }

    // Kiểm tra mật khẩu có khớp hay không
    function validatePasswords() {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;

        if (password !== confirmPassword) {
            alert("Mật khẩu xác nhận không khớp!");
            return false;
        }
        return true;
    }
</script>

</body>
</html>
