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
