const myButton = document.querySelector('.cancelBooking');
myButton.addEventListener('click', cancelBooking);

function cancelBooking() 
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
    xmlhttp.open("GET", "/cancel-booking", true);
    xmlhttp.send();
}