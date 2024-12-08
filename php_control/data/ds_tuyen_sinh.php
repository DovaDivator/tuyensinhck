<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db_connect.php';

function getDSTuyenSinh($query)
{
    $condition = getConditionNganh($query);

    switch ($_SESSION['user']['role']) {
        case 'Student':
            $courses = fetchNganhSV($condition);
            break;
        case 'Teacher':
            $courses = fetchNganhGV($condition);
            break;
        case 'Admin':
            $courses = fetchNganhAD($condition);
            break;
        default:
            return "Vai trò không hợp lệ!";
    }

    foreach ($courses as &$course) {
        if (isset($course['date_end'])) {
            $course['date_end'] = (new DateTime(substr($course['date_end'], 0, 19)))->format('d/m/Y');
        }
    }
    return $courses;
}

function getDSGV($query)
{
    global $pdo;
    $condition = getConditionDSGV($query);
    $query_input = "
    SELECT 
        CAST(gv.gv_id AS CHAR) AS id,
        CAST(gv.ten AS CHAR) AS ten,
        gv.khoa,
        GROUP_CONCAT(ng.nganh_id SEPARATOR ', ') AS list_nganh
    FROM 
        giao_vien gv
    LEFT JOIN 
        nganh ng ON gv.gv_id = ng.gv_id";
    if ($condition !== '') {
        $query_input .= " WHERE " . $condition;
    }
    $query_input .= "
    GROUP BY 
        gv.gv_id, gv.ten, gv.khoa";

    $stmt = $pdo->prepare($query_input);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $courses;
}

function getDSSV($query)
{
    global $pdo;
    $condition = getConditionDSSV($query);
    $query_input = "
    SELECT 
        CAST(sv.stu_id AS CHAR) AS id,
        sv.ten,
        CAST(ur.create_at as DATETIME) AS create_date,
        CAST(sv.ma_htts AS CHAR) AS htts_id,
        CAST(sv.nganh_id AS CHAR) AS nganh_id,
        ur.trang_thai
    FROM 
        sinh_vien sv
    JOIN 
        `user` ur
    ON 
        sv.stu_id = ur.id_user";

    if ($condition !== '') {
        $query_input .= " WHERE " . $condition;
    }
    $query_input .= ";";
    $stmt = $pdo->prepare($query_input);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($courses as &$course) {
        if (isset($course['create_date'])) {
            $course['create_date'] = (new DateTime(substr($course['create_date'], 0, 19)))->format('(H\hi) d/m/Y');
        }
    }
    return $courses;
}

function getSVtheonganh($query)
{
    global $pdo;

    // Tạo câu lệnh SQL chính
    $query_input = "
    SELECT 
        CAST(sv.stu_id AS CHAR) AS id,
        sv.ten,
        CAST(ur.create_at AS DATETIME) AS create_date,
        CAST(sv.ma_htts AS CHAR) AS htts_id,
        CAST(sv.nganh_id AS CHAR) AS nganh_id,
        ur.trang_thai
    FROM 
        sinh_vien sv
    JOIN 
        `user` ur ON sv.stu_id = ur.id_user
    JOIN 
        nganh ON sv.nganh_id = nganh.nganh_id";

    // Thêm điều kiện lọc nếu có
    $condition = getConditionSV($query);
    if ($condition !== '') {
        $query_input .= " WHERE " . $condition;
    }

    // Chuẩn bị và thực thi câu lệnh SQL
    $stmt = $pdo->prepare($query_input);
    if ($query !== '') {
        $stmt->bindValue(':query', "%$query%");
    }
    $stmt->execute();

    // Lấy kết quả
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Định dạng lại create_date
    foreach ($courses as &$course) {
        if (!empty($course['create_date'])) {
            $course['create_date'] = (new DateTime(substr($course['create_date'], 0, 19)))->format('(H\hi) d/m/Y');
        }
    }

    return $courses;
}

// Hàm tạo điều kiện lọc với prepared statement
function getConditionSV($query)
{
    if ($query !== '') {
        return "nganh.nganh_id LIKE :query COLLATE utf8_general_ci";
    }
    return '';
}


function fetachListNganhUser()
{
    global $pdo;
    $query = "SELECT 
    CAST(ng.nganh_id AS CHAR) AS id, 
    CAST(ng.ten_nganh AS CHAR) AS ten, 
    CAST(ng.id_tohop AS CHAR) AS to_hop, 
    CASE
        WHEN CURRENT_DATE BETWEEN ng.date_open AND ng.date_end THEN 'đang mở'
        WHEN CURRENT_DATE < ng.date_open THEN 'sắp mở'                    
        WHEN CURRENT_DATE > ng.date_end THEN 'đã đóng'               
        ELSE 0                                                       
    END AS trang_thai
FROM 
    nganh ng
WHERE 
    ng.isenable = 1; -- Chỉ các bản ghi có isenable = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($courses as &$course) {
        if (isset($course['create_date'])) {
            $course['create_date'] = (new DateTime(substr($course['create_date'], 0, 19)))->format('(H\hi) d/m/Y');
        }
    }
    return $courses;
}

function fetchNganhSV($condition)
{
    global $pdo;
    $query = "
    SELECT 
        CAST(ng.nganh_id AS CHAR) AS id,
        ng.ten_nganh AS ten,
        ng.id_tohop AS tohop,
        CAST(ng.date_end AS DATETIME) AS date_end
    FROM nganh ng
    WHERE ng.date_open < NOW() 
      AND ng.date_end > NOW() 
      AND ng.isEnable = 1
    ";
    if ($condition !== '') {
        $query .= " AND " . $condition;
    }
    $query .= ";";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Hàm lấy dữ liệu từ bảng nganh
function fetchNganhGV($condition)
{
    global $pdo;
    $query = "
    SELECT 
        ng.nganh_id AS id,
        ng.ten_nganh AS ten,
        CAST(ng.id_tohop AS CHAR) AS tohop,
        CAST(ng.date_end AS DATETIME) AS date_end,
        COUNT(sv.nganh_id) AS slsv
    FROM nganh ng
    LEFT JOIN sinh_vien sv ON ng.nganh_id = sv.nganh_id  
    WHERE ng.isEnable 
      AND CAST(ng.gv_id AS CHAR) = :id ";

    if ($condition !== '') {
        $query .= " AND " . $condition;
    }

    $query .= "
    GROUP BY ng.nganh_id, ng.ten_nganh, ng.id_tohop, ng.date_end;
";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $_SESSION['user']['id']);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchNganhAD($condition)
{
    global $pdo;
    $query = "
    SELECT 
        ng.nganh_id AS id,
        ng.ten_nganh AS ten,
        CASE 
            WHEN ng.isenable = FALSE THEN 0
            WHEN NOW() < ng.date_open THEN 1
            WHEN NOW() BETWEEN ng.date_open AND ng.date_end THEN 2
            WHEN NOW() > ng.date_end THEN 3
        END AS isenable,
        ng.id_tohop AS tohop,
        CAST(ng.date_end AS DATETIME) AS date_end, 
        COUNT(sv.nganh_id) AS slsv
    FROM nganh ng
    LEFT JOIN sinh_vien sv ON ng.nganh_id = sv.nganh_id
";
    if ($condition !== '') {
        $query .= " WHERE " . $condition;
    }
    $query .= " GROUP BY ng.nganh_id, ng.ten_nganh, ng.isenable, ng.id_tohop, ng.date_open, ng.date_end;";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getConditionNganh($query)
{
    $condition = '';

    if ($query != '') {
        $condition .= "(ng.nganh_id LIKE '%$query%' COLLATE utf8_general_ci OR ng.ten_nganh LIKE '%$query%' COLLATE utf8_general_ci)";
    }

    return $condition;
}

function getConditionDSGV($query)
{
    $condition = '';

    if ($query != '') {
        $condition .= " (gv.gv_id LIKE '%$query%' COLLATE utf8_general_ci or gv.ten LIKE '%$query%' COLLATE utf8_general_ci)";
    }

    return $condition;
}

function getConditionDSSV($query)
{
    $condition = '';

    if ($query != '') {
        $condition .= " (stu_id LIKE '%$query%' COLLATE utf8_general_ci or ten LIKE '%$query%'  COLLATE utf8_general_ci)";
    }

    return $condition;
}


function GetKhoaDaoTao()
{
    global $pdo;
    $query = "SELECT DISTINCT khoa FROM giao_vien";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về tất cả kết quả
}

function GetMaNganh()
{
    global $pdo;
    $query = "SELECT DISTINCT nganh_id FROM nganh";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về tất cả kết quả
}

function GetHinhThucXetTuyen()
{
    global $pdo;
    $query = "SELECT DISTINCT ma_htts FROM hinh_thuc_xet_tuyen";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về tất cả kết quả
}
