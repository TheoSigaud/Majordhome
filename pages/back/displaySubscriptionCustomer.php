<?php
session_start ();

if (!isset($_SESSION['user']) || ($_SESSION['user']['statut'] != 2 && $_SESSION['user']['statut'] != 3)) {
    header('Location: ../login.php');
}

require("../functions.php");
$connect = connectDb();

$data = $connect->query("SELECT idAbonnement, nom, description, prix, semaine, temps, debutTemps, finTemps, idSouscriptionAbonnement FROM abonnement, souscription_abonnement WHERE abonnement.idAbonnement = souscription_abonnement.FK_idAbonnement AND souscription_abonnement.statut = 0 AND souscription_abonnement.FK_idPersonne = ".$_SESSION['idCustomer']);
$rows = $data->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row) {

    $row['prix'] = $row['prix']/100;

    echo '<div class="col-md-4">';
        echo '<div class="card shadow-sm">';
            echo '<div class="card-header">';
                echo '<h4 class="my-0 font-weight-normal">'.$row['nom'].'</h4>';
            echo "</div>";
            echo '<div class="card-body">';
                echo '<h2 class="card-title pricing-card-title">'.$row['prix'].'€ TTC <small class="text-muted">/ an</small></h2>';
                echo '<ul class="list-unstyled mt-3 mb-4">';
                    echo "<li class='liSubscription'>Bénéficiez d'un accès privilégié en illimité ".$row['semaine']."j/7, ".$row['debutTemps']."h/h".$row['finTemps'];
                    echo '<li class="liSubscription">'.$row['description'];
                    if ($row['temps'] == -1){
                        echo '<li class="liSubscription">Nombre de services illimités';
                    }else{
                        echo '<li class="liSubscription">'.$row['temps'].' services/mois';
                    }
                echo '</ul>';
                echo '<button class="btn btn-danger my-danger" onclick="show(\'' . $row["idSouscriptionAbonnement"] . '\')">Supprimer</button>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

}

                    