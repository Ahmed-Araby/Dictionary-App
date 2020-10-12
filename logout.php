<?php 
    session_start();
    if(isset($_SESSION['loged']))
    {
       session_unset();
    }
    
    header("Location: index.php");
    die();
?>