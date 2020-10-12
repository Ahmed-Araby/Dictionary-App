<?php
    session_start(); 
    require_once "pdo.php";
    require_once "helpers.php";

    function inValidForm($errorMessage)
    {
        global $fName, $lName, $uName, $pass;

        $_SESSION['error'] = $errorMessage;

        // keep data entered by the user in the form 
        $_SESSION['fName'] = $fName;
        $_SESSION['lName'] = $lName;
        $_SESSION['uName'] = $uName;
        $_SESSION['pass'] = $pass;

        header("Location: signup.php");
        die();
    }
    
    
    //////////////////////////////////////////////////////////////////////

    if(isset($_SESSION['loged']))
    {
        header("Location: home.php");
    }

    if(isset($_POST['fName']) && 
        isset($_POST['lName']) && 
        isset($_POST['uName']) && 
        isset($_POST['pass']))
    {
        // do form validation 
        $fName = $_POST['fName'];
        $lName = $_POST['lName'];
        $uName = $_POST['uName'];
        $pass = $_POST['pass'];

        if($fName == "" || $lName == "" ||
             $uName == "" || $pass == ""){
                 $errorMessage = 'all fields are required';
                 inValidForm($errorMessage);
             }

        // check if the user name is not taken
        $query = "select user_id from users where user_name = :uName";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(":uName" => $uName));
        
        if($stmt->fetch())
        {
            $errorMessage = "user name is already taken";
            inValidForm($errorMessage);
        }

        // encrypt the password [this hash function is weak search for better one]
        $hashedPass = md5($pass . $salt);

        // else store the use in the DB and sign him in
        $query = "insert into users (first_name, last_name, user_name, password)
                        values (:fName, :lName, :uName, :pass)";
        $stmt = $pdo->prepare($query);
        $success = $stmt->execute(array(":fName" => $fName, 
                            ":lName" => $lName, 
                            ":uName" => $uName, 
                            ":pass" => $hashedPass));

        if(!$success)
        {
            die("there is an issue Call Ahmed Araby for help, 01068482084 ;)");
        }
        else{
            $_SESSION['success'] = "Success"; 
        }
    }

    
    /*
    get request for the first time 
    and to avoid having theses values not declared
    on using them at the form
    */
    if( !isset($_SESSION['error']))
    {
        $_SESSION['fName'] = "";
        $_SESSION['lName'] = "";
        $_SESSION['uName'] = "";
        $_SESSION['pass']  = "";
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <!-- get Bootstrap css throw cdn -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
     integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
   
    <link rel='stylesheet' href ='css/styles.css'>

</head>
<body>

  
    <header>
        <div class="card"   style="width: 18rem;
                                 margin-bottom:50px;
                                 margin-left:auto;
                                 margin-right:auto";>
            
            <img src="./images/teacher.jpg" height='200px'class="card-img-top" alt="...">

            <div class="card-body">
                <h5 class="card-title">Dictionary-App</h5>
                <p class="card-text">Dictionary + teacher </p>
            </div>
        
        </div>
    </header>

    <form action='signup.php' method='post'>

        <div class='container main-form'>
            
            <?php
                displayMessages();
            ?>

            <div class="form-group row">
                <div class='col-12 col-md-2'> 
                    <label for="firstname">First Name</label>
                </div>            

                <div class='col-12 col-md-4'> 
                    <input type="text" class="form-control" name = 'fName' id="firstname" 
                    value='<?php echo $_SESSION['fName'];?>' >
                
                </div>  

                <div class='col-12 col-md-2'>
                    <label for="lastname">Last Name</label>
                </div>
                <div class='col-12 col-md-4'>
                    <input type="text" class="form-control" name = 'lName' id="lastname"
                     value='<?php echo $_SESSION['lName'];?>'>
                
                </div>
            </div>

            <div class="form-group row">
                <div class='col'>
                    <label for="username">User Name</label>
                    
                    <input type="text" class="form-control" name = 'uName' id="username" 
                    value='<?php echo $_SESSION['uName']; ?>'>
                
                </div>
            </div>

            <div class="form-group row">
                <div class="col">
                    <label for='pass'> PASSWORD </label>
                    
                    <input type="password" class="form-control" name = 'pass' id="pass"
                     value='<?php echo $_SESSION['pass']; ?>'>
                
                </div>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
        </div>

    </form>
    
</body>

    <!-- get the js for jquery and popper and bootstrap using CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    
    <script src='js/app.js'> </script>

</html>