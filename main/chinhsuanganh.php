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

include("../php_control/data/db_connect.php");
function GetToHop(){
    global $pdo;

    $sql = "SELECT * FROM get_to_hop()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}



function GetMonThi(){
    $mon_thi_option = '';
    

    // foreach ($result as $row) {
    //     $id = htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8');
    //     $ky_thi = htmlspecialchars($row['ky_thi'], ENT_QUOTES, 'UTF-8');
    //     $mon_thi_option .= "<option value='{$id}'>{$id} ({$ky_thi})</option>";
    // }
    return $mon_thi_option;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Tuyển sinh - Thống kê số liệu</title>
    <link rel="icon" href="../assets/images/logo.png?v=<?php echo filemtime('../assets/images/logo.png'); ?>" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css?v=<?php echo filemtime('../assets/style/style.css'); ?>">
    <link rel="stylesheet" href="../assets/style/admin_path.css?v=<?php echo filemtime("../assets/style/admin_path.css")?>">
    <link rel="stylesheet" href="../assets/style/taikhoan.css?v=<?php echo filemtime('../assets/style/taikhoan.css'); ?>">
    <script src="../js_backend/events.js?v=<?php echo filemtime('../js_backend/events.js'); ?>"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
    
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
                                        if(isset($_GET['ma_nganh'])){
                                            echo "Chỉnh sửa chuyên ngành";
                                        }else{
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
                                        <input type="text" id="id_nganh" name="id_nganh" placeholder="Tối đa 10 ký tự" maxlength="10" style="margin-bottom: 0; width: 120px;"
                                            <?php
                                                if(isset($_GET['ma_nganh'])){
                                                    echo " disabled";
                                                }
                                            ?>
                                        >
                                    </div>
                                    <p class="note_input">Mã ngành là cố định và sẽ không thể thay đổi sau khi tạo</p>
                                            

                                    <label for="ten">
                                        <font color="red">*</font>&nbsp;Tên chuyên ngành:
                                    </label>
                                    <input type="text" id="ten" name="ten" placeholder="Không được để trống" value="<?php echo ''; ?>">

                                    <div class="linediv" style="margin-top: 15px;">
                                        <label for="chi_tieu" style="margin-bottom: 0; margin-right: 10px">
                                            <font color="red">*</font>&nbsp;Chỉ tiêu:
                                        </label>
                                        <input type="number" id="chi_tieu" name="chi_tieu" min="1" step="1" style="margin-bottom: 0; width: 120px;"
                                            <?php
                                                if(isset($_GET['ma_nganh'])){
                                                    echo "";
                                                }
                                            ?>
                                        >
                                    </div>


                                    <label for="to_hop">
                                        <font color="red">*</font>&nbsp;Tổ hợp:
                                    </label>
                                    <input type="text" id="to_hop" name="to_hop" readonly placeholder="Chọn tổ hợp bạn muốn thêm">
                                    <div class="dropdown_container">
                                    <div class="dropdown" id="dropdown_to_hop" style='top: -10px;'>
                                        <input type="text" id="searchInput" placeholder="Tìm kiếm..." class="dropdown-search">
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
                                        <input type="text" id="date_open_day" name="date_open_day" placeholder="dd/mm/yyyy" style="width: 150px; margin-right: 10px" readonly>
                                        <input type="text" id="date_open_time" name="date_open_time" placeholder="hh:mm" style="width: 100px;" readonly>
                                    </div>    
                                    <p class="note_input">Bạn không thể thay đổi thời gian khi tín chỉ đã mở</p>
                                    
                                    <label><font color="red">*&nbsp;</font>Ngày đóng tín chỉ: </label>
                                    <div class="linediv" style="margin-bottom: 0;">
                                        <input type="text" id="date_end_day" name="date_end_day" placeholder="dd/mm/yyyy" style="width: 150px; margin-right: 10px" readonly>
                                        <input type="text" id="date_end_time" name="date_end_time" placeholder="hh:mm" style="width: 100px;" readonly>
                                    </div>     

                                    <div class="linediv" style="margin-top: 15px;">
                                        <label for="diem_chuan" style="margin-bottom: 0; margin-right: 10px">
                                            <font color="red">*</font>&nbsp;Điểm chuẩn:
                                        </label>
                                        <input type="number" id="diem_chuan" name="diem_chuan" min="0" step="1"  style="margin-bottom: 0; width: 120px;"
                                            <?php
                                                if(isset($_GET['ma_nganh'])){
                                                    echo "";
                                                }
                                            ?>
                                        >
                                    </div>

                                    <div class="linediv" style="margin-top: 15px;">
                                        <label>Ghi chú:</label>
                                        <button type="button" onclick="addNote()" style="margin-left: 10px; margin-bottom: 10px">+</button>
                                    </div>
                                    <div id="ghi_chu_ele">
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

                                    <label for="mo_ta">Mô tả:</label>    
                                    <textarea 
                                        id="mo_ta" 
                                        name="mo_ta" 
                                        placeholder="Viết tối đa 5000 ký tự" 
                                        maxlength="5000"
                                        style="width: 350px; height: 150px;"></textarea>    
                                    
                                    <label for="phuong_tien">Phương tiện:</label>   
                                    <div style='display:grid; grid-template-columns: repeat(2, 1fr); margin-right: 25px;'>
                                        <label style="margin:0;"><input type="radio" name="phuong_tien" value="media" onclick="handleRadioClick(this, 'url')"> Video URL</label>
                                        <label style="margin:0;"><input type="radio" name="Phuong_tien" value="image" onclick="handleRadioClick(this, 'file')"> Tải ảnh</label>
                                    </div>
                                    <div style='height: 15px'></div>
                                    <input tyle="text" id="url" name="url" style="width: 100%; display: none;" placeholder="Điền link nhúng vào">
                                    <input type="file" id="file_temp" style="width: 100%; display: none;" name="file_temp">

                                    <div class="chu_thich_hold" style="display:none; margin-top: 10px;">
                                    <label for="chu_thich">
                                        <font color="red">*</font>&nbsp;Chú thích:
                                    </label>
                                    <input type="text" id="chu_thich" name="chu_thich" style="width: 100%;" placeholder="Thêm chú thích">
                                    </div>

                                    <div class="linediv" style="margin-bottom: 10px;">
                                        <input type="checkbox" name="enable" id="enable">
                                        <label for="enable">Hiển thị chuyên ngành đăng ký?</label>
                                    </div>

                                    <button type="submit" class="custom-button" style="width: 100%; margin-top: 20px;" onclick="UpdateNganh(
                                        <?php echo isset($_GET['ma_nganh']) ? $_GET['ma_nganh'] : null; ?>
                                    )">Cập nhật thông tin</button>
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
        const textInput = document.getElementById('to_hop');
        const dropdown = document.getElementById('dropdown_to_hop');
        let list_mon;

        // Hiển thị danh sách khi click vào input
        textInput.addEventListener('click', () => {
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });

        // Thêm lựa chọn khi click vào dropdown
        dropdown.addEventListener('click', (e) => {
            if (e.target.tagName === 'DIV') {
                const selectedOptionId = e.target.getAttribute('data-id'); // Lấy giá trị id từ thuộc tính data-id
                const selectedOptionText = e.target.textContent; // Lấy text hiển thị (nếu cần)
            
                    // Gán giá trị id vào textInput (tránh trùng lặp)
                if (!textInput.value.includes(selectedOptionId)) {
                    textInput.value += textInput.value ? `, ${selectedOptionId}` : selectedOptionId;

                    const xhr2 = new XMLHttpRequest();
                    xhr2.open("POST", "../php_control/data/get_list_mon.php", true);
                    xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr2.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                    xhr2.onload = function () {
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

                    xhr2.send( `list=${encodeURIComponent(textInput.value)}` );
                }
            
                dropdown.style.display = 'none'; // Ẩn dropdown sau khi chọn
            }
        });

        // Xóa lựa chọn bằng phím Backspace hoặc Delete
        textInput.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' || e.key === 'Delete') {
                const values = textInput.value.split(', ');
                values.pop(); // Xóa lựa chọn cuối cùng
                textInput.value = values.join(', ');
                e.preventDefault(); // Ngăn người dùng xóa bằng cách thông thường
            }
        });

        // Ẩn dropdown khi click bên ngoài
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target) && e.target !== textInput) {
                dropdown.style.display = 'none';
            }
        });

        $(function () {

            $("#date_open_day, #date_end_day").datepicker({
                dateFormat: "dd/mm/yy",  
                changeMonth: true,       
                changeYear: true,       
                yearRange: "-100:+0",    
                maxDate: 0           
            });

            $("#date_open_time, #date_end_time").timepicker({
                timeFormat: 'HH:mm',
                interval: 5,    
                minTime: '00:00',     
                maxTime: '23:55',  
                dynamic: false,        
                dropdown: true,        
                scrollbar: false,      
                controlType: 'select' 
            });
        });

        let lastCheckedRadio = null; // Biến lưu radio đang được chọn

        function handleRadioClick(radio, type) {
            const urlInput = document.getElementById("url");
            const fileInput = document.getElementById("file_temp");
            const note = document.getElementById("chu_thich");
            const note_div = document.getElementsByClassName("chu_thich_hold");
        
            // Nếu radio được nhấn lại (bỏ tick)
            if (lastCheckedRadio === radio) {
               radio.checked = false; // Bỏ tick
                lastCheckedRadio = null; // Reset trạng thái
                urlInput.style.display = "none";
                fileInput.style.display = "none";
                note.value = "";
                note_div[0].style.display = "none";
            } else {
               // Cập nhật radio mới được chọn
                lastCheckedRadio = radio;
            
                if (type === "url") {
                    urlInput.style.display = "block";
                    fileInput.style.display = "none";
                } else if (type === "file") {
                    urlInput.style.display = "none";
                    fileInput.style.display = "block";
                }
                note_div[0].style.display = "block";
            }
        }
    </script>


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