<?php 
    if (isset($_POST['undo'])){
        unset($_SESSION['NotifiInfo']);
        unset($_POST['undo']);
    }
?>