<?php 
    session_start();

    if(isset($_SESSION['stmt']))
    {
        
        $stmt = $_SESSION['stmt'];
        $cnt = 0;
        $rows = array();
        while($cnt < 20 && $row = $stmt->fetch())
        {
            $rows[] = $row;
            $cnt+=1;
        }
        
        $jsonRows = json_encode(array(1, 2, 3));
        $_SESSION['stmt'] = $stmt; // updated 

        echo $jsonRows;
    }
    else
    {
        $fLang = "";
        $tLang = "";
        $date = "";
        $u
        // get the filering properties 
        if(isset($_POST['fLang']) && 
            isset($_POST['tLang']) && 
            isset($_POST['date']))
        {
            $fLang = $_POST['fLang'];
            $tLang = $_POST['tLang'];
            $date = $_POST['data'];

            // validate the data 
            if($fLang == "" || 
                $tLang == "" || 
                $date == ""){
                $query = 

                // do random selection
            }
            else{
                 // do filtered selection 
            }
        }

        // retrive 20 row 
        $rows = array();
        $cnt = 0;
        while($cnt <20 && $row = $stmt->fetch())
        {
            $rows[] = $row;
            $cnt +=1;
        }

        // save the result reference 
        $_SESSION['stmt'] = $stmt;

        echo json_encode($rows);
    }

    //echo json_encode("no response");
?>