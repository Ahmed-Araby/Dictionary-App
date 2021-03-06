var lastDateTime = "2001-12-1 00:00:01";
var originalScroolHeight;
var onGoingRequest = false;

var table = document.getElementById("data_table");

function renderRows(ref)
{
    // get the date 
    var s= ref.responseText
    var rows = JSON.parse(s);

    // fill the table 
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
        editLink.setAttribute('class' ,"edit btn btn-warning");
        editLink.setAttribute('href', `edit.php?word1_fk=${word1_fk}&word2_fk=${word2_fk}`);
        editLink.innerHTML = 'Edit';

        var deleteLink = document.createElement('a');
        deleteLink.setAttribute('class' ,"delete btn btn-danger");
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
    onGoingRequest = false;
    return ;
}



function getTableData()
{   
    /*
    this will be safe 
    as js is single thrided

    this don't seem to be a solution
    */ 
    //console.log(onGoingRequest);
    if(onGoingRequest == true)
        return ;
    onGoingRequest = true;
    //console.log("passed");

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
    makeAjaxPostRequest("filltable.php", data, renderRows);
    
    return ;
}


function handleDataTableEvents(event)
{
    if(event.target.classList[0] =='delete')
        deleteTableRow(event);
    return ;
}

function deleteTableRow(event)
{
    event.preventDefault(); 

    // delte the Row from the data base
    var url = event.target.href;
    makeAjaxGetRequest(url, function(ref){
        console.log(ref.responseText);
    });

    // delete the row form the UI 
    var tmpRow = event.target.parentNode.parentNode;
    var tableBody = document.getElementById('data_table_body');
    tableBody.removeChild(tmpRow);
    
    return;
}




//// attach listners ////



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
        makeAjaxPostRequest("filltable.php", data, renderRows);
    }
    return ;
})

// record the original scrool height before any insertion
window.addEventListener('load', function(){
    originalScroolHeight = document.scrollingElement.scrollHeight;
});

// attach listner to the table to delete rows 
document.getElementById('data_table').addEventListener('click', handleDataTableEvents);

/*
I might need to load some data initially on loading the page
*/
