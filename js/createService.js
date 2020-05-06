displayUnpublishedService();


function createService(){

const name = document.getElementById('name').value;
const priceEur = document.getElementById('priceEur').value;
const priceCent = document.getElementById('priceCent').value;

const select = document.getElementById('select');
const selectValue = select.options[select.selectedIndex].innerHTML;

const description = document.getElementById('description').value;

const req = new XMLHttpRequest();
req.onreadystatechange = function(){
	if (req.readyState === 4) {	
		
		document.getElementById('name').value = "";
		document.getElementById('description').value = "";
		document.getElementById('priceEur').value = "";
        document.getElementById('priceCent').value = "";



		let info = document.getElementById('information');
		info.innerHTML = req.responseText;
  		displayUnpublishedService();

    

	}
}

req.open("POST","saveService.php");
req.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
req.send(`name=${name}&description=${description}&priceEur=${priceEur}&priceCent=${priceCent}&selectValue=${selectValue}`);





}


function displayUnpublishedService(){


 const req = new XMLHttpRequest();
 req.onreadystatechange = function() {
   
 	if(req.readyState === 4) {
     		
     	let table = document.getElementById('table');
     	table.innerHTML = req.responseText;

     }
 }

 req.open('GET', 'displayUnpublishedService.php');
 req.send();


}



function deleteConfirm(id){

const btnDelete = document.getElementById('btnDelete');
btnDelete.setAttribute('onclick', 'deleteService('+id+')');


}


function publishConfirm(id){

const btnPublish = document.getElementById('btnPublish');
btnPublish.setAttribute('onclick', 'publishedService('+id+')');
}

function publishedService(id){

const req = new XMLHttpRequest();
req.onreadystatechange = function() {
	if(req.readyState === 4) {



     
        const del = document.getElementById('service-' +id);
        del.parentNode.removeChild(del);

        const info = document.getElementById("information");
        info.innerHTML = req.responseText;
        displayUnpublishedService();
   
  }
}
req.open("POST","publishedService.php");
req.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
req.send(`id=${id}`);


}

function deleteService(id){

const request = new XMLHttpRequest();
request.onreadystatechange = function() {
	if(request.readyState === 4) {
     
        const del = document.getElementById('service-' +id);
        del.parentNode.removeChild(del);
        displayUnpublishedService();
   
  }
}
request.open('DELETE', 'deleteService.php?id=' + id);
request.send();

}

