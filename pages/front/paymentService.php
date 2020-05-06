<?php
require "header.php";

if (!isset($_SESSION['idService']) || !isset($_SESSION['idCaracteristique'])){
    header('Location: services.php');
}

$id = $_SESSION['idService'];

$valueService = [];

foreach ($_POST as $key => $value) {
    $valueService[] = $value;
}

$number = $_POST['number'];

if ($number != 1 && $number != 2 && $number != 4){
    header('Location: registerServices.php?id='.$id);
}

if ($valueService[0] < date('Y-m-d')){
    $_SESSION["dateService"] = 'Vous ne pouvez pas choisir une date ultérieure';
    header('Location: registerServices.php?id='.$id);
}

$_SESSION['valueService'] = $valueService;

$req = $connect->prepare("SELECT nom, prix FROM service WHERE idService = $id");
$req->execute(array());
$service = $req->fetch();

$count = $req->rowCount();

if ($count == 0){
    header('Location: 404.php');
}

$price = $service['prix'];
$_SESSION['priceService'] = $price;
if($number != 1){
    $price = $price/$number;
}
require ('../../stripe-php-master/init.php');

\Stripe\Stripe::setApiKey('sk_test_KIoaPZUhWtezXMfycCQWaVP300pmT5edj0');

$intent = \Stripe\PaymentIntent::create([
    'amount'=> $price,
    'currency' => 'eur',
    'statement_descriptor' => 'Majordhome',
    'description' => $service['nom'],
    'payment_method_types' => ['card'],
    'setup_future_usage' => 'off_session',
]);


$price = $price/100;


?>

<section>
    <div class="container">
        <div class="form">
            <form id="form-payement">
                <h3 class="text-center title"><?php echo $service['nom']?></h3>
                <h2 class="card-title pricing-card-title"><?php echo $price ?>€
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
<script src="../../js/paymentService.js"></script>

<?php
require "../footer.php";
?>

