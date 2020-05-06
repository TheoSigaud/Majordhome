display();
function show(id) {

    var content = document.getElementById("content-delete");
    var span = document.getElementsByClassName("cross")[0];
    var no = document.getElementById("no");
    var yes = document.getElementById('yes');

    yes.setAttribute('onclick', 'validation('+id+')');

    content.style.display = "block";

    span.onclick = function() {
        content.style.display = "none";
    }

    no.onclick = function() {
        content.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == content) {
            content.style.display = "none";
        }
    }
}



function validation(id) {

    var content = document.getElementById("content-delete");

    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            console.log(request.status);
        }
    }
    request.open("POST", "deleteSubscription.php");
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(`id=${id}`);

    content.style.display = "none";
    display();
}


function display() {
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState === 4) {
            const subscription = document.getElementById('subscription');
            subscription.innerHTML = request.responseText;
        }
    };
    request.open('GET', 'displaySubscription.php');
    request.send();
}

setInterval(display, 500);