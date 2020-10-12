function makeAjaxPostRequest(url, data, callbBackfun)
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

function makeAjaxGetRequest(url, callbBackfun)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
            callbBackfun(this);
    }

    xhttp.open('GET', url, true);
    xhttp.send();
    return ;
}