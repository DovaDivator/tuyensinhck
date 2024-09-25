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

// Hàm hiển thị/ẩn các layout theo tùy chọn
function showChartOption(className) {
    var layouts = document.querySelectorAll('.' + className.split(' ').join('.'));
    layouts.forEach(function(layout) {
        if (layout.classList.contains('show')) {
            layout.classList.remove('show');
        } else {
            layout.classList.add('show');
        }
    });
}

document.addEventListener('click', function(event) {
    var layouts = document.querySelectorAll('.options.layout');
    layouts.forEach(function(layout) {
        var isClickInside = layout.contains(event.target) || event.target.classList.contains('chart_option');
        
        if (!isClickInside) {
            layout.classList.remove('show');
        }
    });
});

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

const loadNotifications = () => {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../php_control/backend/get_notificatoin.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onload = () => {
        if (xhr.status === 200) {
            document.getElementById('list_noti').innerHTML = xhr.responseText;
            

            // Gán sự kiện click cho từng thông báo sau khi tải xong
            // document.querySelectorAll('.notification').forEach(notification => {
            //     notification.addEventListener('click', function() {
            //         const notificationId = this.getAttribute('data-id');
            //         loadNotificationDetails(notificationId);
            //     });
            // });
            console.log('gắn thành công');
        }else{
            console.log('Error:', xhr.status);
        }
    };

    xhr.send();
};

document.addEventListener('DOMContentLoaded', (event) => {
    loadNotifications(); // Gọi hàm khi tài liệu đã được tải
});
