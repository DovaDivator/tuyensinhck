// Hiển thị mặc định
var list_group = document.getElementById('list_group');
var info_group = document.getElementById('info_group');
var list_noti = document.getElementById('list_noti');
var info_noti = document.getElementById('info_noti');

list_group.style.display = 'block';
list_noti.style.display = 'block';
info_group.style.display = 'none';
info_noti.style.display = 'none';

const loadNotifications = () => {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../php_control/backend/get_notificatoin.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onload = () => {
        if (xhr.status === 200) {
            document.getElementById('list_noti').innerHTML = xhr.responseText;
        }else{
            console.log('Error:', xhr.status);
        }
    };

    xhr.send();
};

document.addEventListener('DOMContentLoaded', (event) => {
    loadNotifications();
});

