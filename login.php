<?php
    session_start();
    require_once "pdo.php";
    require_once "helpers.php";

    ////////////////////////////////////////////////////////////////

    function inValidForm($errorMessage)
    {
        global $uName;

        $_SESSION['error'] = $errorMessage;
        $_SESSION['uName'] = $uName;
        header("Location: index.php");
        die();
    }
    
    ////////////////////////////////////////////////////////////////

    if(isset($_SESSION['loged']))
    {
        header("Location: home.php");
    }

    if(isset($_POST['uName']) && 
        isset($_POST['pass']))
    {
        // post request
         
        $uName = $_POST['uName'];
        $pass = $_POST['pass'];

        // form validation
        if($uName == "" || $pass == ""){
            $errorMessage = 'all fields are required';
            inValidForm($errorMessage);
        }

        // query the DB to make sure this user is exist and right
        $hashedPass = md5($pass . $salt);
        $query = 'select * from users where 
        user_name = :uName and password = :pass';
        $stmt = $pdo->prepare($query);
        $stmt->execute( array( ":uName" => $uName, 
                                ":pass" => $hashedPass));
        if($row = $stmt->fetch())
        {
            $_SESSION['fName'] = $row['first_name'];
            $_SESSION['lName'] = $row['last_name'];
            $_SESSION['uName'] = $uName;
            $_SESSION['uId'] = $row['user_id'];
            $_SESSION['loged'] = true;
            header("Location: home.php");
            die();
        }

        else{
            $errorMessage = "user name or password is incorrect";
            inValidForm($errorMessage);
        }

    }

    else{
        die("you have an issue call Ahmed Araby for support : 01068482084");
    }
?>