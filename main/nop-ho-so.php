<!-- Hàm kiểm tra trang đã đăng nhập chưa -->
<?php

session_start();
if (isset($_SESSION['user'])) {
    //echo "<script>alert('welcom');</script>";
    if($_SESSION['user']['role'] !== "Student") {
        header("Location: index.php");
        exit();
    }
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
    <link rel="stylesheet" href="../assets/style/CSTT.css?v=<?php echo filemtime('../assets/style/CSTT.css'); ?>">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

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
                        <div class="info_layout change_layout_div" id="change_pass_path">
                            <h1>Nộp hồ sơ tuyển sinh</h1>
                            <form action="post" enctype="multipart/form-data">
                                <div class="form-fields">
                                    <p><font color="red">*&nbsp;</font>Tải ảnh CCCD:</p>
                                        <div class="linediv">
                                            <div class="avatar_container" style="width: 300px; height: 200px; display:flex; justify-content:center; align-items:center; background-color:white;" onclick="document.getElementById('frontof_CCCD').click()">
                                                <input type="file" name="frontof_CCCD" id="frontof_CCCD" accept="image/*" style="display: none;" onchange="uploadNewImage('frontof_CCCD', 'frontof_CCCD_img')">

                                                <!-- Avatar Image -->
                                                <img src="" id="frontof_CCCD_img" class="CCCD">
                                                <p class="qweq">Mặt trước CCCD</p>

                                                <!-- Edit Icon Overlay -->
                                                <div class="edit_avatar_img_layout cccd">
                                                    <img src="../assets/icon/upload.png?v=<?php echo filemtime('../assets/icon/upload.png'); ?>" 
                                                    alt="Upload Icon" height="50" width="50">
                                                </div>
                                            </div>
                                            <div style="width: 10px"></div>
                                            <div class="avatar_container" style="width: 300px; height: 200px; display:flex; justify-content:center; align-items:center; background-color:white;" onclick="document.getElementById('behind_CCCD').click()">
                                                <input type="file" name="behind_CCCD" id="behind_CCCD" accept="image/*" style="display: none;" onchange="uploadNewImage('behind_CCCD', 'behind_CCCD_img')">

                                                <p class="qweq">Mặt sau CCCD</p>

                                                <!-- Avatar Image -->
                                                <img src="" id="behind_CCCD_img" class="CCCD">

                                                <!-- Edit Icon Overlay -->
                                                <div class="edit_avatar_img_layout cccd">
                                                    <img src="../assets/icon/upload.png?v=<?php echo filemtime('../assets/icon/upload.png'); ?>" 
                                                    alt="Upload Icon" height="50" width="50">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <p class="note" style="text-align:center !important;">Chú ý chụp hình rõ ràng, tải hoặc kéo thả ảnh đúng vị trí để quét chính xác thông tin!</p>

                                    <div class="form-fields" style="margin: 0 auto; ">
                                    <label for="so_cccd"><font color="red">*&nbsp;</font>Số CCCD</label>
                                    <input type="text" id="so_cccd" name="so_cccd" placeholder="Nhập 12 chữ số!" maxlength="12" pattern="\d{12}" 
                                    inputmode="numeric" title="Vui lòng nhập đúng 12 chữ số" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    <label for="hoTen"><font color="red">*&nbsp;</font>Họ và tên:</label>
                                    <input type="text" id="hoTen" name="hoTen" placeholder="Nhập theo CCCD!" required>
                                    <label for="date_birth"><font color="red">*&nbsp;</font>Ngày sinh: </label>
                                   <input type="text" id="date_birth" name="date_birth" placeholder="Nhập ngày sinh (dd/mm/yyyy)" required>
                                
                                   <script>
                                       $(function () {
                                           $("#date_birth").datepicker({
                                               dateFormat: "dd/mm/yy",      
                                               changeMonth: true,           
                                               changeYear: true,          
                                               yearRange: "-100:+0",        
                                               maxDate: 0             
                                            });
                                        });
                                   </script>
                                    <div class="linediv radio_gender" style="margin-bottom: 10px">
                                        <label><font color="red">*&nbsp;</font>Giới tính:</label>
                                        <input type="radio" name="gender" value="nam"/>
                                        <label for="nam">Nam</label>
                                        <input type="radio" name="gender" value="nu"/>
                                        <label for="nu">Nữ</label>
                                    </div>

                                    <label for="que_quan"><font color="red">*&nbsp;</font>Quê quán:</label>
                                    <input type="text" id="que_quan" name="que_quan" placeholder="Nhập theo CCCD!" required>

                                    <div class="linediv" style="margin-bottom: 10px">
                                    <label for="selection" style="margin:0;"><font color="red">*&nbsp;</font>Hình thức xét tuyển:</label>
                                    <div style="width:10px"></div>
                                    <select id="selection" name="selection" required>
                                        <option value="" disabled selected>Chọn hình thức</option>
                                        <option value="thptqg_khtn">THPTQG - KHTN</option>
                                        <option value="thptqg_khxh">THPTQG - KHXH</option>
                                        <option value="hoc_ba">Học bạ</option>
                                    </select>
                                    </div>    

                                    <label for="mts"><font color="red">*&nbsp;</font>Mã tuyển sinh:</label>
                                    <input type="text" id="mts" name="mts" placeholder="Nhập mã tuyển sinh theo hình thức đã đăng ký" required>

                                    <p style="margin:0; margin-bottom: 10px !important"><font color="red">*&nbsp;</font>Điểm từng môn:</p> 
                                    <div class="diem_mon">
                                        <div class="linediv">
                                            <label for="mon1">Toán:&nbsp;</label>
                                            <input type="number" id="mon1" name="mon1" required>
                                        </div>
                                        <div class="linediv">
                                            <label for="mon2">Văn:&nbsp;</label>
                                            <input type="number" id="mon2" name="mon2" required>
                                        </div>
                                        <div class="linediv">
                                            <label for="mon3">Anh:&nbsp;</label>
                                            <input type="number" id="mon3" name="mon3" required>
                                        </div>
                                    </div>   
                                    
                                    <label for="img_ts"><font color="red">*&nbsp;</font>Ảnh chụp xác minh:</label>
                                    <input type="file" id="img_ts" name="img_ts" accept="image/*" required>
                                    <p class="note">Tải ảnh minh chứng rõ ràng, đầy đủ theo hướng dẫn <a href="https://www.google.com/" target="_blank">TẠI ĐÂY</a>!</p>

                                    <div class="linediv">
                                    <label for="imgs_bonus[]">Giấy chứng nhận đi kèm:</label>
                                    <button type="button" onclick="addProofEntry()" style="margin-left: 10px; margin-bottom: 10px">+</button>
                                    </div>
                                    <div id="proof-container">
                                    </div>
                                    <script>
                                    function addProofEntry() {
                                       // Lấy container
                                       var container = document.getElementById('proof-container');
                                    
                                       // Tạo một div mới cho mục bằng chứng
                                       var newEntry = document.createElement('div');
                                       newEntry.classList.add('proof-entry');
                                    
                                       // Nội dung HTML cho div mới
                                       newEntry.innerHTML = `
                                    
                                           <select name="proof_type[]" required>
                                               <option value="" disabled selected>Chọn loại bằng chứng</option>
                                               <option value="english_certificate">Chứng chỉ tiếng Anh</option>
                                                <option value="international_award">Giải quốc tế</option>
                                                <option value="hsg_exam">Thi HSG</option>
                                                <option value="priority_subject">Đối tượng ưu tiên</option>
                                            </select>
                                    
                                            <select name="proof_detail[]" required>
                                                <option value="1" selected>1</option>
                                               <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                    
                                            <input type="file" name="imgs_bonus[]" accept="image/*" required>
                                                <button type="button" onclick="removeProofEntry(this)" style="margin-bottom: 10px; width:fit-content">Xóa chỉ mục</button>
                                            <div style="height: 1px; background-color: grey;"></div>
                                        `;
                                    
                                        // Thêm mục mới vào container
                                        container.appendChild(newEntry);
                                    }
                                    </script>


                                    <p class="note">Nộp đúng yêu cầu, thông tin chi tiết <a href="https://www.google.com/" target="_blank">TẠI ĐÂY</a>!</p>

                                    <input type="submit" value="Nộp hồ sơ" name="sumbit_hoso" class="custom-button">
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>

                </div>
            </div>


        </div>
    </div>
    </div>
</body>

</html>

<script>
async function uploadNewImage(inputId, imgId) {
    const inputFile = document.getElementById(inputId); // Lấy input file
    const file = inputFile.files[0]; // Lấy file đầu tiên được chọn

    if (file) {
        const formData = new FormData();
        formData.append(inputId, file); // Thêm file vào formData

        try {
            // Gọi hàm xóa file cũ (nếu cần) và chờ cho nó hoàn thành
            const deleteData = await DeleteExistFile(inputId, formData);
            if (deleteData.success) {
                console.log(deleteData.message);
            } else {
                console.error('Có lỗi xảy ra khi xóa ảnh: ' + deleteData.message);
                return; // Dừng quá trình nếu xóa không thành công
            }

            // Gọi hàm tải file tạm lên server
            const uploadData = await UploadTempFile(inputId, formData);
            if (uploadData.success) {
                // Cập nhật ảnh hiển thị sau khi tải lên
                const element_image = document.getElementById(imgId);
                element_image.src = uploadData.imagePath + '?v=' + new Date().getTime();
                element_image.style.scale = 1.5; // Thay đổi kích thước ảnh nếu cần
            } else {
                console.error('Có lỗi xảy ra khi tải ảnh lên: ' + uploadData.message);
            }
        } catch (error) {
            console.error('Upload failed:', error);
            alert('Có lỗi xảy ra khi xử lý ảnh.');
        }
    } else {
        alert('Vui lòng chọn một tệp tin.');
    }
}


</script>