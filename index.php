<?php
    session_start();
    require_once "pdo.php";
    require_once "helpers.php";

    // already signed in
    if(isset($_SESSION['loged']))
    {
        header("Location: home.php");
        die();
    }

    // simple get request, not redirection
    if(!isset($_SESSION['error']))
    {
        // get request 
        $_SESSION['uName'] = "";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    
    <title>Dictionary App</title>
    
    <!-- get Bootstrap css throw cdn -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link rel='stylesheet' href ='css/styles.css'>

</head>
<body>
    <header>
    </header>

    <main>
        <div class='container'>
            <!-- first row -->
            <div class='row home-main-row'>
                <!-- left part of the screen -->
                <div class='col-12 col-md-8  home-left'>
                </div>
                <!-- right part of the screen-->
                <div class='col-12 col-md-4 home-right'>
                    
                    <form method='post' action='login.php'> 
                        
                        <div class="form-group">
                            <label for="username">User Name</label>
                            <input type="text" class="form-control" id="username" name = 'uName'
                            value = '<?php echo $_SESSION['uName'] ?>' >
                        </div>
                        
                        <div class="form-group">
                            <label for="pass">Password</label>
                            <input type="password" class="form-control" id="pass" name='pass'>
                        </div>

                        <button type="submit" class="btn btn-primary">Sign In</button>
                        <a class="btn btn-primary" href='signup.php'>Sign Up </a> 

                    </form>

                    <?php
                        displayMessages();
                    ?>

                </div>
            </div>    
            <!-- end of first row -->
        </div>
    </main>

    <footer>
        <h4> by Ahmed Araby's Keyboard </h4>
    </footer>

</body>


    <!-- get the js for jquery and popper and bootstrap using CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    
    <script src='js/app.js'> </script>
</html>