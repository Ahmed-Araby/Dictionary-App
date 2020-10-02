<?php 
 

    function displayMessages()
    {
        if(isset($_SESSION['error'])){
            echo "
                <div class='form-group'>
                <h4 style='color:red' >" . $_SESSION['error'] . "</h4> </div> ";
            unset($_SESSION['error']); // flash message style

        }
        else if(isset($_SESSION['success']))
        {
            echo "
            <div class='form-group'>
            <h4 style='color:green' >" . $_SESSION['success'] . "</h4> </div> ";
            unset($_SESSION['success']); // flash message style
        }          
    }

?>