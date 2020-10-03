function renderRows(ref)
{
    var rows = JSON.parse(ref.responseText);
    console.log(rows);
}

function makeAjaxReq(url, data, callbBackfun)
{
    

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
            callbBackfun(this);
    }

    xhttp.open('POST', url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);

}

function getData()
{
     
    // get the filtering properties
    // this accessing mean get the html element from the jquery object  
    var fLang = $("#fLang").text();
    var tLang = $("#tLang").text();
    var date = $("#date").val();
    
    // do post request 
    makeAjaxReq("filltable.php", "name=ahmed", renderRows);
    return ;
}