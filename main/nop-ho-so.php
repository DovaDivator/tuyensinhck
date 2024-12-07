<!-- Hàm kiểm tra trang đã đăng nhập chưa -->
<?php

session_start();
if (isset($_SESSION['user'])) {
    //echo "<script>alert('welcom');</script>";
    if ($_SESSION['user']['role'] === "Student") {
        $id = $_SESSION['user']['id'];
    } elseif ($_SESSION['user']['role'] === "Admin" || $_SESSION['user']['role'] === "Teacher") {
        if (isset($_GET['stu_id'])) {
            $id = $_GET['stu_id'];
        } else {
            header("Location: index.php");
            exit();
        }
    } else {
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

include "../php_control/data/get-to-hop.php";
include "../php_control/data/get_ho_so.php";
$list_htts = GetListHinhThucXetTuyen();
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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js_backend/events.js?v=<?php echo filemtime('../js_backend/events.js'); ?>"></script>
    <script src="../js_backend/control.js?v=<?php echo filemtime('../js_backend/control.js'); ?>"></script>
    <script src="../js_backend/dialog.js?v=<?php echo filemtime('../js_backend/dialog.js'); ?>"></script>

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
                            <form method="post" id="Nophs" enctype="multipart/form-data">
                                <div class="form-fields">
                                    <p>
                                        <font color="red">*&nbsp;</font>Tải ảnh CCCD:
                                    </p>
                                    <div class="linediv">
                                        <div class="avatar_container" style="width: 300px; height: 200px; display:flex; justify-content:center; align-items:center; background-color:white;" onclick="document.getElementById('frontof_CCCD').click()">
                                            <input type="file" name="mặt trước CCCD" id="frontof_CCCD" accept="image/*" style="display: none;" onchange="uploadNewImage('frontof_CCCD', 'frontof_CCCD_img')" data-required>

                                            <p class="qweq">Mặt trước CCCD</p>
                                            <!-- Avatar Image -->
                                            <img src="<?php echo getSignedUrl('protect_files', $id . '/' . '674ffaa1d33fd_1733294753.png') ?>" id="frontof_CCCD_img" class="CCCD" >

                                            <!-- Edit Icon Overlay -->
                                            <div class="edit_avatar_img_layout cccd">
                                                <img src="../assets/icon/upload.png?v=<?php echo filemtime('../assets/icon/upload.png'); ?>"
                                                    alt="Upload Icon" height="50" width="50">
                                            </div>
                                        </div>
                                        <div style="width: 10px"></div>
                                        <div class="avatar_container" style="width: 300px; height: 200px; display:flex; justify-content:center; align-items:center; background-color:white;" onclick="document.getElementById('behind_CCCD').click()">
                                            <input type="file" name="mặt sau CCCD" id="behind_CCCD" accept="image/*" style="display: none;" onchange="uploadNewImage('behind_CCCD', 'behind_CCCD_img')" data-required>

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
                                        <label for="so_cccd">
                                            <font color="red">*&nbsp;</font>Số CCCD
                                        </label>
                                        <input type="text" id="so_cccd" name="so_cccd" placeholder="Nhập 12 chữ số!" maxlength="12" pattern="\d{12}"
                                            inputmode="numeric" title="Vui lòng nhập đúng 12 chữ số" oninput="this.value = this.value.replace(/[^0-9]/g, '');" data-required>
                                        <label for="hoTen">
                                            <font color="red">*&nbsp;</font>Họ và tên:
                                        </label>
                                        <input type="text" id="hoTen" name="hoTen" placeholder="Nhập theo CCCD!" data-required>
                                        <label for="date_birth">
                                            <font color="red">*&nbsp;</font>Ngày sinh:
                                        </label>
                                        <input type="text" id="date_birth" name="date_birth" placeholder="Nhập ngày sinh (dd/mm/yyyy)" data-required>

                                        <script>
                                            $(function() {
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
                                            <label>
                                                <font color="red">*&nbsp;</font>Giới tính:
                                            </label>
                                            <input type="radio" name="gender" value="nam" />
                                            <label for="nam">Nam</label>
                                            <input type="radio" name="gender" value="nu" />
                                            <label for="nu">Nữ</label>
                                        </div>

                                        <label for="que_quan">
                                            <font color="red">*&nbsp;</font>Quê quán:
                                        </label>
                                        <input type="text" id="que_quan" name="que_quan" placeholder="Nhập theo CCCD!" data-required>

                                        <div class="linediv" style="margin-bottom: 10px">
                                            <label for="selection" style="margin:0;">
                                                <font color="red">*&nbsp;</font>Hình thức xét tuyển:
                                            </label>
                                            <div style="width:10px"></div>
                                            <select id="selection" name="htts" aria-placeholder="hình thức tuyển sinh" onchange="handleSelectionChange()" data-required>
                                                <option value="" disabled selected>Chọn hình thức</option>
                                                <?php foreach ($list_htts as $row): ?>
                                                    <option value="<?php echo $row['ma_htts']; ?>" data-list-mon="<?php echo $row['list_mon']; ?>"><?php echo $row['ten_htts']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div id="form-section" style="display: none; flex-direction: column;">
                                            <label for="mts">
                                                <font color="red">*&nbsp;</font>Mã tuyển sinh:
                                            </label>
                                            <input type="text" id="mts" name="mts" placeholder="Nhập mã tuyển sinh theo hình thức đã đăng ký" data-required>

                                            <p style="margin:0; margin-bottom: 10px !important">
                                                <font color="red">*&nbsp;</font>Điểm từng môn:
                                            </p>

                                            <div class="diem_mon">

                                            </div>

                                            <label for="img_ts">
                                                <font color="red">*&nbsp;</font>Ảnh chụp xác minh:
                                            </label>
                                            <input type="file" id="img_ts" name="img_ts" accept="image/*">
                                            <p class="note">Tải ảnh minh chứng rõ ràng, đầy đủ theo hướng dẫn <a href="https://www.google.com/" target="_blank">TẠI ĐÂY</a>!</p>
                                        </div>

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
                                    
                                           <select name="proof_type[]" >
                                               <option value="" disabled selected>Chọn loại bằng chứng</option>
                                               <option value="english_certificate">Chứng chỉ tiếng Anh</option>
                                                <option value="international_award">Giải quốc tế</option>
                                                <option value="hsg_exam">Thi HSG</option>
                                                <option value="priority_subject">Đối tượng ưu tiên</option>
                                            </select>
                                    
                                            <select name="proof_detail[]" >
                                                <option value="1" selected>1</option>
                                               <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                    
                                            <input type="file" name="imgs_bonus[]" accept="image/*" >
                                                <button type="button" onclick="removeProofEntry(this)" style="margin-bottom: 10px; width:fit-content">Xóa chỉ mục</button>
                                            <div style="height: 1px; background-color: grey;"></div>
                                        `;

                                                // Thêm mục mới vào container
                                                container.appendChild(newEntry);
                                            }
                                        </script>


                                        <p class="note">Nộp đúng yêu cầu, thông tin chi tiết <a href="https://www.google.com/" target="_blank">TẠI ĐÂY</a>!</p>

                                        <input type="submit" value="Nộp hồ sơ" name="sumbit_hoso" class="custom-button" onclick="NopHoso()">
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
    <?php include '../php_control/path_side/LoadBar.php'; ?>
</body>

</html>

<script>
    window.onbeforeunload = function() {
        // Gọi hàm ClearExistFile để xóa tất cả tệp tạm
        ClearExistFile('delete_all')
            .then(data => {
                if (data.success) {
                    console.log('All temporary files deleted successfully:', data.message);
                } else {
                    console.warn('Failed to delete temporary files:', data.message);
                }
            })
            .catch(error => {
                console.error('Error deleting temporary files:', error);
            });
    };

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

    function handleSelectionChange() {
        const selection = document.getElementById("selection");
        const diemMonDiv = document.querySelector(".diem_mon");

        // Lấy option được chọn
        const selectedOption = selection.options[selection.selectedIndex];
        const listMon = selectedOption.getAttribute("data-list-mon");

        const formSection = document.getElementById('form-section');
        if (selection.value) {
            formSection.style.display = 'flex';
        } else {
            formSection.style.display = 'none';
        }

        // Xóa nội dung cũ
        diemMonDiv.innerHTML = "";

        if (listMon) {
            // Tách các môn từ chuỗi và tạo nội dung động
            listMon.split(", ").forEach((mon, index) => {
                diemMonDiv.innerHTML += `
                <div class="linediv">
                    <label for="mon_${index + 1}">${mon.charAt(0).toUpperCase() + mon.slice(1)}:&nbsp;</label>
                    <input type="number" id="mon_${index + 1}" name="mon_${mon.charAt(0).toUpperCase() + mon.slice(1)}" data-required >
                </div>`;
            });
        }
    }

    // function NopHoSo() {
    //     event.preventDefault();
    //     ShowLoading();

    //     const xhr = new XMLHttpRequest();
    //     xhr.open("POST", "../php_control/data/PushHoSoData.php", true);
    //     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    //     xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    //     xhr.onload = function() {
    //         if (xhr.status === 200) {
    //             const response = xhr.responseText; // Lấy dữ liệu phản hồi

    //             // Nếu bạn không trả về JSON, xử lý phản hồi như một chuỗi
    //             if (response.trim().startsWith("success")) {
    //                 HideLoading();
    //                 SuccessDialog("Thông báo", response.replace("success: ", "Gửi hồ sơ thành công"));
    //             } else if (response.trim().startsWith("warming: ")) {
    //                 HideLoading();
    //                 WarmingDialog("Thông báo", response.replace("warming: ", ""));
    //             } else if (response.trim().startsWith("errorAuth: ")) {
    //                 HideLoading();
    //                 ErrorDialog("Lỗi phiên người dùng", response.replace("errorAuth: ", ""));
    //             } else {
    //                 HideLoading();
    //                 ErrorDialog("Thông báo lỗi", response.replace("error: ", ""));
    //             }
    //         } else {
    //             HideLoading();
    //             ErrorDialog("Lỗi kết nối", "Không thể kết nối đến máy chủ. Vui lòng thử lại sau.");
    //         }
    //     };

    //     xhr.send();
    // }

    function NopHoso() {
        event.preventDefault();
        let inputs = document.querySelectorAll("#Nophs input[data-required]");
        let selectedGender = document.querySelector('input[name="gender"]:checked');
        let Input = document.querySelectorAll("#Nophs input");
        let selects = document.querySelectorAll("#Nophs select")
        let textArea = document.querySelectorAll("#Nophs textarea");
        let radios = document.getElementsByName("gender");
        let checkgender = false;
        let check = true;
        let isValid = true;
        let invalidFields = [];
        let formData = new FormData(); // Sử dụng FormData để thu thập dữ liệu

        inputs.forEach(function(input) {
            input.classList.remove("error");
        });

        // Kiểm tra từng input
        inputs.forEach(function(input) {
            let inputValue = input.value.trim();
            if (!inputValue) {
                isValid = false;
                invalidFields.push(input.getAttribute('placeholder') || input.name || input.id);
                input.classList.add("error");
                check = false
            }
        });

        for (let i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                checkgender = true;
                break;
            }
            if (!checkgender) {
                invalidField = "vui lòng chọn giới tính";
            }
        }

        if (!checkgender) {
            isValid = false;
        }

        if (check) {
            Input.forEach(function(input) {
                let inputValue = "";
                if (input.type === "radio") {
                    if (input.checked) {
                        inputValue = input.value;
                    }
                } else {
                    inputValue = input.value.trim();
                }
                if (inputValue) {
                    formData.append(input.name || input.id, inputValue);
                }
            });
            textArea.forEach(function(text) {
                let textValue = text.value.trim();
                formData.append(text.name || text.id, textValue);
            });
            selects.forEach(function(select) {
                let sValue = select.value.trim();
                formData.append(select.getAttribute('placeholder') || select.name, sValue);
            });
        }

        formData.forEach(function(value, key) {
            console.log(key + ": " + value);
        });
        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi nhập liệu',
                text: `${invalidFields.join(', ')} không được bỏ trống vui lòng kiểm tra lại`,
                confirmButtonText: 'OK'
            });
        } else {
            // Gửi form bằng XHR
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../php_control/data/PushHoSoData.php"<?php echo isset($_GET['ma_nganh']) ? '?update=true' : '';?>, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Xử lý khi gửi thành công, bạn có thể redirect hay hiển thị kết quả tại đây
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: 'Dữ liệu đã được gửi thành công!',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi gửi dữ liệu',
                        text: 'Đã xảy ra lỗi khi gửi dữ liệu. Vui lòng thử lại!',
                        confirmButtonText: 'OK'
                    });
                }
            };

            xhr.onerror = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi kết nối',
                    text: 'Không thể kết nối đến máy chủ. Vui lòng kiểm tra mạng hoặc thử lại!',
                    confirmButtonText: 'OK'
                });
            };
            xhr.send(formData); // Gửi FormData qua XHR
        }



        // Thêm sự kiện input để loại bỏ class lỗi khi người dùng nhập lại
        document.querySelectorAll("#userForm input[data-required]").forEach(function(input) {
            input.addEventListener("input", function() {
                if (input.value.trim()) {
                    input.classList.remove("error");
                } else {
                    input.classList.add("error");
                }
            });
        });
    }
</script>