const URL = 'http://localhost/Dictionary-App/externalLogin.php';

function messageResponseCallback(responseObject) {
    /*
    this call back will be called form 
    event_script.js file
    */
   
    // for debug purpose in the console
    console.log("Message :" + responseObject.message +
      ", " + responseObject.sender);

    // reflect succcess on the popup html
    var form = document.forms[0];
    form.style.display = 'none';
    var h1 = document.createElement('h1');
    h1.innerHTML = "successful login";
    h1.style.color = 'green';
    document.body.append(h1);
    return ;
}

function ajaxResponseCallback(ref)
{
   if(ref.responseText == 'loged')
   {
       // success loging 
       // send data to event js script 
       var uName = document.getElementById('uName').value;
       var pass = document.getElementById('pass').value;
       var message = uName + "*" + pass;

       chrome.runtime.sendMessage(message,messageResponseCallback);
   }

   else{
       // tell the user that login data is wrong
        
       document.getElementsByTagName('p')[0].style.display='block';
   }

   return ;
}

function submitData(event)
{
    event.preventDefault();

    // prepare the data
    var uName = document.getElementById('uName').value;
    var pass = document.getElementById('pass').value;
    var data = `uName=${uName}&pass=${pass}`;

    // send the data 
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200)
            ajaxResponseCallback(this);
    };

    xhttp.open('POST', URL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
    
    return ;
}



// attach events 
document.getElementById('submit_btn').addEventListener('click', submitData);