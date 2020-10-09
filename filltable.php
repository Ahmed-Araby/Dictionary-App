<?php 

    session_start();    
    require_once "pdo.php";
    $rowNumLimt = 20;
    function dateTimeCvt($date)
    {
        return $date . " " . "23:59:59";
    }
 
    $fLang = "";
    $tLang = "";
    $sDate = "2001-10-10";
    $eDate = date("Y-m-d");

    // get the filering properties 
    if(isset($_POST['fLang']) && 
        isset($_POST['tLang']))
    {
        $fLang = $_POST['fLang'];
        $tLang = $_POST['tLang'];

        // validate the data 
        if($fLang == "" ||  $tLang == "" )
        {
            
            // do random selection
            $query = "call getRows(:uid, :lastDateTime, :limt)";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(":uid" => $_SESSION['uId'], 
                                "lastDateTime" => $_POST['lastDateTime'], 
                                ":limt" => $rowNumLimt));
        }

        else
        {

            // do filtered selection
            if($_POST['sDate'] != "")
                $sDate = $_POST['sDate'];
            if($_POST['eDate'] != "")
                $eDate = $_POST['eDate'];
            
            $query = "call getRowsFiltered(:uId, :l1, :l2, :sDT, :eDT, :lastDateTime, :limt)";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(":uId" => $_SESSION['uId'], 
                                        ":l1" => $fLang, 
                                        ":l2" => $tLang, 
                                        ":sDT" => dateTimeCvt($sDate), 
                                        ":eDT" => dateTimeCvt($eDate),
                                        "lastDateTime" => $_POST['lastDateTime'],   
                                        ":limt" => $rowNumLimt));
        }
    }

    $rows = array();
    while($row = $stmt->fetch(PDO::FETCH_GROUP|PDO::FETCH_ASSOC))
        $rows[] = $row;
    echo json_encode($rows);

?>