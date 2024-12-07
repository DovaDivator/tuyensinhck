<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    include 'db_connect.php';

    if(isset($_POST['list'])){
        $listArray = is_array($_POST['list']) ? $_POST['list'] : explode(", ", $_POST['list']);
        $listString = implode(",", $listArray);

        $sql = "
SELECT DISTINCT 
    TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(htt.list_mon, ', ', numbers.n), ', ', -1)) AS mon
FROM 
    to_hop AS toh
JOIN 
    hinh_thuc_xet_tuyen AS htt ON toh.ma_htts = htt.ma_htts
JOIN 
    (SELECT 1 AS n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 
     UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 
     UNION ALL SELECT 10) numbers 
ON 
    CHAR_LENGTH(htt.list_mon) - CHAR_LENGTH(REPLACE(htt.list_mon, ', ', '')) + 1 >= numbers.n
WHERE 
    FIND_IN_SET(toh.id_tohop, :list) > 0;
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':list', $listString);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }else{
        echo json_encode(["error" => "Missing 'list' parameter"]);
    }
?>