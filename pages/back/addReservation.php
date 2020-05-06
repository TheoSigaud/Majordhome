<?php
require "headerBack.php";

if (!isset($_SESSION['idCustomer'])){
    header('Location: customer.php');
}

$req = $connect->prepare("SELECT nombreServices FROM souscription_abonnement WHERE statut = 0 AND FK_idPersonne =".$_SESSION['idCustomer']);
$req->execute(array());
$count = $req->rowCount();

if ($count == 0){
    $_SESSION["service"] = 'Le client ne possède pas d\'abonnement';
    header('Location: reservationBack.php?id='.$_SESSION['idCustomer']);
}

foreach ($req->fetchAll() as $numberService) {
    if ($numberService['nombreServices'] == 0){
        $_SESSION["numberService"] = 'Le client a épuisé son abonnement';
        header('Location: reservationBack.php?id='.$_SESSION['idCustomer']);
    }
}



?>



    <section >
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Réservations</h1>
            <hr class="hr">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="form">
                        <div class="input-group">

                            <select class="custom-select" id="inputGroupSelect01">
                                <option selected>Sélectionnez une catégorie de service ...</option>
                                <?php
                                echo "test";
                                ?>

                                <?php


                                $query = $connect->query('SELECT idCategorie,nom FROM categorie;');
                                $query->execute();


                                foreach ($query->fetchAll() as $value) {

                                    echo "<option value='1'>".$value['nom']."</option>";

                                }

                                ?>


                            </select>


                        </div>
                    </div>

                </div>

                <div class="col-md-5">

                    <?php
                    echo '<a href="requestServiceBack.php?id='. $_SESSION['idCustomer'] .'"><button class="btn btnServices">Demande de service</button></a>';

                    ?>
                </div>

            </div>

            <div class="row pt-5 ">



                <?php
                $data = $connect->query("SELECT idService, nom, prix, description FROM service WHERE statut = 1");
                foreach ($data->fetchAll() as $key => $service) {
                    $service['prix'] = $service['prix']/100;
                    echo '<div class="col-md-3">';
                    echo '<div class="card servicesCard">';
                    echo '<div class="card-header cardHeader">';
                    echo '<h5 class="text-center">'.$service["nom"].'</h5>';
                    echo "</div>";
                    echo '<div class="card-body text-center">';
                    echo '<h3 class="card-title">'.$service["prix"].' € <small>/h</small></h3>';
                    echo '<p>'.$service["description"].'</p>';
                    echo '<a href="registerServicesBack.php?id='.$service["idService"].'" class="btn btnServices btn-block ">Réserver</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>

            </div>
    </section>





<?php
require "../footer.php";
?>