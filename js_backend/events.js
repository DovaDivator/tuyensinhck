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

