
var uName = "";
var pass = "";
const url = "http://localhost/Dictionary-App/add.php";

function ajaxResponseHandler(ref)
{
    /*
    this will illustrate the server response on 
    saving the knowledge pair
    */
    alert(ref.responseText);
}

function sendKnowledgePair(message)
{
    var tmpArr = message.split('*');
    var data = `uName=${uName}&pass=${pass}&word1=${tmpArr[0]}&word1_lang=${tmpArr[1]}&word2=${tmpArr[2]}&word2_lang=${tmpArr[3]}`;
    
    // make the post request 
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function (){
        if(this.readyState == 4 &&  this.status == 200)
            ajaxResponseHandler(this);
    };
    xhttp.open('POST', url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
    return;
}




/*
interacting with popup_script.js file 
to take user data 
*/

var responseObject = {
    message : "success login",
    sender : "from - event_script.js to - popup_script.js"
};

chrome.runtime.onMessage.addListener(
    function(message,sender,sendResponse) {
        //Will get called from the script where sendResponse is defined
        // in this case send response if reference for the messageResponseCallback
        // function in popup_script.js;
        // for debugining
        sendResponse(responseObject);
        var tmpArray = message.split('*');

        /* accessing the global data */
        uName = tmpArray[0];
        pass = tmpArray[1];
        return ;
    }
);


/*
interact with content_script.js file to store the 
knowledge pair
*/
chrome.runtime.onConnect.addListener(function(port) {
        if(port.name == "content_to_event"){
            port.onMessage.addListener(function(message) {
            if(uName == "" || pass == "")
                alert("log in first");
            else{
                sendKnowledgePair(message);
                port.postMessage("successful adding operation --- message from - event to - content");
            }
        });
    }
    // else ignore the connection
});