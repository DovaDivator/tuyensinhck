function loadTuyenSinh() {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../php_control/data/tuyen_sinh.php', true);
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

function renderCoursesTuyenSinh(courses, role) {
    var tbody = document.getElementById('course_table_tuyen_sinh');
    tbody.innerHTML = '';

    if (courses.length === 0) {
        renderError('Hiện tại chưa có đăng ký mới nào, vui lòng quay lại sau!');
    } else {
        courses.forEach(function(course) {
            var row = document.createElement('tr');
            row.title = 'Ấn vào để xem thông tin chi tiết';
            row.innerHTML = `
                <td>${course.nganh_id}</td>
                <td>${course.ten_nganh}</td>
                ${role !== 'Student' ? `<td class="number_td">${course.sl_dang_ky}</td>` : ''}
                <td>${course.id_tohop}</td>
                <td>${course.date_end}</td>
            `;

            // Gắn sự kiện click cho mỗi hàng để chuyển đến trang chi tiết
            row.addEventListener('click', function() {
                window.location.href = `chi-tiet-tuyen-sinh.php?ma_nganh=${course.nganh_id}
                                        &ten_nganh=${course.ten_nganh}&chi_tieu=${course.chi_tieu}&
                                        tohop=${course.id_tohop}&ctdt=${course.chuong_trinh}
                                        &deadline=${course.date_end}&sldk=${course.sl_dang_ky}
                                        &diemchuan=${course.diem_chuan}&tengv=${course.ten_giao_vien}
                                        `;
            });

            tbody.appendChild(row);
        });
    }
}


function renderError(message) {
    var tbody = document.getElementById('course_table_tuyen_sinh');
    tbody.innerHTML = '';

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