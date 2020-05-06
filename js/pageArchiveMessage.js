displayArchiveMessage();

function displayArchiveMessage(){

const req = new XMLHttpRequest();
req.onreadystatechange = function() {
   
   	if(req.readyState === 4) {
     		
    	let table = document.getElementById('tab');
    	table.innerHTML = req.responseText;

    }
}
req.open('GET', 'displayArchiveMessage.php');
req.send();

}


var x = setInterval('displayArchiveMessage()',5000);
function deleteMessage(id){

const req = new XMLHttpRequest();
req.onreadystatechange = function() {
   
   	if(req.readyState === 4) {
     		
    	const del = document.getElementById(id);
        del.parentNode.removeChild(del);

    }
}
req.open('GET', 'deleteMessage.php?id=' + id);
req.send();

}

function deleteMessage(id){

const req = new XMLHttpRequest();
req.onreadystatechange = function() {
   
   	if(req.readyState === 4) {
     		

    	const del = document.getElementById(id);
        del.parentNode.removeChild(del);

    }
}
req.open('GET', 'deleteMessage.php?id=' + id);
req.send();

}




function displayBtn(){

	clearInterval(x);
	let checkbox = document.getElementsByClassName('check');
	let btn = document.getElementById('btn');
	let btn1 = document.getElementById('btn1');
	let btn2 = document.getElementById('btn2');

	btn.hidden = false;
	btn2.hidden = false;


	for (let i =0; i < checkbox.length; i++) {

			if (  checkbox[i].style.display == 'block') {
		
			checkbox[i].style.display = 'none';

		}else{
			checkbox[i].style.display = 'block';


		}
	}

		btn1.hidden = true;


}




function deleteMultipleMessage(){

	let test = document.getElementsByClassName('check');
	let array = [];

	for (var i =0; i < test.length; i++) {
		
		if (test[i].checked == true) {

			array.push(test[i].parentNode.parentNode.id);
			
		}

	}

	console.log(array);


	const req = new XMLHttpRequest();
	req.onreadystatechange = function() {
   
   		if(req.readyState === 4) {
     			

     			console.log(req.responseText);
     		//window.location.reload();

		}
	}

	req.open('GET', 'deleteMultipleMessage.php?array=' + array);
	req.send();


	
}




function viewMessage(id){


clearInterval(x);
const req = new XMLHttpRequest();
req.onreadystatechange = function() {
   
    if(req.readyState === 4) {
            
    let table = document.getElementById('tab');
    table.innerHTML = req.responseText;

    }
}
req.open('GET', 'viewMessage.php?id=' + id);
req.send();

}





