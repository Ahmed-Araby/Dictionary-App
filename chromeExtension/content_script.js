alert("hellow from content_script.js file");


var exId = "cnnhmfnakfdlfgdinjcbphmeojoioegp";
var message = "hey dude";
var port = chrome.runtime.connect(exId,{"name" : "content_to_event"});
port.onMessage.addListener(function(message) {
    console.log(message);
});


function dispData()
{
    /*
    get reference to the html elements here 
    as some of them will get injected and removed by the js 
    of the google page for different events.
    */
    var wordElem = document.getElementById('source');
    var translationElem = document.getElementsByClassName("tlid-translation translation")[0];
    var languages = document.getElementsByClassName('jfk-button-checked');
    if(wordElem == undefined || translationElem == undefined || languages == undefined)
    {
        alert("make sure to write the word");
        return ;
    }
    var word = wordElem.value;
    var wordLang = languages[0].innerText.split(' ')[0];

    var translation = translationElem.innerText;
    var translationLang = languages[1].innerText.split(' ')[0];
    
    /*
    for debugining purpose
    alert("word " + word + "  translation  "  + translation);
    alert("lang1 " + wordLang + "   lang2 " + translationLang);
    */

    // send data to event script
    // to put them into the server
    var message = word + " " + wordLang + " " + translation + " " + translationLang;
    port.postMessage(message);
    return;
}


document.addEventListener('keydown', function(event){
    if(event.key == "Control")
        dispData();
})

