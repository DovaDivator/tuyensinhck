function loadTuyenSinh() {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../php_control/backend/tuyen_sinh.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onload = function() {
            if (xhr.status === 200) {
                var courses = JSON.parse(xhr.responseText);
                resolve(courses);
            } else {
                reject(new Error('Không thể tải dữ liệu tuyển sinh'));
            }
        };

        xhr.onerror = function() {
            reject(new Error('Lỗi mạng khi tải dữ liệu'));
        };

        xhr.send();
    });
}

function renderCoursesTuyenSinh(courses) {
    var tbody = document.getElementById('course-table-body');
    tbody.innerHTML = '';

    if (courses.length === 0) {
        renderError('Hiện tại chưa có đăng ký mới nào, vui lòng quay lại sau!');
    } else {
        courses.forEach(function(course) {
            var row = document.createElement('tr');
            row.innerHTML = `
                <td>${course.ma_tuyen_sinh}</td>
                <td>${course.ten_nganh}</td>
                <td>${course.chi_tieu}</td>
                <td>${course.to_hop_xet_tuyen}</td>
                <td>${course.thoi_gian_tuyen_sinh}</td>
                <td>${course.ghi_chu || ''}</td>
            `;
            tbody.appendChild(row);
        });
    }
}

function renderError(message) {
    var tbody = document.getElementById('course-table-body');
    tbody.innerHTML = '';

    var row = document.createElement('tr');
    row.className = 'error_tdtable'; 
    row.innerHTML = `
        <td colspan="6">${message}</td>
    `;
    tbody.appendChild(row);
}

function loadAndRenderCourses(role) {
    loadTuyenSinh().then(function(courses) {
        renderCoursesTuyenSinh(courses, role);
    }).catch(function(error) {
        renderError('Không thể tải dữ liệu: '+ error.message);
    }).finally(function() {
        if (role === 'Admin') {
            ShowTuyenSinhManagerBtn();
        }
    });
}

function ShowTuyenSinhManagerBtn() {
    var tbody = document.getElementById('course-table-body');

    var rowButton = document.createElement('tr');
    rowButton.innerHTML = `
        <td colspan="6" style="text-align: center; cursor: pointer; color: blue; text-decoration: underline;" onclick="window.location.href='/admin/dashboard'">
            <b>&gt;&nbsp;Đi đến trang điều hướng&nbsp;&lt;</b>
        </td>
    `;

    tbody.appendChild(rowButton);
}

