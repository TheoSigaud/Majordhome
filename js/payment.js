// Stripe API Key
var stripe = Stripe('pk_test_SgowioJczbla4GWn8ilMCNRO00YyKsLNHV'); //YOUR_STRIPE_PUBLISHABLE_KEY
var elements = stripe.elements();

var style = {
    base: {
        fontSize: '20px',
    }
};


// Create an instance of the card Element
var card = elements.create('card', {style: style});
// Add an instance of the card Element into the `card-element` <div>
card.mount('#card-element');

var cardHolderName = document.getElementById('cardholder-name');
var cardButton = document.getElementById('card-button');
var clientSecret = cardButton.dataset.secret;


cardButton.addEventListener('click', function (ev) {

    ev.preventDefault();
    stripe.handleCardPayment(
        clientSecret, card, {
            payment_method_data: {
                billing_details: {name: cardHolderName.value}
            }

        }
    ).then(function (result) {


        if (result.error) {

            let danger = document.getElementsByClassName('alert alert-danger');

            if(danger.length == 0){
                let section = document.getElementsByTagName('header')[0];
                let alert = document.createElement('div');
                alert.setAttribute('class', 'alert alert-danger');
                alert.textContent = 'Une erreur est survenue. Vérifiez vos informations !';
                section.appendChild(alert);
            }

        }else{
            window.location.href = "savePayment.php";
        }
    });
});