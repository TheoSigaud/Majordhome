<?php
require "header.php";

if (!empty($_SESSION["service"])) {
    echo "<div class='alert alert-danger'>";
    echo "<li>" . $_SESSION['service'];
    echo "</div>";
    unset($_SESSION["service"]);
}

if (!empty($_SESSION["numberService"])) {
    echo "<div class='alert alert-danger'>";
    echo "<li>" . $_SESSION['numberService'];
    echo "</div>";
    unset($_SESSION["numberService"]);
}

?>


<section class="pt-5 servicesSection">

    <div class="masthead">
        <div class="containHeader">Découvrez nos services haut de gamme !</div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="pt-4">
                    <div class="input-group">

                        <select class="custom-select" id="inputGroupSelect01">
                            <option selected>Sélectionnez une catégorie de service ...</option>

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

                <a href="requestService.php"><button class="btn btnServices">Demande de service</button></a>
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
                            echo '<a href="registerServices.php?id='.$service["idService"].'" class="btn btnServices btn-block ">Réserver</a>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }
        ?>

        </div>
    </div>

</section>



<?php
require "../footer.php";
?>