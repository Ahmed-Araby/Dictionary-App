var lastDate = "2001-12-1";

function renderRows(ref)
{
    var s= ref.responseText
   // var rows = JSON.parse(s);
    console.log(s);
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
    var fLang = document.getElementById('fLang').value;
    var tLang = document.getElementById('tLang').value;
    var sDate = document.getElementById('sDate').value;
    var eDate = document.getElementById('eDate').value;

    var data = `fLang=${fLang}&tLang=${tLang}&sDate=${sDate}&eDate=${eDate}&lastDate=${lastDate}`;
    console.log("date for post request        " + data);
    makeAjaxReq("filltable.php", data, renderRows);
    
    return ;
}