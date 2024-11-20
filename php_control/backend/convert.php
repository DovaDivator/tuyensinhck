<?php
function convert_date($date) {
    // Tách ngày và giờ
    $dateParts = explode(" ", $date); 
    $dateValues = explode("-", $dateParts[0]); // Tách ngày thành [Năm, Tháng, Ngày]

    // Ngày, tháng, năm từ chuỗi tách ra
    $day = $dateValues[2]; 
    $month = $dateValues[1]; 
    $year = $dateValues[0]; 

    // Định dạng ngày (d/m/Y)
    $formattedDate = "$day/" . $month . "/" . $year;
    
    // Kết hợp giờ và ngày
    return $formattedDate;
}

function convert_time($time) {
    // Tách ngày và giờ
    $dateParts = explode(" ", $time); 
    $timeValues = explode(":", $dateParts[1]); // Tách giờ, phút, giây

    // Giờ và phút
    $hour = (int)$timeValues[0];
    $minute = (int)$timeValues[1]; 


    $formattedTime = ($hour < 10 ? $hour : $hour) . "h";

    if ($minute != 0) {
        $formattedTime .= ($minute < 10 ? $minute : $minute);
    }

    if ($hour == 0 && $minute == 0) {
        $formattedTime = "0h";
    }   
    // Kết hợp giờ và ngày
    return $formattedTime;
}
?>