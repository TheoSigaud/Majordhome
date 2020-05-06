
displayMessages();
function displayMessages(){

const req = new XMLHttpRequest();
req.onreadystatechange = function() {
   
   	if(req.readyState === 4) {
     		
  
     
    	let table = document.getElementById('tab');
    	table.innerHTML = req.responseText;

   

    }
}
req.open('GET', 'displayMessages.php');
req.send();
}


var x = setInterval('displayMessages()',5000);


function archiveMessage(id){

const req = new XMLHttpRequest();
req.onreadystatechange = function() {
   
   	if(req.readyState === 4) {
     		

    	const arch = document.getElementById(id);
        arch.parentNode.removeChild(arch);

    }
}
req.open('GET', 'archiveMessage.php?id=' + id);
req.send();

}



function test(){

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


function deleteAllArchiveMessage(){

    let test = document.getElementsByClassName('check');
    let array = [];

    for (var i =0; i < test.length; i++) {
        
        if (test[i].checked == true) {

            array.push(test[i].parentNode.parentNode.id);
            
        }

    }


    const req = new XMLHttpRequest();
    req.onreadystatechange = function() {
   
        if(req.readyState === 4) {
                
            window.location.reload();

        }
    }

    req.open('GET', 'deleteAllArchiveMessage.php?array=' + array);
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
req.open('GET', 'viewReceiveMessage.php?id=' + id);
req.send();

}


function displayReply(){

	let form = document.getElementById('reply');
	form.hidden = false;
	let btnReply = document.getElementById('btnReply');
	btnReply.hidden = true;

}



function replyMessage(){

	const msg = document.getElementById('mess').value;
	const title = document.getElementById('titleMess').innerHTML;
	const to = document.getElementById('to').innerHTML;



const req = new XMLHttpRequest();
req.onreadystatechange = function(){
	if (req.readyState === 4) {	

    	const info = document.getElementById('info');

    	let form = document.getElementById('reply');
		form.hidden = true;
		let btnReply = document.getElementById('btnReply');
		btnReply.hidden = false;
   
   	 	info.innerHTML = req.responseText;

	}
}

req.open("POST","replyMessage.php");
req.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
req.send(`message=${msg}&title=${title}&to=${to}`);



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