displayCategory();
function createCategory(){

const name = document.getElementById('name').value;
const description = document.getElementById('description').value;

const req = new XMLHttpRequest();
req.onreadystatechange = function(){
	if (req.readyState === 4) {	
		
		document.getElementById('name').value = "";
		document.getElementById('description').value = "";



		let info = document.getElementById('information');
		info.innerHTML = req.responseText;
    displayCategory();

    

	}
}

req.open("POST","createCategory.php");
req.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
req.send(`name=${name}&description=${description}`);

}

function displayCategory(){

const req = new XMLHttpRequest();
req.onreadystatechange = function() {
   
   	if(req.readyState === 4) {
     		
    	let table = document.getElementById('table');
    	table.innerHTML = req.responseText;

    }
}
req.open('GET', 'displayCategory.php');
req.send();

}

// setInterval("displayCategory()", 1000);



function deleteCategory(id){

const request = new XMLHttpRequest();
request.onreadystatechange = function() {
	if(request.readyState === 4) {


    console.log(request.responseText);
     
        const del = document.getElementById('category-' +id);
        del.parentNode.removeChild(del);
   
  }
}
  request.open('DELETE', 'deleteCategory.php?id=' + id);
  request.send();

}

function getData(id){


  updtName = document.getElementById('updateName');
  updtDescription = document.getElementById('updateDescription');

  const btnUpdt = document.getElementById('update');
  btnUpdt.setAttribute('onclick', 'updateCategory('+id+')');

  const updt = document.getElementById('category-' +id);
  updtName.value = updt.childNodes[1].innerHTML;
  updtDescription.value =  updt.childNodes[2].innerHTML;




}


function deleteConfirm(id){

  const btnDelete = document.getElementById('btnDelete');
  btnDelete.setAttribute('onclick', 'deleteCategory('+id+')');
}

function updateCategory(id){


const name = document.getElementById('updateName').value;
const description = document.getElementById('updateDescription').value;

const req = new XMLHttpRequest();
req.onreadystatechange = function(){
  if (req.readyState === 4) { 
    
      
    let info = document.getElementById('information');
    info.innerHTML = req.responseText;
    displayCategory();
    

  }
}

req.open("POST","updateCategory.php");
req.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
req.send(`id=${id}&name=${name}&description=${description}`);

}

