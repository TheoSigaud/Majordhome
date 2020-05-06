<?php

require "headerBack.php";

if (!isset($_SESSION['idCustomer'])){
    header('Location: customer.php');
}


if(!empty($_GET)){
    $id = $_GET['id'];
}else{
    $id = 0;
}

$data = $connect->prepare("SELECT idSouscriptionService, FK_idService, duree, dateIntervention FROM souscription_service WHERE idSouscriptionService = '".$id."'");
$data->execute(array());

$count = $data->rowCount();
$souscription = $data->fetch();

if ($count == 0){
    header('Location: ../../404.php');
}


$req = $connect->prepare("SELECT idCaracteristique, nom, type FROM caracteristique WHERE idService = ".$souscription['FK_idService']);
$req->execute(array());

$_SESSION['idUpdateReservationBack'] = $id;

$idCaracteristique = [];


?>

<section >
    <form method="post" action="updateReservationBack.php">
        <div class="container borderSubscription">
            <label for="intervention" class="lab area">Date de l'intervention</label>
            <input name="intervention" type="date" id="intervention" class="form-control inputRegister" value="<?php echo $souscription['dateIntervention']?>" required="">

            <label for="time" class="lab area">Durée</label>
            <input name="time" type="time" id="time" class="form-control inputRegister" value="<?php echo $souscription['duree']?>" required="">
            <?php
            foreach ($req->fetchAll() as $caracteristique) {
                $idCaracteristique[] = $caracteristique['idCaracteristique'];
                $result = $connect->prepare("SELECT information FROM donnees_service WHERE FK_idSouscriptionService = '".$id."' AND FK_idCaracteristique = ".$caracteristique['idCaracteristique']);
                $result->execute(array());
                $value = $result->fetch();
                echo '<label for="'.$caracteristique["nom"].'" class="lab area">'.$caracteristique["nom"].'</label>';
                echo '<input name="'.$caracteristique["nom"].'" type="'.$caracteristique["type"].'" id="'.$caracteristique["nom"].'" class="form-control inputRegister" value="'.$value['information'].'" required="">';
            }
            $_SESSION['idCaracteristique'] = $idCaracteristique;
            ?>

            <input type="submit" class="btn btn-success area" value="Valider la modification">

        </div>
    </form>
</section>



<?php
require "../footer.php";
?>