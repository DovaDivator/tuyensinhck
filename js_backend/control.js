function loadTuyenSinh() {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../php_control/data/ds_tuyen_sinh.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onload = function() {
            if (xhr.status === 200) {
                var courses = JSON.parse(xhr.responseText);
                resolve(courses);
            }else if (xhr.status === 400){
                var error = JSON.parse(xhr.responseText);
                reject(new Error(error.error));
            } else {
                reject(new Error('Không thể tải dữ liệu tuyển sinh'));
            }
        };

        xhr.onerror = function() {
            reject(new Error('Lỗi mạng khi tải dữ liệu'));
        };

        xhr.send(`action=${encodeURIComponent('index')}`);
    });
}

function renderCoursesTuyenSinh(courses, role) {
    var tbody = document.getElementById('course_table_tuyen_sinh');
    tbody.innerHTML = '';

    if (courses.length === 0) {
        renderError('Hiện tại chưa có đăng ký mới nào, vui lòng quay lại sau!');
    } else {
        console.log(courses);
        courses.forEach(function(course) {
            var row = document.createElement('tr');
            row.title = 'Ấn vào để xem thông tin chi tiết';
            row.innerHTML = `
                <td>${course.id}</td>
                <td>${course.ten}</td>
                ${role === 'Admin' ? `<td class="status_td" style="color: ${course.isenable ? 'green' : 'red'}; text-align: center;">${course.isenable ? 'Hiện' : 'Ẩn'}</td>` : ''}
                ${role !== 'Student' ? `<td class="number_td">${course.slsv}</td>` : ''}
                <td>${course.tohop}</td>
                <td>${course.date_end}</td>
            `;

            // Gắn sự kiện click cho mỗi hàng để chuyển đến trang chi tiết
            row.addEventListener('click', function() {
                window.location.href = `chi-tiet-tuyen-sinh.php?ma_nganh=${course.nganh_id}`;
            });

            tbody.appendChild(row);
        });
    }
}


function renderError(message) {
    var tbody = document.getElementById('course_table_tuyen_sinh');
    var table = document.getElementsByClassName('table_body_scroll');
    tbody.innerHTML = '';
    table[0].style.height = 'fit-content';

    var row = document.createElement('tr');
    row.className = 'error_tdtable';

    var table = document.getElementById('top_tuyen_sinh');
    var columnCount = table.rows[0].cells.length;

    row.innerHTML = `
        <td colspan="${columnCount}">${message}</td>
    `;
    tbody.appendChild(row);
}

function loadAndRenderCourses(role) {
    loadTuyenSinh().then(function(courses) {
        renderCoursesTuyenSinh(courses, role);
    }).catch(function(error) {
        renderError('Không thể tải dữ liệu: '+ error.message);
    }).finally(function() {

    });
}

function IsEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (emailRegex.test(email)) {
        return true;
    } else {
        return false;
    }
}