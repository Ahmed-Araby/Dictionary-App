<?php 
     session_start();
     require_once "pdo.php";
     require_once "helpers.php";
 
     if(!isset($_SESSION['loged']))
     {
         header("Location: index.php");
     }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1 style='color:red'> settings page , to be implemented </h1>

</body>
</html>