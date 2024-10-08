// Hàm ẩn hiện thanh nav trái
function ShowNavigation(){
    var sidebar = document.querySelector('.sidebar');
    var navToggle = document.querySelector('.nav-toggle');

    sidebar.style.transform = 'translateX(0)';
    navToggle.style.display = 'none';
}

function HideNavigation(){
    var sidebar = document.querySelector('.sidebar');
    var navToggle = document.querySelector('.nav-toggle');

    sidebar.style.transform = 'translateX(-100%)';
    navToggle.style.display = 'block';
}


// Hàm tương tác hiển thị
let isDivOpen = false;
let id_div_open = "";
let currentDiv = null; 
let class_UI = null;
let listen_checkbox_as_radio = null;

function showChartOption(className, id_name, uiClass, event) {
    event.stopPropagation();  // Ngăn chặn sự kiện click lan lên document
    const layouts = document.querySelectorAll('.' + className.split(' ').join('.'));

    if (isDivOpen && id_div_open !== id_name) {
        currentDiv.classList.remove(class_UI);
        isDivOpen = false;
        id_div_open = "";
        currentDiv = null;
        class_UI = null;
    }

    layouts.forEach(function(layout) {
        if (id_div_open === id_name && layout.classList.contains('show')) {
            layout.classList.remove(uiClass);
            isDivOpen = false;
            id_div_open = "";
            currentDiv = null;
            class_UI = null;
        } else if (!isDivOpen) {
            layout.classList.add(uiClass);
            isDivOpen = true;
            id_div_open = id_name;
            currentDiv = layout;
            class_UI = uiClass;
        }
    });
}

function closeDiv() {
    if (isDivOpen && currentDiv) {
        currentDiv.classList.remove(this.class_UI);
        isDivOpen = false;
        id_div_open = "";
        currentDiv = null;
        this.class_UI = null;
        if()
    }
}

document.addEventListener('click', function(event) {
    if (currentDiv && !currentDiv.contains(event.target)) {
        closeDiv.call({ class_UI: class_UI });
    }
});

let form_temp_show = null;
function GiveForm(temp){
    form_temp_show = temp;
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Enter' && isDivOpen && currentDiv) {
        console.log("Class List of currentDiv:", currentDiv.classList);
        console.log("isDivOpen:", isDivOpen);
        console.log("currentDiv:", currentDiv);
        event.preventDefault();
        event.stopPropagation();
        
        if (!currentDiv.classList.contains('notification')) {
            const form = document.getElementById(form_temp_show);
            if (form) {
                form.submit();
            }
        }
    }
});


// Đóng div khi nhấn nút 'Đóng' bên trong div
// document.querySelectorAll('.close-btn').forEach(function(button) {
//     button.addEventListener('click', function(event) {
//         event.stopPropagation();  // Ngăn sự kiện này lan đến document
//         const parentDiv = button.closest('.chart-option');
//         if (parentDiv) {
//             console.log('Close button clicked, closing div');  // Kiểm tra khi nhấn vào nút đóng
//             parentDiv.classList.remove('show');
//             isDivOpen = false;
//             id_div_open = "";
//             currentDiv = null;
//         }
//     });
// });

// Lắng nghe sự kiện click trên các nút radio
function handleCheckboxClick(arr) {
    document.querySelectorAll('input[type="checkbox"][name="'+ arr + '"]').forEach(checkbox => {
        checkbox.addEventListener('click', function() {
            // Nếu checkbox đã được chọn
            if (this.checked) {
                // Bỏ chọn tất cả các checkbox khác trong nhóm
                document.querySelectorAll('input[type="checkbox"][name="'+ arr +'"]').forEach(otherCheckbox => {
                    if (otherCheckbox !== this) {
                        otherCheckbox.checked = false; // Bỏ chọn checkbox khác
                    }
                });
            }
            
            console.log('Checkbox clicked:', this.value);
        });
    });
}

// Tương tác nút thông báo
function NotificationButtonControll(isInfo){
    var list_button = document.querySelector('.list_group');
    var info_button = document.querySelector('.info_group');

    if(isInfo){
        list_button.style.display = 'none';
        info_button.style.display = 'block';
    }else{
        list_button.style.display = 'block';
        info_button.style.display = 'none';
    }
}

function loadNotifications(request) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../php_control/backend/notification_manager.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.send('request=' + encodeURIComponent(request));
}

document.addEventListener('DOMContentLoaded', (event) => {
    loadNotifications(null);
});

//Nút bỏ chọn checkbox
function uncheckAllCheckboxes(divId) {
    var checkboxes = document.querySelectorAll('#' + divId + ' input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = false;
    });
}