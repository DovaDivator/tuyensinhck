<?php
$servername = "localhost";  
$username = "root";        
$password = "";             
$dbname = "TuyenSinhDatabase";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
} 
echo '<script type="text/javascript">
            alert("kn thanh cong");
          </script>'. $dbname;
?>
