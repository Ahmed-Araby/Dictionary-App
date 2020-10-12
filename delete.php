<?php 
    session_start();
    require_once "pdo.php";

    if(!isset($_SESSION['loged']))
    {
        header("Location: index.php");
        die();
    }
    if(isset($_GET['word1_fk']) && 
        isset($_GET['word2_fk']))
    {
        // delete operation
        $query = 'delete from pairs where word1_fk = :w1Fk and word2_fk = :w2Fk and user_fk = :uFk';
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(":w1Fk" => $_GET['word1_fk'], 
                            ":w2Fk" => $_GET['word2_fk'], 
                            ":uFk" => $_SESSION['uId']));
        /*
        we need to get number of affected rows
        */
        
        echo "deleted";              
    }
    else 
    {
        die("you have an issue call Ahmed Araby for support : 01068482084");
    }
?>