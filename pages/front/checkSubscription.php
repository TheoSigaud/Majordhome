<?php
require "header.php";

if(!empty($_GET)){
    $id = $_GET['id'];
}else{
    $id = 0;
}


$days = date('d');
$months = date('m');
$years = date('Y');
$time = date('H:i:s');

$dateTime = $years.'-'.$months.'-'.$days.' '.$time;

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
    header('Location: /404.php');
}


$_SESSION['dateTime'] = $subscription['annee'].':'.$subscription['mois'].':'.$subscription['jours'];
$_SESSION['idSubscription'] = $id;

$price = $subscription['prix'];
$subscription['prix'] = $subscription['prix']/100;




?>



<section>
    <div class="container">
        <div class="form">
            <form id="form-payement" method="post" action="paymentSubscription.php">
                <h3 class="text-center title"><?php echo $subscription['nom']?></h3>
                <h2 class="card-title pricing-card-title"><?php echo $subscription['prix'] ?>€ TTC</h2>
                <hr class="hr">

                <div class="form-group">
                    <label for="number">Payer en:</label>
                    <select name="number" class="form-control" id="number">
                        <option value="1">1 fois</option>
                        <option value="2">2 fois</option>
                        <option value="4">4 fois</option>
                    </select>
                </div>

                <input type="submit" class="btn btn-success area" value="Payer">
            </form>

        </div>

    </div>

</section>


<?php
require "../footer.php";
?>

