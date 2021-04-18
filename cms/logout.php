<?php 
    session_start();
    include "./database/db.php";
    $_SESSION['userFirstName'] = null;
    $_SESSION['userEmail'] = null;
    $_SESSION['userPassword'] = null;
    header('Location: login.php');
?>