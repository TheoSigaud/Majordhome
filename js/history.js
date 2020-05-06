
var tabSub = document.getElementById("tableHisSubscription");
var tabSer = document.getElementById("tableHisServices");
var tabBill = document.getElementById("tableHisBill");
var tabQuote = document.getElementById("tableHisQuote");
var tabBillSouscription = document.getElementById("tableHisBillSouscription");

function displayHisSubscription(){

    if (tabSer.style.display != "none"){
        tabSer.style.display ="none";
    }

    if (tabBill.style.display != "none"){
        tabBill.style.display = "none";
    }

    if (tabBillSouscription.style.display == "block") {
        tabBillSouscription.style.display = "none";
    }

    if (tabSub.style.display == "none"){
        tabSub.style.display = "block";
    }

    if (tabQuote.style.display != "none"){
        tabQuote.style.display = "none";
    }

}

function displayHisService(){


    if (tabBill.style.display != "none"){
        tabBill.style.display = "none";
    }

    if (tabSub.style.display != "none"){
        tabSub.style.display = "none";
    }
    if (tabBillSouscription.style.display == "block") {
        tabBillSouscription.style.display = "none";
    }

    if (tabSer.style.display != "block"){
        tabSer.style.display = "block";
    }

      if (tabQuote.style.display != "none") {
        tabQuote.style.display = "none";
    }

  

}


function displayHisBill(){

    if (tabSer.style.display != "none"){
        tabSer.style.display ="none";
    }

    if (tabSub.style.display != "none"){
        tabSub.style.display = "none";
    }
    if (tabBillSouscription.style.display == "block") {
        tabBillSouscription.style.display = "none";
    }

    if (tabBill.style.display != "block"){
        tabBill.style.display = "block";
    }

      if (tabQuote.style.display != "none") {
        tabQuote.style.display = "none";
    }
}

function displayHisBillSouscription() {

    if (tabBill.style.display == "block") {
        tabBill.style.display = "none";
    }

    if (tabBillSouscription.style.display != "block") {
        tabBillSouscription.style.display = "block";
    }

}



function displayHisQuote(){

    if (tabSer.style.display != "none"){
        tabSer.style.display ="none";
    }

    if (tabBill.style.display != "none"){
        tabBill.style.display = "none";
    }

    if (tabBillSouscription.style.display == "block") {
        tabBillSouscription.style.display = "none";
    }
   
    if (tabSub.style.display != "none"){
        tabSub.style.display = "none";
    }

    if (tabQuote.style.display != "block") {
        tabQuote.style.display = "block";
    }

    

}

