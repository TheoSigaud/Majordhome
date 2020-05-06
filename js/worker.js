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
    request.open("POST", "deleteWorker.php");
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(`id=${id}`);

    content.style.display = "none";
    display();

}


function display() {

    var search = document.getElementById('search').value;
    var type = document.getElementById('type').value;

    search = search.trim();

    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState === 4) {
            const customer = document.getElementById('worker');
            customer.innerHTML = request.responseText;
        }
    };
    request.open('POST', 'displayWorker.php');
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send(`search=${search}&&type=${type}`);
}

setInterval(display, 500);
