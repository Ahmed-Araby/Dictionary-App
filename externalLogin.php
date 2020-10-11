<?php 
    require_once "pdo.php";
    
    if(isset($_POST['uName']) && 
        isset($_POST['pass']))
    {
        // post request
        
        $uName = $_POST['uName'];
        $pass = $_POST['pass'];

        // form validation
        if($uName == "" || $pass == ""){
          echo  'all fields are required';
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
            echo "loged";
        }

        else{
            echo "user name or password is incorrect";
        }
    }
?>