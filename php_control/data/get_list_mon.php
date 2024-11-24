<?php
    include 'db_connect.php';

    if(isset($_POST['list'])){
        $listArray = is_array($_POST['list']) ? $_POST['list'] : explode(", ", $_POST['list']);
        $listString = "{" . implode(",", $listArray) . "}";

        $sql = "SELECT * FROM get_mon_thi(:list)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':list', $listString);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }else{
        echo json_encode(["error" => "Missing 'list' parameter"]);
    }
?>