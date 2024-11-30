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

function loadListNganh() {
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

function loadgiaovien() {
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

        xhr.send(`action=${encodeURIComponent('qlnd')}`);
    });
}

function loadsinhvien() {
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

        xhr.send(`action=${encodeURIComponent('qlnd')}`);
    });
}

function renderCoursesTuyenSinh(jsonData, role) {
    console.log("Dữ liệu ban đầu:", jsonData);

    // Parse dữ liệu nếu là chuỗi JSON
    if (typeof jsonData === "string") {
        try {
            jsonData = JSON.parse(jsonData);
        } catch (e) {
            console.error("Dữ liệu JSON không hợp lệ:", e);
            renderError("Dữ liệu không hợp lệ, vui lòng thử lại sau!", "course_table_tuyen_sinh", "top_tuyen_sinh");
            return;
        }
    }

    // Đưa dữ liệu về dạng mảng nếu là object
    let courses = Array.isArray(jsonData) ? jsonData : [jsonData];

    // Kiểm tra nếu không có dữ liệu
    if (!courses || courses.length === 0) {
        renderError("Hiện tại chưa có đăng ký mới nào, vui lòng quay lại sau!", "course_table_tuyen_sinh", "top_tuyen_sinh");
        return;
    }

    var tbody = document.getElementById('course_table_tuyen_sinh');
    tbody.innerHTML = '';

    // Duyệt qua danh sách courses
    courses.forEach(function(course) {
        var row = document.createElement('tr');
        row.title = 'Ấn vào để xem thông tin chi tiết';

        // Cấu trúc HTML của từng dòng
        const statusMap = {
            0: { text: 'Đang ẩn', color: 'gray' },
            1: { text: 'Sắp mở', color: 'blue' },
            2: { text: 'Đang mở', color: 'green' },
            3: { text: 'Đã đóng', color: 'red' }
        };
        const { text: statusText, color: statusColor } = statusMap[course.isenable] || { text: 'Không xác định', color: 'black' };
        
        // Tạo HTML cho hàng
        row.innerHTML = `
            <td>${course.id}</td>
            <td>${course.ten}</td>
            ${role === 'Admin' ? `<td class="status_td" style="color: ${statusColor}; text-align: center;">${statusText}</td>` : ''}
            ${role !== 'Student' ? `<td class="number_td">${course.slsv}</td>` : ''}
            <td>${course.tohop}</td>
            <td>${course.date_end}</td>
        `;

        // Gắn sự kiện click cho mỗi hàng để chuyển đến trang chi tiết
        row.addEventListener('click', function() {
            window.location.href = `chi-tiet-tuyen-sinh.php?ma_nganh=${course.id}`;
        });

        tbody.appendChild(row);
    });
}

function renderCoursesLN(jsonData) {
    console.log("Dữ liệu ban đầu:", jsonData);

    // Parse dữ liệu nếu là chuỗi JSON
    if (typeof jsonData === "string") {
        try {
            jsonData = JSON.parse(jsonData);
        } catch (e) {
            console.error("Dữ liệu JSON không hợp lệ:", e);
            renderErrorGV("Dữ liệu không hợp lệ, vui lòng thử lại sau!", "course_table_list_nganh", "top_list_nganh");
            return;
        }
    }

    // Đưa dữ liệu về dạng mảng nếu là object
    let courses = Array.isArray(jsonData) ? jsonData : [jsonData];

    // Kiểm tra nếu không có dữ liệu
    if (!courses || courses.length === 0) {
        renderErrorLN("Không có danh sách ngành", "course_table_list_nganh", "top_list_nganh");
        return;
    }

    var tbody = document.getElementById('course_table_list_nganh');
    tbody.innerHTML = '';

    // Duyệt qua danh sách courses
    courses.forEach(function(course) {
        var row = document.createElement('tr');
        row.title = 'Ấn vào để xem thông tin chi tiết';
        row.innerHTML = `
            <td>${course.id}</td>
            <td>${course.ten}</td>
            <td>${course.to_hop}</td>
             <td>${course.trang_thai}</td>
        `;    
        //            
        // Gắn sự kiện click cho mỗi hàng để chuyển đến trang chi tiết
        row.addEventListener('click', function() {
        //    window.location.href = `chi-tiet-tuyen-sinh.php?ma_nganh=${course.id}`;
        });

        tbody.appendChild(row);
    });    
        
   
}

function renderCoursesGV(jsonData) {
    console.log("Dữ liệu ban đầu:", jsonData);

    // Parse dữ liệu nếu là chuỗi JSON
    if (typeof jsonData === "string") {
        try {
            jsonData = JSON.parse(jsonData);
        } catch (e) {
            console.error("Dữ liệu JSON không hợp lệ:", e);
            renderErrorGV("Dữ liệu không hợp lệ, vui lòng thử lại sau!", "body_danh_sach_giao_vien", "danh_sach_giao_vien");
            return;
        }
    }

    // Đưa dữ liệu về dạng mảng nếu là object
    let courses = Array.isArray(jsonData) ? jsonData : [jsonData];

    // Kiểm tra nếu không có dữ liệu
    if (!courses || courses.length === 0) {
        renderErrorGV("Không có giáo viên", "body_danh_sach_giao_vien", "danh_sach_giao_vien");
        return;
    }

    var tbody = document.getElementById('body_danh_sach_giao_vien');
    tbody.innerHTML = '';

    // Duyệt qua danh sách courses
    courses.forEach(function(course) {
        var row = document.createElement('tr');
        row.title = 'Ấn vào để xem thông tin chi tiết';
        row.innerHTML = `
            <td>${course.id}</td>
            <td>${course.ten}</td>
            <td>${course.khoa}</td>
             <td>${course.list_nganh}</td>
        `;  
        //            
        // Gắn sự kiện click cho mỗi hàng để chuyển đến trang chi tiết
        row.addEventListener('click', function() {
            window.location.href = `CTHS.php?ma_gv=${encodeURIComponent(course.id)}&rolecheck=${encodeURIComponent('gv')}`;
        });

        tbody.appendChild(row);
    });    
        
   
}

function renderCoursesSV(jsonData) {
    console.log("Dữ liệu ban đầu:", jsonData);

    // Parse dữ liệu nếu là chuỗi JSON
    if (typeof jsonData === "string") {
        try {
            jsonData = JSON.parse(jsonData);
        } catch (e) {
            console.error("Dữ liệu JSON không hợp lệ:", e);
            renderErrorGV("Dữ liệu không hợp lệ, vui lòng thử lại sau!", "course_table_dssv", "danh_sach_sinh_vien");
            return;
        }
    }

    // Đưa dữ liệu về dạng mảng nếu là object
    let courses = Array.isArray(jsonData) ? jsonData : [jsonData];

    // Kiểm tra nếu không có dữ liệu
    if (!courses || courses.length === 0) {
        renderErrorSV("Không có sinh viên", "course_table_dssv", "danh_sach_sinh_vien");
        return;
    }

    var tbody = document.getElementById('course_table_dssv');
    tbody.innerHTML = '';

    // Duyệt qua danh sách courses
    courses.forEach(function(course) {
        var row = document.createElement('tr');
        row.title = 'Ấn vào để xem thông tin chi tiết';
        row.innerHTML = `
        <td>${course.id}</td>
        <td>${course.ten}</td>
        <td>${course.create_date}</td>
        <td style="color: ${course.htts_id ? 'inherit' : 'red'};">
            ${course.htts_id ?? 'Không có'}
        </td>
        <td style="color: ${course.nganh_id ? 'inherit' : 'red'};">
            ${course.nganh_id ?? 'Không có'}
        </td>
        <td>${getTrangThai(course.trang_thai)}</td>
    `;
        //            
        // Gắn sự kiện click cho mỗi hàng để chuyển đến trang chi tiết
        row.addEventListener('click', function() {
            window.location.href = `CTHS.php?masv=${(course.id)}&rolecheck=${encodeURIComponent('sv')}`;
        });

        tbody.appendChild(row);
    });  
}

function getTrangThai(trangThai) {
    switch (trangThai) {
        case 1:
            return "<font color='red'>Chưa đăng ký hồ sơ</font>";
        case 2:
            return "<font color='orange'>Đang chờ xét duyệt hồ sơ</font>";
        case 3:
            return "<font color='red'>Yêu cầu chỉnh sửa lại hồ sơ</font>";
        case 4:
            return "<font color='yellow'>Đã xác thực hồ sơ, chưa chọn ngành</font>";
        case 5:
            return "<font color='yellow'>Đang chờ xác nhận đăng ký ngành</font>";
        case 6:
            return "<font color='green'>Đã đăng ký thành công</font>";
        default:
            return "<font color='red'>Không xác định</font>";
    }
}


function renderError(message, tbody_id, table_id) {
    var tbody = document.getElementById(tbody_id);
    var table = document.getElementById(table_id);
    tbody.innerHTML = '';
    table.style.height = 'fit-content';

    var row = document.createElement('tr');
    row.className = 'error_tdtable';

    var table = document.getElementById('top_tuyen_sinh');
    var columnCount = table.rows[0].cells.length;

    row.innerHTML = `
        <td colspan="${columnCount}">${message}</td>
    `;
    tbody.appendChild(row);
}

function renderErrorLN(message, tbody_id, table_id) {
    var tbody = document.getElementById(tbody_id);
    var table = document.getElementById(table_id);
    tbody.innerHTML = '';
    table.style.height = 'fit-content';

    var row = document.createElement('tr');
    row.className = 'error_tdtable';

    var table = document.getElementById('top_list_nganh');
    var columnCount = table.rows[0].cells.length;

    row.innerHTML = `
        <td colspan="${columnCount}">${message}</td>
    `;
    tbody.appendChild(row);
}

function renderErrorGV(message, tbody_id, table_id) {
    var tbody = document.getElementById(tbody_id);
    var table = document.getElementById(table_id);
    tbody.innerHTML = '';
    table.style.height = 'fit-content';

    var row = document.createElement('tr');
    row.className = 'error_tdtable';

    var table = document.getElementById('danh_sach_giao_vien');
    var columnCount = table.rows[0].cells.length;

    row.innerHTML = `
        <td colspan="${columnCount}">${message}</td>
    `;
    tbody.appendChild(row);
}

function renderErrorSV(message) {
    var tbody = document.getElementById(tbody_id);
    var table = document.getElementById(table_id);
    tbody.innerHTML = '';
    table.style.height = 'fit-content';

    var row = document.createElement('tr');
    row.className = 'error_tdtable';

    var table = document.getElementById('danh_sach_sinh_vien');
    var columnCount = table.rows[0].cells.length;

    row.innerHTML = `
        <td colspan="${columnCount}">${message}</td>
    `;
    tbody.appendChild(row);
}

function IsEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (emailRegex.test(email)) {
        return true;
    } else {
        return false;
    }
}