<!-- Hàm kiểm tra trang đã đăng nhập chưa -->
<?php
<<<<<<< HEAD
=======

>>>>>>> c7fb3121a1fb2c8fb936a7b5aac091272d473712
session_start();
if (isset($_SESSION['user'])) {
    //echo "<script>alert('welcom');</script>";
} else {
    //echo "<script>alert('pls login');</script>";
    header("Location: login.php");
    exit();
}
// if (isset($_SESSION['message'])) {
//     echo "<script>alert('" . $_SESSION['message'] . "');</script>"; 
//     unset($_SESSION['message']); 
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Tuyển sinh - Trang chủ</title>
    <link rel="icon" href="../assets/images/logo.png?v=<?php echo filemtime('../assets/images/logo.png'); ?>" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css?v=<?php echo filemtime('../assets/style/style.css'); ?>">
    <link rel="stylesheet" href="../assets/style/taikhoan.css?v=<?php echo filemtime('../assets/style/taikhoan.css'); ?>">
    <link rel="stylesheet" href="../assets/style/table.css?v=<?php echo filemtime('../assets/style/table.css'); ?>">
<<<<<<< HEAD
    <link rel="stylesheet" href="../assets/style/chitiet.css?v=<?php echo filemtime('../assets/style/chitiet.css'); ?>">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
=======
    <link rel="stylesheet" href="../assets/style/CSTT.css?v=<?php echo filemtime('../assets/style/CSTT.css'); ?>">
>>>>>>> c7fb3121a1fb2c8fb936a7b5aac091272d473712

    <script src="../js_backend/events.js?v=<?php echo filemtime('../js_backend/events.js'); ?>"></script>
    <script src="../js_backend/control.js?v=<?php echo filemtime('../js_backend/control.js'); ?>"></script>
</head>

<body>
    <div class="body_container">
        <?php include '../php_control/path_side/nav_toggle.php'; ?>
        <?php include '../php_control/path_side/sidebar.php'; ?>

        <div class="notification layout" id="notificationLayout">
            <?php include '../php_control/path_side/notification.php'; ?>
        </div>

        <div class="right-side">
            <?php include '../php_control/path_side/toolbar.php'; ?>
            <!-- Nội dung chính kết nối trang -->
            <div class="main-content">
                <div class="body_container">
                    <div class="body_path">
<<<<<<< HEAD
                        <div class="info_layout change_layout_div" id="change_info">
                            <div class="linediv">
                                <h1 style='margin: 15px auto;'>Chỉnh sửa thông tin</h1>
                            </div>
                            <!-- User Information Form -->
                            <form id="userForm" enctype="multipart/form-data" method="post">
                                <div class="linediv" style="display: flex; gap: 30px; align-items: flex-start;">

                                    <!-- Avatar Container -->
                                    <div class="avatar_container" style="width: 220px; height: 220px;" onclick="document.getElementById('avatarInput').click()">
                                        <input type="file" name="avatar_upload" id="avatarInput" accept="image/*" style="display: none;">

                                        <!-- Avatar Image -->
                                        <img src="../assets/images/guest.png?v=<?php echo filemtime('../assets/images/logo.png'); ?>" 
                                        alt="User Avatar" style="top: 10px; left: 10px; width: 200px; height: 200px" id="avatarImg">

                                        <!-- Edit Icon Overlay -->
                                        <div class="edit_avatar_img_layout avatar">
                                            <img src="../assets/icon/upload.png?v=<?php echo filemtime('../assets/icon/upload.png'); ?>" 
                                            alt="Upload Icon" height="50" width="50">
                                        </div>
                                    </div>

                                    <!-- Personal Information Fields -->
                                    <div class="form-fields">
                                        <label for="fullname"><font color="red">*</font>&nbsp;Họ và tên:</label>
                                        <input type="text" id="fullname" name="fullname" placeholder="Bắt buộc"
                                        <?php
                                            echo "value='".$_SESSION['user']['username']."'"; 
                                            if($_SESSION['user']['role'] !== 'Admin'){ 
                                                echo "disabled "; 
                                            } 
                                            if($_SESSION['user']['role'] === 'Teacher'){ 
                                                echo "title='Họ và tên của bạn là cố định, vui lòng gửi yêu cầu đến Quản trị viên để nhận hỗ trợ'"; 
                                            } 
                                            if($_SESSION['user']['role'] === 'Student'){ 
                                                echo "title='Vui lòng nộp hồ sơ để cập nhật họ và tên chính xác!'"; 
                                            }
                                        ?>
                                        >

                                        <label for="email"><font color="red">*</font>&nbsp;Email:</label>
                                        <input type="email" id="email" name="email" placeholder="Bắt buộc" required>

                                        <label for="phone">&nbsp;&nbsp;Số điện thoại:</label>
                                        <input type="tel" id="phone" placeholder="Nhập SĐT 10 chữ số! (không bắt buộc)" name="phone">
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="custom-button" style="width: 100%; margin-top: 20px;" onclick="UpdateThongTin()">Cập nhật thông tin</button>
                            </form>
=======
                        <div class="info_layout" id="nguoidung_path">
                            <div class="linediv">
                                <h1>Chỉnh sửa thông tin</h1>
                            </div>

                            <div class="container">
                                <div class="text">
                                    Thông tin cá nhân
                                </div>
                                <form action="#">
                                    <?php
                                       // echo $_SESSION['user']['role'];
                                        if (isset($_SESSION['user']) && $_SESSION['user']['role']  === "Admin") {
                                            echo '<div class="form-row">
                                            <div class="input-data">
                                            <input type="text" value=" cái này lấy trong CSDL " required>
                                            <div class="underline"></div>
                                            <label for="">'. 'ID' .'</label>
                                            </div>
                                            </div>';
                                        } 
                                    ?>
                                    <div class="form-row">
                                        <div class="input-data">
                                            <input type="text" value="sau này chuyển thành php trong này lấy dữ liệu bên CSDL" required>
                                            <div class="underline"></div>
                                            <label for="">Họ và tên </label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-data">
                                            <input type="date" value="2024-10-28" required>
                                            <div class="underline"></div>
                                            <label for="">Ngày sinh</label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-data">
                                            <input type="text" value="" required>
                                            <div class="underline"></div>
                                            <label for="">Email</label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-data">
                                            <input type="text" value="" required>
                                            <div class="underline"></div>
                                            <label for="">SDT</label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="input-data">
                                            <input type="text" value="" required>
                                            <div class="underline"></div>
                                            <label for="">Website Name</label>
                                        </div>
                                    </div>

                                    <div class="form-row submit-btn">
                                        <div class="input-data">
                                            <div class="inner"></div>
                                            <input type="submit" value="submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
>>>>>>> c7fb3121a1fb2c8fb936a7b5aac091272d473712

                        </div>

                    </div>

                </div>
            </div>
<<<<<<< HEAD
        </div>
    </div>

<!-- Modal hiển thị ảnh cắt -->
<div id="cropperModal" style="display: none;">
    <div>
        <img id="imagePreview" src="" alt="Ảnh xem trước" style="max-width: 100%;">
    </div>
    <button onclick="cropImage()" class="custom-button">Cắt và tải lên</button>
    <button onclick="cancelCrop()" class="custom-button">Hủy</button>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
    let cropper;

    // Xử lý khi người dùng chọn tệp ảnh
    document.getElementById('avatarInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        event.target.value = '';

        // Kiểm tra kích thước ảnh (không vượt quá )
        if (file && file.size <= 500 * 1024) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;

                // Hiển thị cropper modal và khởi tạo Cropper.js
                document.getElementById('cropperModal').style.display = 'block';
                cropper = new Cropper(imagePreview, {
                    aspectRatio: 1,
                    viewMode: 1,
                    minCropBoxWidth: 200, // Kích thước tối thiểu chiều rộng khung cắt
                    minCropBoxHeight: 200, // Kích thước tối thiểu chiều cao khung cắt
                });
            };
            reader.readAsDataURL(file);
        } else {
            alert("Kích thước ảnh phải dưới 500KB.");
        }
    });

    // Hàm cắt ảnh và tải lên
    function cropImage() {
    if (cropper) {
        cropper.getCroppedCanvas({
            width: 200,
            height: 200
        }).toBlob((blob) => {
            // Upload blob (ảnh đã cắt) lên server
            const formData = new FormData();
            formData.append('avatar', blob);

            DeleteExistFile('avatar', formData)
                .then(data => {
                    if (data.success) {
                        console.log(data.message);
                    } else {
                        alert('Có lỗi xảy ra khi tải ảnh lên: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Upload failed:', error);
                    alert('Có lỗi xảy ra khi tải ảnh lên.');
                });

            UploadTempFile('avatar', formData)
                .then(data => {
                    if (data.success) {
                        // Cập nhật ảnh hiển thị sau khi tải lên
                        const element_image = document.querySelector('.avatar_container img');
                        element_image.src = data.imagePath + '?v=' + new Date().getTime();
                        element_image.style.top = '0';
                        element_image.style.left = '0';
                        element_image.style.width = '220px';
                        element_image.style.height = '220px';

                        document.getElementById('cropperModal').style.display = 'none';
                        cropper.destroy(); // Hủy cropper sau khi hoàn tất
                        cropper = null;
                    } else {
                        alert('Có lỗi xảy ra khi tải ảnh lên: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Upload failed:', error);
                    alert('Có lỗi xảy ra khi tải ảnh lên.');
                });
        }, 'image/jpeg', 0.9); // Đảm bảo nén nhẹ ảnh trước khi upload
    }
}
    function cancelCrop() {
        // Ẩn cropper modal
        document.getElementById('cropperModal').style.display = 'none';
        if (cropper) {
            cropper.destroy(); // Hủy cropper nếu nó đã được khởi tạo
            cropper = null; // Đặt lại cropper
        }
    }
</script>
</body>

</html>
=======


        </div>
    </div>
    </div>
</body>

</html>
>>>>>>> c7fb3121a1fb2c8fb936a7b5aac091272d473712
