<?php
require "header.php";

if(!empty($_SESSION['idSubscription'])){
    $id = $_SESSION['idSubscription'];
}else{
    $id = 0;
}

$number = $_POST['number'];
$_SESSION['numberSubscription'] = $number;
$data = $connect->prepare("SELECT dateFin FROM souscription_abonnement WHERE statut = 0 AND FK_idPersonne = ".$_SESSION['user']['idPersonne']);
$data->execute(array());
foreach ($data->fetchAll() as $key => $endTime){

    if ($endTime['dateFin'] > $dateTime){
        $_SESSION["subscription"] = 'Vous possédez déjà un abonnement';
        header('Location: subscription.php');
    }

}



$req = $connect->prepare("SELECT nom, prix, annee, mois, jours FROM abonnement WHERE idAbonnement = $id");
$req->execute(array());
$subscription = $req->fetch();

$count = $req->rowCount();

if ($count == 0){
    header('Location: ../../404.php');
}

$price = $subscription['prix'];
$_SESSION['priceSubscription'] = $price;

if($number != 1){
    $price = $price/$number;
}
require ('../../stripe-php-master/init.php');

\Stripe\Stripe::setApiKey('sk_test_KIoaPZUhWtezXMfycCQWaVP300pmT5edj0');

$intent = \Stripe\PaymentIntent::create([
    'amount'=> $price,
    'currency' => 'eur',
    'statement_descriptor' => 'Majordhome',
    'description' => $subscription['nom'],
    'payment_method_types' => ['card'],
    'setup_future_usage' => 'off_session',
]);


$price = $price/100;




?>



<section>
    <div class="container">
        <div class="form">
            <form id="form-payement">
                <h3 class="text-center title"><?php echo $subscription['nom']?></h3>
                <h2 class="card-title pricing-card-title"><?php echo $price ?>€ TTC
                    <small class="text-muted">
                        <?php if($number == 2){ echo "/mois pendant 2 mois à compter d'aujourd'hui";}
                        else if ($number == 4){ echo "/mois pendant 4 mois à compter d'aujourd'hui";}
                        ?>
                    </small>
                </h2>
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
<script src="../../js/paymentSubscription.js"></script>

<?php
require "../footer.php";
?>

