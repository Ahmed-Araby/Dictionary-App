  
<?php
  $salt ='XyZzy12*_';  // for password hashing
  $pdo = new 
  PDO('mysql:host=localhost;port=3306;dbname=dictionaryapp',
   'ahmed',
    'ahmed');


    $pdo->setAttribute(PDO::ATTR_ERRMODE, 
                        PDO::ERRMODE_EXCEPTION);
     
    // for testing
    //var_dump($pdo);
?>