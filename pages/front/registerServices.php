<?php

require "header.php";

if(!empty($_GET)){
    $id = $_GET['id'];
}else{
    $id = 0;
}

$req = $connect->prepare("SELECT nombreServices FROM souscription_abonnement WHERE statut = 0 AND FK_idPersonne =".$_SESSION['user']['idPersonne']);
$req->execute(array());
$count = $req->rowCount();

if ($count == 0){
    $_SESSION["service"] = 'Vous ne possédez pas d\'abonnement';
    header('Location: services.php');
}

foreach ($req->fetchAll() as $numberService) {
    if ($numberService['nombreServices'] == 0){
        $_SESSION["numberService"] = 'Vous avez épuisé votre abonnement';
        header('Location: services.php');
    }
}
$req = $connect->prepare("SELECT idCaracteristique, nom, type FROM caracteristique WHERE idService = $id");
$req->execute(array());

$count = $req->rowCount();


$_SESSION["idService"] = $id;

$data= $connect->query("SELECT nom, prix FROM service WHERE idService = $id");

$idCaracteristique = [];

if (!empty($_SESSION["dateService"])) {
    echo "<div class='alert alert-danger'>";
    echo "<li>" . $_SESSION['dateService'];
    echo "</div>";
    unset($_SESSION["dateService"]);
}
?>

<section >
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <?php
            foreach ($data->fetchAll() as $service){
                $service['prix'] = $service['prix']/100;
                echo '<h1 class="display-4">'.$service["nom"].'</h1>';
                echo '<h5>'.$service["prix"].' €</h5>';
            }
        ?>
        <hr class="hr">
    </div>
    <form method="post" action="paymentService.php">
        <div class="container borderSubscription">
            <label for="intervention" class="lab area">Date et heure de l'intervention</label>
            <input name="intervention" type="datetime-local" id="intervention" class="form-control inputRegister" required="">

            <label for="time" class="lab area">Durée</label>
            <input name="time" type="time" id="time" class="form-control inputRegister" required="">
            <?php
                foreach ($req->fetchAll() as $caracteristique) {
                    $idCaracteristique[] = $caracteristique['idCaracteristique'];
                    echo '<label for="'.$caracteristique["nom"].'" class="lab area">'.$caracteristique["nom"].'</label>';
                    echo '<input name="'.$caracteristique["nom"].'" type="'.$caracteristique["type"].'" id="'.$caracteristique["nom"].'" class="form-control inputRegister" required="">';
                }
                $_SESSION['idCaracteristique'] = $idCaracteristique;
            ?>

            <div class="form-group">
                <label for="number">Payer en:</label>
                <select name="number" class="form-control" id="number">
                    <option value="1">1 fois</option>
                    <option value="2">2 fois</option>
                    <option value="4">4 fois</option>
                </select>
            </div>

            <input type="submit" class="btn btn-success area" value="Payer">

        </div>
    </form>
</section>



<?php
require "../footer.php";
?>
