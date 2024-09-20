<?php 
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['logout'])) {
    session_unset();  
    session_destroy();  
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    exit();
}
?>
