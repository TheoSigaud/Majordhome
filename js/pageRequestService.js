

function detailsRequest(id){

const req = new XMLHttpRequest();
req.onreadystatechange = function() {
   
   	if(req.readyState === 4) {
     		
    	let info = document.getElementById("information");
    	info.innerHTML = req.responseText;
    }
}
req.open('GET', 'displayDetailsRequest.php?id=' + id);
req.send();

}



function acceptRequest(id){
	
	const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState === 4) {
           
           let info = document.getElementById("info");
           info.innerHTML = request.responseText;

      
           let idSous = document.getElementById(`'${id}'`);
           idSous.parentNode.removeChild(idSous);

        }
    };
    request.open('POST', 'acceptRequest.php');
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send(`idSouscriptionService=${id}`);
}



function refuseRequest(id){

	const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState === 4) {
           
           let info = document.getElementById("info");
           info.innerHTML = request.responseText;

      
           let idSous = document.getElementById(`'${id}'`);
           idSous.parentNode.removeChild(idSous);

        }
    };
    request.open('POST', 'refuseRequest.php');
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send(`idSouscriptionService=${id}`);

}