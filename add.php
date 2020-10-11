<?php
    require_once "pdo.php";

    if(isset($_POST['uName']) && 
        isset($_POST['pass']) && 
        isset($_POST['word1']) && 
        isset($_POST['word1_lang']) &&
        isset($_POST['word2']) && 
        isset($_POST['word2_lang']))
    {
        $uName = $_POST['uName'];
        $pass = $_POST['pass'];
        $word1 = $_POST['word1'];
        $word2 = $_POST['word2'];
        $word1_lang = $_POST['word1_lang'];
        $word2_lang = $_POST['word2_lang'];

        $uId = "";
        $hashedPass = md5($pass . $salt);

        /* get id of the user */
        $query = "select user_id from users where user_name = :uName and password = :Hpass";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(":uName" => $uName, 
                            ":Hpass" => $hashedPass));
        if($row = $stmt->fetch())
        {
            $uId = $row['user_id'];
        }
        else{
            echo "user data is wrong ";
            die();
        }

        /* add words and get ids of the words*/
        // insert first word
        $query = "insert into words (word, word_lang) values(:word, :word_lang)";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(":word" => $word1, 
                            ":word_lang" => $word1_lang));
        $word1Id = $pdo->lastInsertId();

        // insert second word
        $query = "insert into words (word, word_lang) values(:word, :word_lang)";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(":word" => $word2, 
                            ":word_lang" => $word2_lang));
        $word2Id = $pdo->lastInsertId();
        
        /* add knowledge pair into pairs table*/
        $query = "insert into pairs (word1_fk, word2_fk, user_fk, add_dateTime) values(:w1Fk, :w2Fk, :userFk, :addDT)";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(":w1Fk" => $word1Id, 
                            ":w2Fk" => $word2Id, 
                            ":userFk" => $uId, 
                            ":addDT" =>date('Y-m-d H:i:s') ) );
                            
        echo "added successfuly";
    }
    else{
        echo "invalid post data";
    }

?>


