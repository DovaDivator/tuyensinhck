// Hiển thị mặc định
var isClicked = false;
var list_group = document.getElementById('list_group');
var info_group = document.getElementById('info_group');
var list_noti = document.getElementById('list_noti');
var info_noti = document.getElementById('info_noti');

function loadUINotifications(){
    if(!isClicked){
        loadUIListNotifications();
        isClicked = true;
    }else{
        isClicked = false;
    }
}

function loadUIListNotifications(request) {

    list_group.style.display = 'block';
    list_noti.style.display = 'block';
    info_group.style.display = 'none';
    info_noti.style.display = 'none';

    loadNotifications(request);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../php_control/backend/notification_show_list.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('list_noti').innerHTML = xhr.responseText;
        } else {
            console.log('Error:', xhr.status);
        }
    };

    xhr.send();
}

function loadUIDetailNotification(notification_id) {
    
    document.getElementById('list_group').style.display = 'none';
    document.getElementById('list_noti').style.display = 'none';
    document.getElementById('info_group').style.display = 'block';
    document.getElementById('info_noti').style.display = 'block';

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../php_control/backend/notification_show_detail.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onload = function() {
        if (xhr.status === 200) {
            if(xhr.responseText != ""){
                document.getElementById('info_noti').innerHTML = xhr.responseText;
            }else{
                alert('Không thể xác nhận tin nhắn!');
                setTimeout(loadUIListNotifications, 50); 
            }   
        } else {
            console.log('Error:', xhr.status);
        }
    };

    xhr.send('notification_id=' + encodeURIComponent(notification_id));
}



