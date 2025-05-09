<!-- Hàm kiểm tra trang đã đăng nhập chưa -->
<?php
session_start();
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] !== "Admin") {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}

include("../php_control/data/get_info_nganh.php");
include("../php_control/data/get-to-hop.php");
include("../php_control/data/ds_tuyen_sinh.php");
include("../php_control/data/download_cloud_file.php");

if (isset($_GET['ma_nganh'])) {
    $ma_nganh  = $_GET['ma_nganh'];
    $test = getInfoNganh($ma_nganh);
    $ct = (int)$test["chi_tieu"];
}

// echo "<script>alert('".$test["ten"]."');</script>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Tuyển sinh - Thống kê số liệu</title>
    <link rel="icon" href="../assets/images/logo.png?v=<?php echo filemtime('../assets/images/logo.png'); ?>" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css?v=<?php echo filemtime('../assets/style/style.css'); ?>">
    <link rel="stylesheet" href="../assets/style/admin_path.css?v=<?php echo filemtime("../assets/style/admin_path.css") ?>">
    <link rel="stylesheet" href="../assets/style/taikhoan.css?v=<?php echo filemtime('../assets/style/taikhoan.css'); ?>">
    <script src="../js_backend/events.js?v=<?php echo filemtime('../js_backend/events.js'); ?>"></script>
    <script src="../js_backend/control.js?v=<?php echo filemtime('../js_backend/control.js'); ?>"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


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
                        <div class="info_layout change_layout_div" id="change_info" style="padding-left: 50px; padding-right: 50px;">
                            <div class="linediv">
                                <h1 style='margin: 15px auto;'>
                                    <?php
                                    if (isset($_GET['ma_nganh'])) {
                                        echo "Chỉnh sửa chuyên ngành";
                                    } else {
                                        echo "Thêm chuyên ngành";
                                    }
                                    ?>
                                </h1>
                            </div>
                            <!-- User Information Form -->
                            <form id="userForm" enctype="multipart/form-data" method="post">

                                <div class="form-fields">
                                    <div class="linediv">
                                        <label for="fullname" style="margin-bottom: 0; margin-right: 10px">
                                            <font color="red">*</font>&nbsp;Mã ngành:
                                        </label>
                                        <input type="text" id="id_nganh" name="id_nganh" value="<?php
                                                                                                if (isset($_GET['ma_nganh'])) {
                                                                                                    echo $test["id"];
                                                                                                }; ?>"
                                            maxlength="10" style="margin-bottom: 0; width: 120px;"
                                            <?php
                                            if (isset($_GET['ma_nganh'])) {
                                                echo "disabled";
                                            }
                                            ?>
                                            data-required>
                                    </div>
                                    <p class="note_input">Mã ngành là cố định và sẽ không thể thay đổi sau khi tạo</p>

                                    <label for="ten">
                                        <font color="red">*</font>&nbsp;Tên chuyên ngành:
                                    </label>
                                    <input type="text" id="ten" name="ten"
                                        value="<?php
                                                if (isset($_GET['ma_nganh'])) {
                                                    echo $test["ten"];
                                                }; ?>" placeholder="Tên chuyên ngành" data-required>

                                    <div class="linediv" style="margin-top: 15px;">
                                        <label for="chi_tieu" style="margin-bottom: 0; margin-right: 10px">
                                            <font color="red">*</font>&nbsp;Chỉ tiêu:
                                        </label>
                                        <input type="number" id="chi_tieu" name="chi_tieu" min="1" step="1" style="margin-bottom: 0; width: 120px;"
                                            value=<?php
                                                    if (isset($_GET['ma_nganh'])) {
                                                        echo $ct;
                                                    }
                                                    ?> placeholder="chỉ tiêu" data-required>
                                    </div>

                                    <div class="linediv" style="margin-top: 15px;">
                                        <label for="chuong_trinh" style="margin-bottom: 0; margin-right: 10px">
                                            <font color="red">*</font>&nbsp;Số năm đào tạo:
                                        </label>
                                        <input type="number" id="chuong_trinh" name="chuong_trinh" min="1" step="1" style="margin-bottom: 0; width: 120px;"
                                            value="<?php
                                                    if (isset($_GET['ma_nganh'])) {
                                                        echo (int)$test["chuong_trinh"];
                                                    }
                                                    ?>" placeholder="Số năm đào tạo" data-required>
                                    </div>

                                    <label for="to_hop">
                                        <font color="red">*</font>&nbsp;Tổ hợp:
                                    </label>
                                    <input type="text" id="to_hop" name="to_hop" readonly placeholder="tổ hợp"
                                        value="<?php
                                                if (isset($_GET['ma_nganh'])) {
                                                    echo $test["to_hop"];
                                                }
                                                ?>" placeholder="Tổ hợp" data-required>
                                    <div class="dropdown_container">
                                        <div class="dropdown" id="dropdown_to_hop" style='top: -10px;'>
                                            <input type="text" id="searchInputToHop" placeholder="Tìm kiếm..." class="dropdown-search">
                                            <div class="dropdown-list">
                                                <?php foreach (GetToHop() as $row): ?>
                                                    <div data-id="<?php echo $row['id']; ?>">
                                                        <?php echo $row['id']; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <label>Ngày mở tín chỉ: </label>
                                    <div class="linediv" style="margin-bottom: 0;">
                                        <input type="text" id="date_open_day" name="date_open_day" placeholder="dd/mm/yyyy" style="width: 150px; margin-right: 10px"
                                            value="<?php
                                                    if (isset($_GET['ma_nganh'])) {
                                                        echo (new DateTime(substr($test["date_open"], 0, 19)))->format('d/m/Y');
                                                    }
                                                    ?>"
                                            class="flatpickr">
                                        <input type="text" id="date_open_time" name="date_open_time" placeholder="hh:mm" style="width: 100px;"
                                            value="<?php
                                                    if (isset($_GET['ma_nganh'])) {
                                                        echo (new DateTime(substr($test["date_open"], 0, 19)))->format('H:i');
                                                    }
                                                    ?>"
                                            class="flatpickr">
                                    </div>
                                    <p class="note_input">Bạn không thể thay đổi thời gian khi tín chỉ đã mở</p>

                                    <label>
                                        <font color="red">*&nbsp;</font>Ngày đóng tín chỉ:
                                    </label>
                                    <div class="linediv" style="margin-bottom: 0;">
                                        <input type="text" id="date_end_day" name="date_end_day" placeholder="dd/mm/yyyy" style="width: 150px; margin-right: 10px"
                                            value="<?php
                                                    if (isset($_GET['ma_nganh'])) {
                                                        echo (new DateTime(substr($test["date_end"], 0, 19)))->format('d/m/Y');
                                                    }
                                                    ?>" aria-placeholder="Ngày đóng tín chỉ"
                                            class="flatpickr" data-required>
                                        <input type="text" id="date_end_time" name="date_end_time" placeholder="hh:mm" style="width: 100px;"
                                            value="<?php
                                                    if (isset($_GET['ma_nganh'])) {
                                                        echo (new DateTime(substr($test["date_end"], 0, 19)))->format('H:i');
                                                    }
                                                    ?>" aria-placeholder="Giờ đóng tín chỉ"
                                            class="flatpickr" data-required>
                                    </div>

                                    <div class="linediv" style="margin-top: 15px;">
                                        <label for="diem_chuan" style="margin-bottom: 0; margin-right: 10px">
                                            <font color="red">*</font>&nbsp;Điểm chuẩn:
                                        </label>
                                        <input type="number" step="0.01" id="diem_chuan" name="diem_chuan" min="0" step="1" style="margin-bottom: 0; width: 120px;"
                                            value="<?php
                                                    if (isset($_GET['ma_nganh'])) {
                                                        echo $test["diem_chuan"];
                                                    }
                                                    ?>"
                                            placeholder="điểm chuẩn" data-required>
                                    </div>
                                    <div class="linediv" style="margin-top: 15px;">
                                        <label>Ghi chú:</label>
                                        <button type="button" onclick="addNote()" style="margin-left: 10px; margin-bottom: 10px">+</button>
                                    </div>
                                    <div id="ghi_chu_ele">
                                        <?php
                                        if (!empty($test["ghi_chu"])) {
                                            // Giải mã JSON thành mảng
                                            $list_mon = json_decode($test["ghi_chu"], true);

                                            // Kiểm tra xem dữ liệu đã được giải mã có phải là mảng hay không
                                            if (is_array($list_mon)) {
                                                foreach ($list_mon as $key => $value) {
                                                    echo '<div class="linediv" style="align-items: center;">';

                                                    // Tạo select box với key là option
                                                    echo '<select name="diem[]" required style="margin-right: 10px; margin-bottom: 0px;">';
                                                    echo '<option disabled>Chọn môn</option>';
                                                    echo '<option value="' . htmlspecialchars($key) . '" selected>' . htmlspecialchars($key) . '</option>';
                                                    echo '</select>';

                                                    // Tạo input với value được đặt sẵn
                                                    echo '<input type="number" name="diem_loc[]" min="0" step="0.01" value="' . htmlspecialchars($value) . '" style="margin-bottom: 0; margin-right: 10px; width: 120px;">';

                                                    // Nút xóa
                                                    echo '<button type="button" onclick="removeProofEntry(this)" style="margin-bottom: 0px; width:fit-content">-</button>';

                                                    echo '</div>';
                                                }
                                            } else {
                                                echo 'Dữ liệu trong ghi_chu không hợp lệ.';
                                            }
                                        } else {
                                            echo 'Không có dữ liệu trong ghi_chu.';
                                        }
                                        ?>
                                    </div>
                                    <script>
                                        // Hàm cập nhật danh sách môn học mới nhất
                                        function updateListMon(newListMon) {
                                            list_mon = newListMon;

                                            // Lấy tất cả các dropdown đang hiển thị
                                            const dropdowns = document.querySelectorAll('#ghi_chu_ele select[name="diem[]"]');

                                            dropdowns.forEach(dropdown => {
                                                const selectedValue = dropdown.value; // Lưu lựa chọn hiện tại nếu có
                                                dropdown.innerHTML = ''; // Xóa toàn bộ các tùy chọn cũ

                                                // Thêm lại danh sách các tùy chọn mới
                                                dropdown.innerHTML = `<option disabled selected>Chọn môn</option>`;
                                                list_mon.forEach(mon => {
                                                    const option = document.createElement('option');
                                                    option.value = mon;
                                                    option.textContent = mon;
                                                    dropdown.appendChild(option);
                                                });

                                                // Giữ nguyên lựa chọn nếu vẫn còn hợp lệ
                                                if (list_mon.includes(selectedValue)) {
                                                    dropdown.value = selectedValue;
                                                } else {
                                                    // Nếu không hợp lệ, chuyển về trạng thái mặc định
                                                    dropdown.value = '';
                                                }
                                            });
                                        }

                                        // Hàm thêm ghi chú
                                        function addNote() {
                                            const toHop = document.getElementById('to_hop').value;
                                            if (!toHop) {
                                                alert("Vui lòng chọn tổ hợp trước.");
                                                return;
                                            }

                                            // Lấy container
                                            const container = document.getElementById('ghi_chu_ele');

                                            // Tạo một div mới cho mục ghi chú
                                            const newEntry = document.createElement('div');
                                            newEntry.classList.add('proof-entry');

                                            // Nội dung HTML cho div mới
                                            newEntry.innerHTML = `
                                            <div class="linediv" style="align-items: center;">
                                                <select name="diem[]" required style="margin-right: 10px; margin-bottom: 0px;">
                                                    <option disabled selected>Chọn môn</option>
                                                    ${list_mon.map(mon => `<option value="${mon}">${mon}</option>`).join('')}
                                                </select>
                                                <input type="number" name="diem_loc[]" min="0" step="1" style="margin-bottom: 0; margin-right: 10px; width: 120px;">
                                                <button type="button" onclick="removeProofEntry(this)" style="margin-bottom: 0px; width:fit-content">-</button>
                                            </div>
                                        `;

                                            // Thêm mục mới vào container
                                            container.appendChild(newEntry);
                                        }

                                        // Hàm xóa một mục ghi chú
                                        function removeProofEntry(button) {
                                            const entry = button.closest('.proof-entry');
                                            if (entry) {
                                                entry.remove();
                                            }
                                        }
                                    </script>

                                    <p class="note_input">Chọn môn và nhập điểm tối thiểu cần đạt</p>

                                    <label for="gv_id">Giáo viên phụ trách:</label>
                                    <input type="text" id="gv_id" name="gv_id" readonly placeholder="Chọn giáo viên phụ trách..." style="width: 350px;"
                                        value="<?php
                                                if (isset($_GET['ma_nganh'])) {
                                                    $gv_input =  getDSGV($test['gv_id'], "", "")[0];
                                                    echo $gv_input['id'] . " - " . $gv_input['ten'];
                                                }
                                                ?>">
                                    <div class="dropdown_container">
                                        <div class="dropdown" id="dropdown_gv_id" style='top: -10px; width: 325px;'>
                                            <input type="text" id="searchInput_gv_id" placeholder="Tìm kiếm..." class="dropdown-search">
                                            <div class="dropdown-list">
                                                <div class="dropdown-item default" data-id="default">Trống...</div>
                                                <?php foreach (getDSGV("", "", "") as $row): ?>
                                                    <div data-id="<?php echo $row['id']; ?>">
                                                        <?php echo $row['id'] . " - " . $row['ten']; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <label for="mo_ta">Mô tả:</label>
                                    <textarea
                                        id="mo_ta"
                                        name="mo_ta"
                                        placeholder="Viết tối đa 5000 ký tự"
                                        maxlength="5000"
                                        style="width: 350px; height: 150px;"><?php
                                                                                if (isset($_GET['ma_nganh'])) {
                                                                                    echo $test["mo_ta"];
                                                                                }
                                                                                ?></textarea>

                                    <label for="phuong_tien">Phương tiện:</label>
                                    <div style='display:grid; grid-template-columns: repeat(2, 1fr); margin-right: 25px;'>
                                        <label style="margin:0;"><input type="radio" name="phuong_tien" value="media" onclick="handleRadioClick(this, 'url')"
                                                <?php if (isset($_GET['ma_nganh']) && !empty($test['iframe'])) {
                                                    echo "checked";
                                                } ?>> Video URL</label>
                                        <label style="margin:0;"><input type="radio" name="phuong_tien" value="image" onclick="handleRadioClick(this, 'file')"
                                                <?php if (isset($_GET['ma_nganh']) && !empty($test['img_link'])) {
                                                    echo "checked";
                                                } ?>> Tải ảnh</label>
                                    </div>
                                    <div style='height: 15px'></div>
                                    <input tyle="text" id="url" name="url" style="width: 100%; display: none;" placeholder="Điền link nhúng vào" value="<?php echo isset($_GET['ma_nganh']) ? $test['iframe'] : ''; ?>">
                                    <input type="file" id="file_temp" style="width: 100%; display: none;" name="file_temp">
                                    <div id="file_path_hold" style="display: none;">
                                        <?php if (isset($_GET['ma_nganh']) && !empty($test['img_link'])): ?>
                                            <p class="file_path_text">File ảnh hiện tại: <a href="<?php echo GetPublicLink('nganh_image', $test['img_link']) ?>" download="<?php echo $test['img_link']; ?>"><?php echo $test['img_link']; ?></a></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="chu_thich_hold" style="display:none; margin-top: 10px;">
                                        <label for="chu_thich">
                                            <font color="red">*</font>&nbsp;Chú thích:
                                        </label>
                                        <input type="text" id="chu_thich" name="chu_thich" style="width: 100%;" placeholder="Thêm chú thích" value="<?php echo isset($_GET['ma_nganh']) ? $test['chu_thich'] : ''; ?>">
                                    </div>

                                    <div class="linediv" style="margin-bottom: 10px;">
                                        <input type="checkbox" name="enable" id="enable" <?php if (isset($test['isenable']) && $test['isenable']) {
                                                                                                echo "checked";
                                                                                            } ?>>
                                        <label for="enable">Hiển thị chuyên ngành đăng ký?</label>
                                    </div>

                                    <button type="submit" class="custom-button" style="width: 100%; margin-top: 20px;">Cập nhật thông tin</button>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    const textInputToHop = document.getElementById('to_hop');
    const dropdownToHop = document.getElementById('dropdown_to_hop');
    let list_mon;

    // Hiển thị danh sách khi click vào input
    textInputToHop.addEventListener('click', () => {
        dropdownToHop.style.display = dropdownToHop.style.display === 'block' ? 'none' : 'block';
    });

    // Thêm lựa chọn khi click vào dropdown
    dropdownToHop.addEventListener('click', (e) => {
        if (e.target.tagName === 'DIV') {
            const selectedOptionId = e.target.getAttribute('data-id'); // Lấy giá trị id từ thuộc tính data-id
            if (!textInputToHop.value.includes(selectedOptionId)) {
                textInputToHop.value += textInputToHop.value ? `, ${selectedOptionId}` : selectedOptionId;

                GetMonList(selectedOptionId);
            }

            dropdownToHop.style.display = 'none'; // Ẩn dropdown sau khi chọn
        }
    });

    function GetMonList(selectedOptionId) {
        // Gán giá trị id vào textInput (tránh trùng lặp)

        const xhr2 = new XMLHttpRequest();
        xhr2.open("POST", "../php_control/data/get_list_mon.php", true);
        xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr2.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr2.onload = function() {
            if (xhr2.status === 200) {
                const response = JSON.parse(xhr2.responseText);
                list_mon = response.map(row => row.mon);
                const dropdowns = document.querySelectorAll('#ghi_chu_ele select[name="diem[]"]');

                // Duyệt qua các dropdown và cập nhật lại các option
                dropdowns.forEach(dropdown => {
                    const selectedValue = dropdown.value;

                    // Xóa hết các option cũ và thêm option mới từ list_mon
                    dropdown.innerHTML = `<option disabled selected>Chọn môn</option>`; // Thêm option "Chọn môn"

                    list_mon.forEach(mon => {
                        const option = document.createElement('option');
                        option.value = mon;
                        option.textContent = mon;

                        // Nếu môn trong list_mon đã được chọn trước đó, giữ lại lựa chọn
                        if (selectedValue === mon) {
                            option.selected = true;
                        }

                        dropdown.appendChild(option);
                    });
                });
            } else {
                // Xử lý lỗi nếu có
                console.error('Error:', xhr2.status);
            }
        };

        xhr2.send(`list=${encodeURIComponent(textInputToHop.value)}`);
    }

    // Xóa lựa chọn bằng phím Backspace hoặc Delete
    textInputToHop.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' || e.key === 'Delete') {
            const values = textInputToHop.value.split(', ');
            values.pop(); // Xóa lựa chọn cuối cùng
            textInputToHop.value = values.join(', ');
            e.preventDefault(); // Ngăn người dùng xóa bằng cách thông thường
        }
    });

    // Ẩn dropdown khi click bên ngoài
    document.addEventListener('click', (e) => {
        if (!dropdownToHop.contains(e.target) && e.target !== textInputToHop) {
            dropdownToHop.style.display = 'none';
        }
    });

    $(function() {

        flatpickr("#date_end_day", {
            dateFormat: "d/m/Y", // Định dạng ngày
            minDate: "",
        });
        flatpickr("#date_end_time", {
            enableTime: true, // Bật chế độ chọn giờ
            noCalendar: true, // Tắt lịch (chỉ chọn giờ)
            dateFormat: "H:i", // Định dạng giờ
            time_24hr: true // Sử dụng định dạng 24 giờ
        });
        flatpickr("#date_open_day", {
            dateFormat: "d/m/Y", // Định dạng ngày
            minDate: "",
        });
        flatpickr("#date_open_time", {
            enableTime: true, // Bật chế độ chọn giờ
            noCalendar: true, // Tắt lịch (chỉ chọn giờ)
            dateFormat: "H:i", // Định dạng giờ
            time_24hr: true // Sử dụng định dạng 24 giờ
        });

    });

    let lastCheckedRadio = null; // Biến lưu radio đang được chọn

    function handleRadioClick(radio, type) {
        const urlInput = document.getElementById("url");
        const fileInput = document.getElementById("file_temp");
        const filePathHold = document.getElementById("file_path_hold");
        const note = document.getElementById("chu_thich");
        const note_div = document.getElementsByClassName("chu_thich_hold");

        // Nếu radio được nhấn lại (bỏ tick)
        if (lastCheckedRadio === radio) {
            radio.checked = false; // Bỏ tick
            lastCheckedRadio = null; // Reset trạng thái
            urlInput.style.display = "none";
            fileInput.style.display = "none";
            filePathHold.style.display = "none";
            note.value = "";
            note_div[0].style.display = "none";
        } else {
            // Cập nhật radio mới được chọn
            lastCheckedRadio = radio;

            if (type === "url") {
                urlInput.style.display = "block";
                fileInput.style.display = "none";
                filePathHold.style.display = "none";
            } else if (type === "file") {
                urlInput.style.display = "none";
                fileInput.style.display = "block";
                filePathHold.style.display = "block";
            }
            note_div[0].style.display = "block";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInputToHop = document.getElementById('searchInputToHop');
        const dropdownListToHop = document.querySelector('.dropdown-list');
        const itemsToHop = Array.from(dropdownListToHop.children); // Lấy tất cả các mục trong danh sách

        // Gọi hàm với các tham số cần thiết
        handleSearch(searchInputToHop, itemsToHop);
    });

    const GVInput = document.getElementById('gv_id');
    const dropdownGV = document.getElementById('dropdown_gv_id');
    const dropdownListGV = dropdownGV.querySelector('.dropdown-list');

    const searchInputGV = document.getElementById('searchInput_gv_id');
    const itemsGV = Array.from(dropdownListGV.children);
    handleSearch(searchInputGV, itemsGV);

    GVInput.addEventListener('click', () => {
        dropdownGV.style.display = dropdownGV.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', (e) => {
        if (!dropdownGV.contains(e.target) && e.target !== GVInput) {
            dropdownGV.style.display = 'none';
        }
    });

    dropdownGV.addEventListener('click', (e) => {
        if (e.target.tagName === 'DIV') {
            if (e.target.classList.contains('default')) {
                GVInput.value = '';
            } else {
                GVInput.value = e.target.textContent.trim(); // Lấy nội dung của mục được chọn
            }

            dropdownGV.style.display = 'none';
        }
    });


    // Lắng nghe sự kiện submit của form
    document.getElementById("userForm").addEventListener("submit", function(event) {
        event.preventDefault();
        let check = true;
        let isValid = true;
        let invalidFields = [];
        let Array = [];
        let formData = new FormData();

        let idNganh = document.getElementById("id_nganh");
        if (!idNganh.value.trim()) {
            isValid = false;
            invalidFields.push("Mã ngành");
            check = false;
        }
        let ten = document.getElementById("ten");
        if (!ten.value.trim()) {
            isValid = false;
            invalidFields.push("Tên");
            check = false;
        }
        let chiTieu = document.getElementById("chi_tieu");
        if (!chiTieu.value.trim()) {
            isValid = false;
            invalidFields.push("Chỉ tiêu");
            check = false;
        }
        let chuongTrinh = document.getElementById("chuong_trinh");
        if (!chuongTrinh.value.trim()) {
            isValid = false;
            invalidFields.push("Số năm đào tạo");
            check = false;
        }
        let toHop = document.getElementById("to_hop");
        if (!toHop.value.trim()) {
            isValid = false;
            invalidFields.push("Tổ hợp");
            check = false;
        }
        let dateOpenDay = document.getElementById("date_open_day");
        let dateOpenTime = document.getElementById("date_open_time");
        let dateEndDay = document.getElementById("date_end_day");
        if (!dateEndDay.value.trim()) {
            isValid = false;
            invalidFields.push("Ngày kết thúc");
            check = false;
        }
        let dateEndTime = document.getElementById("date_end_time");
        if (!dateEndTime.value.trim()) {
            isValid = false;
            invalidFields.push("Giờ kết thúc");
            check = false;
        }
        if (dateEndDay.value < dateOpenDay.value) {
            isValid = false;
            invalidFields.push("ngày bắt đầu và kết thúc");
            check = false;
            console.log("X");
        }
        if (dateEndDay.value === dateOpenDay.value && dateOpenTime.value >= dateEndTime.value) {
            isValid = false;
            invalidFields.push("Giờ bắt đầu và kết thúc");
            check = false;
        }

        let diemChuan = document.getElementById("diem_chuan");
        if (!diemChuan.value.trim()) {
            isValid = false;
            invalidFields.push("Điểm chuẩn");
            check = false;
        }
        let gvId = document.getElementById("gv_id");
        let moTa = document.getElementById("mo_ta");
        let phuong_tien = document.getElementById("userForm").querySelector('input[name="phuong_tien"]:checked');
        let url = document.getElementById("url");
        let file_temp = document.getElementById("file_temp");

        let chu_thich = document.getElementById("chu_thich");
        if (!chu_thich.value.trim() && phuong_tien) {
            console.log("catch");
            isValid = false;
            invalidFields.push("Chú thích thêm");
            check = false;
        }

        const entries = document.querySelectorAll('#ghi_chu_ele .linediv');
        const values = [];

        entries.forEach(entry => {
            const select = entry.querySelector('select[name="diem[]"]');
            const input = entry.querySelector('input[name="diem_loc[]"]');

            // Kiểm tra nếu cả select và input đều có giá trị
            if (select && input) {
                const selectedMon = select.value;
                const diem = input.value;

                values.push({
                    mon: selectedMon,
                    diem: diem
                });
            }
        });

            Array.push({
                key: idNganh.name || idNganh.id,
                value: idNganh.value
            })
            Array.push({
                key: ten.name || ten.id,
                value: ten.value
            })
            Array.push({
                key: chiTieu.name || chiTieu.id,
                value: chiTieu.value
            });
            Array.push({
                key: chuongTrinh.name || chuongTrinh.id,
                value: chuongTrinh.value
            });
            Array.push({
                key: toHop.name || toHop.id,
                value: toHop.value
            });
            Array.push({
                key: "day_open",
                value: dateOpenDay.value + "  " + dateOpenTime.value
            });
            Array.push({
                key: "day_close",
                value: dateEndDay.value + "  " + dateEndTime.value
            });
            Array.push({
                key: diemChuan.name || diemChuan.id,
                value: diemChuan.value
            });
            Array.push(values);
            Array.push({
                key: gvId.name || gvId.id,
                value: gvId.value
            });
            Array.push({
                key: moTa.name || moTa.id,
                value: moTa.value
            });

            Array.push({
                key: 'phuong_tien',
                value: phuong_tien ? phuong_tien.value : ''
            });

            Array.push({
                key: url.name || url.id,
                value: url.value
            });

            Array.push({
                key: chu_thich.name || chu_thich.id,
                value: chu_thich.value
            });

            Array.push({
                key: 'isenable',
                value: document.getElementById("enable").checked
            });

            if (phuong_tien && phuong_tien.value === 'image' && file_temp && file_temp.value !== '') {
                const fileType = 'file_temp';
                const formData = new FormData();
                const fileInput = document.getElementById('file_temp');
                
                DeleteExistFile(fileType, formData);

                formData.append('file_type', fileType);
                formData.append('file_temp', fileInput.files[0]);
                
                UploadTempFile('file_temp', formData)
                    .then(response => {
                        if (response.success) {
                            console.log('Tải lên file thành công');
                            // Thêm giá trị file vào Array sau khi tải xong
                            Array.push({
                                key: file_temp.name || file_temp.id,
                                value: response.imagePath // Đường dẫn file trả về từ server
                            });
                            sendFormData(Array); // Gửi form sau khi tải file thành công
                        } else {
                            console.log('Tải lên file thất bại: ' + response.message);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi tải lên',
                                text: response.message || 'Không thể tải file. Vui lòng thử lại!',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi tải lên:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi tải lên',
                            text: 'Đã xảy ra lỗi khi tải file. Vui lòng thử lại!',
                            confirmButtonText: 'OK'
                        });
                    
                    });
            } else {
                sendFormData(Array); // Nếu không cần tải file, gửi form ngay lập tức
            }
        });
// Hàm gửi form


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

</script>

<script>
function sendFormData(Array) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../php_control/data/chinhsuanganhdata.php<?php echo isset($_GET['ma_nganh']) ? '?update=true' : ''; ?>", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                console.log(xhr.responseText);
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: response.message || 'Dữ liệu đã được gửi thành công!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi gửi dữ liệu',
                        text: response.message || 'Đã xảy ra lỗi khi gửi dữ liệu. Vui lòng thử lại!',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi phản hồi',
                    text: 'Phản hồi từ máy chủ không hợp lệ. Vui lòng thử lại!',
                    confirmButtonText: 'OK'
                });
                console.error('Lỗi parse JSON:', e);
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi kết nối',
                text: 'Không thể kết nối đến máy chủ. Mã lỗi: ' + xhr.status,
                confirmButtonText: 'OK'
            });
        }
    };

    xhr.onerror = function () {
        Swal.fire({
            icon: 'error',
            title: 'Lỗi kết nối',
            text: 'Không thể kết nối đến máy chủ. Vui lòng kiểm tra mạng hoặc thử lại!',
            confirmButtonText: 'OK'
        });
    };

    let jsonData = JSON.stringify(Array);
    console.log(jsonData);
    xhr.send(jsonData);
}


function handleRadioClick(radio, type) {
        const urlInput = document.getElementById("url");
        const fileInput = document.getElementById("file_temp");
        const filePathHold = document.getElementById("file_path_hold");
        const note = document.getElementById("chu_thich");
        const note_div = document.getElementsByClassName("chu_thich_hold");

        // Nếu radio được nhấn lại (bỏ tick)
        if (lastCheckedRadio === radio) {
            radio.checked = false; // Bỏ tick
            lastCheckedRadio = null; // Reset trạng thái
            urlInput.style.display = "none";
            fileInput.style.display = "none";
            filePathHold.style.display = "none";
            note.value = "";
            note_div[0].style.display = "none";
        } else {
            // Cập nhật radio mới được chọn
            lastCheckedRadio = radio;

            if (type === "url") {
                urlInput.style.display = "block";
                fileInput.style.display = "none";
                filePathHold.style.display = "none";
            } else if (type === "file") {
                urlInput.style.display = "none";
                fileInput.style.display = "block";
                filePathHold.style.display = "block";
            }
            note_div[0].style.display = "block";
        }
    }
</script>


<?php if (isset($_GET['ma_nganh'])): ?>
    <script>
        const toHopInputStart = document.getElementById('to_hop');
        if (toHopInputStart && toHopInputStart.value) {
            const toHopArray = toHopInputStart.value.split(',').map(item => item.trim());

            toHopArray.forEach(mon => {
                if (mon) {
                    GetMonList(mon);
                }
            });
        }
        console.log(list_mon);
    </script>
<?php endif; ?>

<?php if (isset($_GET['ma_nganh'])): ?>
    <?php if (!empty($test['iframe'])): ?>
        <script>
            handleRadioClick('media', 'url');
        </script>
    <?php elseif (!empty($test['img_link'])): ?>
        <script>
            handleRadioClick('image', 'file');
        </script>
    <?php endif; ?>
<?php endif; ?>

<!-- Log kiểm tra dữ liệu, không được xóa -->
<?php
echo '<script>';
echo 'var sessionData = ' . json_encode($_SESSION) . ';';
echo 'console.log("Session Data:", sessionData);';

echo 'var getData = ' . json_encode($_GET) . ';';
echo 'console.log("GET Data:", getData);';

echo 'var postData = ' . json_encode($_POST) . ';';
echo 'console.log("POST Data:", postData);';
echo '</script>';
?>