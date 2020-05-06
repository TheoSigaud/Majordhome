
function unpublishedConfirm(id){

const btnUnpublish = document.getElementById('btnUnpublish');
btnUnpublish.setAttribute('onclick', 'unpublishedService('+id+')');
}

function unpublishedService(id){

const req = new XMLHttpRequest();
req.onreadystatechange = function() {
	if(req.readyState === 4) {



     
        const del = document.getElementById('service-' +id);
        del.parentNode.removeChild(del);

        const info = document.getElementById("information");
        info.innerHTML = req.responseText;
        //displayUnpublishedService();
   
  }
}
req.open("POST","unpublishedService.php");
req.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
req.send(`id=${id}`);


}
