var buttons = document.querySelectorAll('.ajaxReq');
console.log(buttons);
buttons.forEach(button => button.addEventListener('click', navigateCalender))
function navigateCalender() 
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
           if (xmlhttp.status == 200) {
              let newDoc = document.open("text/html", "replace");
              newDoc.write(xmlhttp.responseText);
              newDoc.close();
           }
           else if (xmlhttp.status == 400) {
              alert('There was an error 400');
           }
           else {
               alert('something else other than 200 was returned');
           }
        }
    };
    if(event.target.innerHTML == 'Next')
      xmlhttp.open("GET", "/next-month", true);
    else if(event.target.innerHTML == 'Previous')
      xmlhttp.open("GET", "/previous-month", true);
    else if(event.target.innerHTML == 'Cancel')
    {
      alert('here');
      xmlhttp.open("GET", "/cancel-booking", true);
    }

    xmlhttp.send();
}