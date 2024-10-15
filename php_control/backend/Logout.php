<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_unset();  
    session_destroy();  
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    unset($_POST['logout']);
    exit();
}
?>
