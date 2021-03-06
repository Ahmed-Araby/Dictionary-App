<?php 
    session_start();
    require_once "pdo.php";
    require_once "helpers.php";

    if(!isset($_SESSION['loged']))
    {
        header("Location: index.php");
    }

    /*
    sql for filling the select input
    there are some alternatives 
    like 1- put languages in a file and load them, 
         2- make new table for languages correspondig to a specific usre 
         but the approach I used bellow is the most dynamic one 
         however it could become computionaly expensive
    */

    $query = "select word_lang 
    from words 
    inner join pairs 
    on word_id = word1_fk or word_id = word2_fk 
    where user_fk =" . $_SESSION['uId'] . "\n group by word_lang ";
    $stmt = $pdo->query($query);
    $languages = array();
    while($row = $stmt->fetch(PDO::FETCH_GROUP|PDO::FETCH_ASSOC))
    {
        $languages [] = $row;
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

        <title>Home</title>

        <!-- get Bootstrap css throw cdn -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
         integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
   
        <link rel='stylesheet' href ='css/styles.css'>

    </head>

    <body>

        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                
                <a class="navbar-brand" href="#">
                 <img src='chromeExtension/icon.png' width='30px' height='30px'> 
                 </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">

                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>

                        <!--
                        <li class="nav-item">
                            <a class="nav-link" href="quiz.php">Quiz</a>
                        </li>

                        <li class='nav-item'>
                            <a class='nav-link' href='settings.php'> settings </a>
                        </li>

                        <li>
                            <a class='nav-link' href='aboutme.php'> About Me </a>
                        </li>
                        -->

                        <li>
                            <a class='nav-link' href='logout.php'> Log Out </a>
                        </li>
                    </ul>
                
                </div>

            </nav>
        </header>

        <main>
            
            <div class='container'>

                <!-- First row -->
                <div class='row align-items-center justify-content-around'>

                    <div class='col-12 col-md-2'>
                        <label> From Language </label>
                    </div>

                    <div class='col-12 col-md-4'>
                        <select name='fLang' id='fLang'>
                            <option></option>
                            <!-- populate it using PHP -->
                            <?php 
                                for($index = 0; $index<sizeof($languages); $index+=1)
                                {
                                    echo "<option>";
                                    echo $languages[$index]['word_lang'];
                                    echo "</option>";
                                }
                            ?>

                        </select>

                    </div>

                    <div class='col-12 col-md-2'>
                        <label> From Language </label>
                    </div>

                    <div class='col-12 col-md-4'>
                        <select name='tLang' id='tLang'>
                            <!-- populate it using PHP -->
                            <option></option>
                            <?php 
                                for($index = 0; $index<sizeof($languages); $index+=1)
                                {
                                    echo "<option>";
                                    echo $languages[$index]['word_lang'];
                                    echo "</option>";
                                }
                            ?>

                        </select>

                    </div>

                </div>

                <!-- second row -->
                <div class='row'>
                    <div class='col-12 col-md-2'>
                            <label> Start Date </label>
                    </div>
                    
                    <div class='col-12 col-md-4'>
                        <input type="date" id="sDate" name="sDate">
                    </div>

                    <div class='col-12 col-md-2'>
                            <label> End Date </label>
                    </div>
                    
                    <div class='col-12 col-md-4'>
                        <input type="date" id="eDate" name="eDate">
                    </div>
                </div>
                
                <!-- 3rd row -->
                <div class='row'>
                    <div class='col-12 col-md-6 offset-md-0'>
                        <button type="button" class="btn btn-primary" onclick='getTableData()'>Filter</button>
                    </div>
                </div>

            </div>

            <!-- second container --> 
            <div class = 'container home-table'>
                <table class="table table-hover table-dark" id='data_table'>
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Word</th>
                        <th scope="col">Word Language</th>
                        <th scope="col">Translation</th>
                        <th scope="col">Translation Language</th>
                        <th scope="col">Date</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                        </tr>
                    </thead>

                    <tbody id='data_table_body'>
                    <!--
                        <tr>
                        <td scope="row">1</td>
                        <td>boy</td>
                        <td>ولد</td>
                        <td>15-5-2020</td>
                        <td>Edit</td>
                        <td>Delete</td>
                        </tr>
                        -->
                        
                    </tbody>
                </table>
            </div>
            
        </main>

        <footer>
         </footer>
        
    </body>

    
    <!-- get the js for jquery and popper and bootstrap using CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    
    <script src='js/ajax.js'> </script>
    <script src='js/home.js'> </script>
    
</html>