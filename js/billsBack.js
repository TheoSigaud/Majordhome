let service = document.getElementById("quoteService");
let subscription = document.getElementById("quoteSubscription");


function displaySubscription(){


	if ( service.style.display != "none") {

		service.style.display = "none";
		subscription.style.display = "block";

	}

}

function displayService(){


	if ( subscription.style.display != "none") {

		subscription.style.display = "none";
		service.style.display = "block";

	}

}