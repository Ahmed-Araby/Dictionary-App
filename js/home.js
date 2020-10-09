var lastDateTime = "2001-12-1 00:00:01";
var originalScroolHeight;

function renderRows(ref)
{
    // get the date 
    var s= ref.responseText
    var rows = JSON.parse(s);

    //console.log(rows);

    // fill the table 
    var table = document.getElementById("data_table");
    var cnt = table.rows.length;
    
    
    var fLang = document.getElementById('fLang').value;

    for(var i=0; i<rows.length; i++)
    {
        /*
        If I manged to retrive words in the right order 
        from the data base , this would decrease the request lag as I will discard some information 
        from being requested
        */

        var tmpRow = document.createElement("tr");
        var tmpCell = tmpRow.insertCell();
        // row number
        tmpCell.append(cnt);
        cnt +=1;

        var rowArray = [];
        
        var word1 = rows[i]['word1'];
        var word1_fk = rows[i]['word1_fk'];
        var word1_lang = rows[i]['word1_lang'];
    
        var word2 = rows[i]['word2'];
        var word2_fk = rows[i]['word2_fk'];
        var word2_lang = rows[i]['word2_lang'];
        
        var add_date = rows[i]['add_dateTime'].split(' ')[0];
        
        // put edit and delete buttons 
        var editLink = document.createElement('a');
        editLink.setAttribute('class' ,"btn btn-warning");
        editLink.setAttribute('href', `edit.php?word1_fk=${word1_fk}&word2_fk=${word2_fk}`);
        editLink.innerHTML = 'Edit';

        var deleteLink = document.createElement('a');
        deleteLink.setAttribute('class' ,"btn btn-danger");
        deleteLink.setAttribute('href', `delete.php?word1_fk=${word1_fk}&word2_fk=${word2_fk}`);
        deleteLink.innerHTML = 'Delete';

        /* are theses copies or references !!!????*/
        if(word1_lang == fLang)
            rowArray = [word1, word1_lang, word2, word2_lang, add_date, editLink, deleteLink];
        else
            rowArray = [word2, word2_lang, word1, word1_lang, add_date, editLink, deleteLink];

        for(const elem in rowArray){
            var tmpValue = rowArray[elem];
            tmpCell = tmpRow.insertCell();
            tmpCell.append(tmpValue);
        }

        
        table.getElementsByTagName('tbody')[0].appendChild(tmpRow);

        // update date time
        lastDateTime = rows[i]['add_dateTime'];
    }
    return ;
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
    // reset
    lastDateTime = "2001-12-1 00:00:01";
    var table = document.getElementById("data_table");
    table.getElementsByTagName('tbody')[0].innerHTML = "";


    var fLang = document.getElementById('fLang').value;
    var tLang = document.getElementById('tLang').value;
    var sDate = document.getElementById('sDate').value;
    var eDate = document.getElementById('eDate').value;
    
    var data = `fLang=${fLang}&tLang=${tLang}&sDate=${sDate}&eDate=${eDate}&lastDateTime=${lastDateTime}`;
    //console.log("date for post request        " + data);
    makeAjaxReq("filltable.php", data, renderRows);
    
    return ;
}


// listen to scrolling 
window.addEventListener('scroll', function(){
    var topOffset  = document.scrollingElement.scrollTop;
    var scrolHeight =  document.scrollingElement.scrollHeight;

    if(Math.abs(scrolHeight - topOffset - originalScroolHeight) < 100)
    {  
        var fLang = document.getElementById('fLang').value;
        var tLang = document.getElementById('tLang').value;
        var eDate = document.getElementById('eDate').value;
        var sDate = document.getElementById('sDate').value;

        var data = `fLang=${fLang}&tLang=${tLang}&sDate=${sDate}&eDate=${eDate}&lastDateTime=${lastDateTime}`;
        makeAjaxReq("filltable.php", data, renderRows);
    }
    return ;
})

// record the original scrool height before any insertion
window.addEventListener('load', function(){
    originalScroolHeight = document.scrollingElement.scrollHeight;
});

/*
I might need to load some data initially on loading the page
*/
