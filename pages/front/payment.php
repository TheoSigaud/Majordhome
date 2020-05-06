<?php
require "header.php";

if (!isset($_POST['number']) || !isset($_SESSION['idPayment']) || !isset($_SESSION['idFacturePayment'])){
    header('Location: history.php');
}
$idPayment = $_SESSION['idPayment'];
$idFacturePayment = $_SESSION['idFacturePayment'];
$number = $_POST['number'];

unset($_SESSION['idPayment']);



$numberPayment = explode('.', $number);


for ($i = 0; $i < count($numberPayment); $i++) {
    
    $req = $connect->prepare("SELECT somme, facture.FK_idPersonne FROM versement, facture WHERE facture.idFacture = FK_idFacture AND idVersement = ".$numberPayment[$i]);
    $req->execute(array());
    $versement = $req->fetch();

    if (empty($versement) || $versement['FK_idPersonne'] != $_SESSION['user']['idPersonne'] || $versement['somme'] != 0){
        header('Location: history.php');
    }
}




$data = $connect->prepare("SELECT prixTotal, nombreEcheance FROM facture WHERE (FK_idSouscriptionService = " . $idPayment . " OR FK_idSouscriptionAbonnement = " . $idPayment . ") AND FK_idPersonne =".$_SESSION['user']['idPersonne']);
$data->execute(array());
$payment = $data->fetch();

$price = $payment['prixTotal'] / $payment['nombreEcheance'];

$price *= count($numberPayment);

$_SESSION['pricePayment'] = $price;
$_SESSION['numberPayment'] = $numberPayment;



require ('../../stripe-php-master/init.php');

\Stripe\Stripe::setApiKey('sk_test_KIoaPZUhWtezXMfycCQWaVP300pmT5edj0');

$intent = \Stripe\PaymentIntent::create([
    'amount'=> $price,
    'currency' => 'eur',
    'statement_descriptor' => 'Majordhome',
    'description' => 'Remboursement',
    'payment_method_types' => ['card'],
    'setup_future_usage' => 'off_session',
]);

$price = $price/100;


?>



<section>
    <div class="container">
        <div class="form">
            <form id="form-payement">
                <h3 class="text-center title">Remboursement</h3>
                <h2 class="card-title pricing-card-title"><?php echo $price ?>€ TTC</h2>
                <hr class="hr">

                <label for="cardholder-name">Nom du titulaire de la carte *</label>
                <input id="cardholder-name" class="form-control inputPayement" type="text" placeholder="Dufour" required="">

                <div id="card-element" class="form-control"></div>
                <button id="card-button" class="btnPayement" data-secret="<?= $intent->client_secret ?>">Payer</button>
            </form>
        </div>
    </div>
</section>


<script src="https://js.stripe.com/v3/"></script>
<script src="../../js/payment.js"></script>

<?php
require "../footer.php";
?>

