display();

function show(idSouscriptionService) {

    var content = document.getElementById("content-delete");
    var span = document.getElementsByClassName("cross")[0];
    var no = document.getElementById("no");
    var yes = document.getElementById('yes');

    yes.setAttribute('onclick', 'validation(\''+idSouscriptionService+'\')');

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



function validation(idSouscriptionService) {

    var content = document.getElementById("content-delete");

    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            console.log(request.status);
        }
    }
    request.open("POST", "deleteReservationBack.php");
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(`idSouscriptionService=${idSouscriptionService}`);
    content.style.display = "none";
    display();
}

function display() {

    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState === 4) {
            const customer = document.getElementById('reservation');
            customer.innerHTML = request.responseText;
        }
    };
    request.open('POST', 'displayReservationBack.php');
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send();
}