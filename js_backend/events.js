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

function showChartOption(className, id_name, uiClass, event) {
    event.stopPropagation();  // Ngăn chặn sự kiện click lan lên document
    const layouts = document.querySelectorAll('.' + className.split(' ').join('.'));

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

document.addEventListener('click', function(event) {
    if (isDivOpen && currentDiv && !currentDiv.contains(event.target)) {
        currentDiv.classList.remove(class_UI);
        isDivOpen = false;
        id_div_open = "";
        currentDiv = null;
        class_UI = null;
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



// Hiển thị nút thông báo
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

// Chặn tải lại trang bằng form
// function denyLoadForm(formId) {
//     var form = document.getElementById(formId);

//     form.addEventListener('submit', function(event) {
//         event.preventDefault();
//     });
// }

// Lắng nghe sự kiện DOMContentLoaded để đảm bảo mọi thứ đã tải xong
// document.addEventListener("DOMContentLoaded", function() {
//     // Lấy tất cả các form với class 'notificationForm'
//     const forms = document.querySelectorAll('.notificationForm');
    
//     // Duyệt qua từng form để thêm sự kiện submit qua AJAX
//     forms.forEach(function(form) {
//         form.addEventListener('submit', function(event) {
//             event.preventDefault(); // Ngăn form submit và reload trang

//             // Lấy dữ liệu từ form
//             let formData = new FormData(this);

//             // Gửi dữ liệu qua AJAX
//             fetch('../php_control/path_side/notification.php', {
//                 method: 'POST',
//                 body: formData,
//             })
//             .then(response => response.text())
//             .then(data => {
//                 document.getElementById('notificationLayout').innerHTML = data;
//             })
//             .catch(error => console.error('Error:', error));
//         });
//     });
// });

// Chạy các hàm phương thức

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
