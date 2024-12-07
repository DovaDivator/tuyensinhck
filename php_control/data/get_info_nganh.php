<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db_connect.php';

function getInfoNganh($id){
    global $pdo;
    switch($_SESSION['user']['role']){
        case 'Student':
            $query = "
            SELECT 
    ng.nganh_id AS id,
    ng.ten_nganh AS ten,
    ng.chi_tieu AS chi_tieu,
    ng.id_tohop AS to_hop,
    ng.chuong_trinh AS chuong_trinh,
    ng.gv_id AS gv_id,
    ng.date_open AS date_open,
    ng.date_end AS date_end,
    CASE 
        WHEN ng.chi_tieu <= (
            SELECT COUNT(*) 
            FROM sinh_vien sv 
            WHERE sv.nganh_id = ng.nganh_id
        ) THEN TRUE
        ELSE FALSE
    END AS is_full,
    ROUND(ng.diem_chuan, 2) AS diem_chuan,
    JSON_EXTRACT(ng.ghi_chu, '$') AS ghi_chu,
    ng.mo_ta AS mo_ta,
    ng.iframe AS iframe,
    ng.id_img AS img_link,
    ng.chu_thich AS chu_thich
FROM nganh ng
WHERE ng.nganh_id = :id AND ng.isenable;
            ";
            break;
        case 'Teacher':
            $query = "
SELECT 
    CAST(ng.nganh_id AS CHAR) AS id,
    CAST(ng.ten_nganh AS CHAR) AS ten,
    CAST(ng.chi_tieu AS UNSIGNED) AS chi_tieu,
    CAST(ng.id_tohop AS CHAR) AS to_hop,
    CAST(ng.chuong_trinh AS UNSIGNED) AS chuong_trinh,
    CAST(ng.gv_id AS CHAR) AS gv_id,
    CAST(ng.date_open AS DATETIME) AS date_open,
    CAST(ng.date_end AS DATETIME) AS date_end,
    (
        SELECT COUNT(*) 
        FROM sinh_vien sv 
        WHERE sv.nganh_id = ng.nganh_id
    ) AS sl_dky,
    ROUND(ng.diem_chuan, 2) AS diem_chuan,
    ng.ghi_chu AS ghi_chu, -- Loại bỏ phần CAST(ng.ghi_chu AS JSON)
    CAST(ng.mo_ta AS CHAR) AS mo_ta,
    CAST(ng.iframe AS CHAR) AS iframe,
    CAST(ng.id_img AS CHAR) AS img_link,
    CAST(ng.chu_thich AS CHAR) AS chu_thich
FROM nganh ng
WHERE :id = ng.nganh_id AND ng.isenable;

    ";
            break;
        case 'Admin':
            $query = "
            SELECT 
    ng.isenable,
    ng.nganh_id AS id,
    ng.ten_nganh AS ten,
    ng.chi_tieu AS chi_tieu,
    ng.id_tohop AS to_hop,
    ng.chuong_trinh AS chuong_trinh,
    ng.gv_id AS gv_id,
    ng.date_end AS date_end,
    ng.date_open AS date_open,  -- Chọn trường date_open
    (
        SELECT COUNT(*) 
        FROM sinh_vien sv 
        WHERE sv.nganh_id = ng.nganh_id
    ) AS sl_dky,
    ROUND(ng.diem_chuan, 2) AS diem_chuan,
    JSON_UNQUOTE(JSON_EXTRACT(ng.ghi_chu, '$')) AS ghi_chu,
    ng.mo_ta AS mo_ta,
    ng.iframe AS iframe,
    ng.id_img AS img_link,
    ng.chu_thich AS chu_thich
FROM nganh ng
WHERE ng.nganh_id = :id;

            ";
            break;
        default:
            return [];
    }

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return !empty($result) ? $result[0] : null;
}
?>