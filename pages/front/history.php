<?php
require "header.php";
?>

<section class="pt-5 servicesSection" id="HistorySection">

        <div class="row" id="tabSection">


            <nav id="navHistory" class="col-md-3" >

                <ul class="">
                    <li class="">
                        <a  class="nav-link colorLink" onclick="displayHisSubscription()">Historique Abonnements</a>
                    </li>
                    <li class="">
                        <a class="nav-link colorLink" onclick="displayHisService()">Historique Service</a>
                    </li>
                    <li class="">
                        <a class="nav-link colorLink" onclick="displayHisBill()">Historique paiements</a>
                    </li>

                     <li class="">
                        <a class="nav-link colorLink" onclick="displayHisQuote()">Mes devis</a>
                    </li>
                </ul>

            </nav>

            <div class="col-md-9">
                <div id="tableHistory">

                    <div id="tableHisSubscription">
                        <?php

                        $connect=  connectDb();

                        $query = $connect->query('SELECT abonnement.nom,DATE_FORMAT(dateAchat,"%d/%m/%Y") as dateAchat,DATE_FORMAT(dateFin,"%d/%m/%Y") as dateFin, souscription_abonnement.statut FROM souscription_abonnement,abonnement  WHERE abonnement.idAbonnement = souscription_abonnement.FK_idAbonnement  AND FK_idPersonne ='.$_SESSION['user']['idPersonne']);
                        $query->execute();

                        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

                        echo '<table class="table" >';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th id = "titleTable" >Abonnements en cours</th>';
                        echo '<th>';
                        echo '<th>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th class="SubtitleTable">Abonnements</th>';
                        echo '<th class="SubtitleTable">Date début</th>';
                        echo '<th class="SubtitleTable">Date Fin</th>';
                        echo '</tr>';
                        echo '</thead>';

                        echo '<tbody>';

                            foreach ($rows as $row) {

                                $dateFin = time() - strtotime($row['dateFin']);
                                $now = time() - strtotime(date("Y-m-d"));
                                

                                if($dateFin < $now ){
                                    echo '<tr>';
                                    echo '<td>' . $row["nom"] . '</td>';
                                    echo '<td>' . $row["dateAchat"] . '</td>';
                                    echo '<td>' . $row["dateFin"] . '</td>';
                                    echo '</tr>';
                                }
                            }
                        echo '</tbody>';
                            echo '</table>';

                        echo '<br>';

                        echo '<table class="table" >';
                            echo '<thead>';
                            echo '<tr>';
                                echo '<th id = "titleTable" >Abonnements terminés</th>';
                                echo '<th>';
                                    echo '<th>';
                                    echo '</tr>';
                            echo '<tr>';
                                echo '<th class="SubtitleTable">Abonnements</th>';
                                echo '<th class="SubtitleTable">Date début</th>';
                                echo '<th class="SubtitleTable">Date Fin</th>';
                                echo '</tr>';
                            echo '</thead>';

                            echo '<tbody>';

                            foreach ($rows as $row) {



                                $dateFin = time() - strtotime($row['dateFin']);
                                $now = time() - strtotime(date("Y-m-d"));

                                if ($dateFin > $now ) {
                                    echo '<tr>';
                                    echo '<td>' . $row["nom"] . '</td>';
                                    echo '<td>' . $row["dateAchat"] . '</td>';
                                    echo '<td>' . $row["dateFin"] . '</td>';
                                    echo '</tr>';
                                }
                            }
                            echo '</tbody>';
                            echo '</table>';
                        ?>

                    </div>

                    <div id="tableHisServices">

                        <?php
                        $connect=  connectDb();

                        $query = $connect->query('SELECT service.nom,DATE_FORMAT(dateReservation,"%d/%m/%Y") as dateAchat,DATE_FORMAT(dateIntervention,"%d/%m/%Y") as dateFin, souscription_service.statutReservation as statut FROM souscription_service,service  WHERE service.idService = souscription_service.FK_idService  AND souscription_service.FK_idPersonne ='.$_SESSION['user']['idPersonne']);
                        $query->execute();

                        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

                        echo '<table class="table" >';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th id = "titleTable" >Services en cours ou à venir </th>';
                        echo '<th>';
                        echo '<th>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th class="SubtitleTable">Services</th>';
                        echo '<th class="SubtitleTable">Date début</th>';
                        echo '<th class="SubtitleTable">Date Fin</th>';
                        echo '</tr>';
                        echo '</thead>';

                        echo '<tbody>';

                        foreach ($rows as $row) {

                            if($row["statut"] ==0) {
                                echo '<tr>';
                                echo '<td>' . $row["nom"] . '</td>';
                                echo '<td>' . $row["dateAchat"] . '</td>';
                                echo '<td>' . $row["dateFin"] . '</td>';
                                echo '</tr>';
                            }
                        }
                        echo '</tbody>';
                        echo '</table>';

                        echo '<br>';

                        echo '<table class="table" >';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th id = "titleTable" >Services terminés</th>';
                        echo '<th>';
                        echo '<th>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th class="SubtitleTable">Services</th>';
                        echo '<th class="SubtitleTable">Date début</th>';
                        echo '<th class="SubtitleTable">Date Fin</th>';
                        echo '</tr>';
                        echo '</thead>';

                        echo '<tbody>';

                        foreach ($rows as $row) {

                            if ($row["statut"] == 1) {
                                echo '<tr>';
                                echo '<td>' . $row["nom"] . '</td>';
                                echo '<td>' . $row["dateAchat"] . '</td>';
                                echo '<td>' . $row["dateFin"] . '</td>';
                                echo '</tr>';
                            }
                        }
                        echo '</tbody>';
                        echo '</table>';
                        ?>

                    </div>

                    <div id="tableHisBill">

                        <div id="RadioButton" class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio"checked onchange="displayHisBill()"> Services
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" onchange="displayHisBillSouscription()"> Abonnements
                            </label>
                        </div>

                        <?php
                        $connect=  connectDb();

                        $query = $connect->query('SELECT facture.statut,facture.idFacture,service.nom,DATE_FORMAT(facture.dateEmission,"%d/%m/%Y") as dateEmission,facture.prixTotal,facture.sommeRestante,souscription_service.idSouscriptionService as idSouscription FROM service, facture, souscription_service WHERE facture.FK_idSouscriptionService = souscription_service.idSouscriptionService AND souscription_service.FK_idService = service.idService AND facture.FK_idPersonne ='.$_SESSION['user']['idPersonne']);
                        $query->execute();

                        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

                        echo '<table class="table" >';

                        echo '<thead>';
                        echo '<tr>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th>Factures à regler</th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th class="SubtitleTable">Numéro Facture</th>';
                        echo '<th class="SubtitleTable">Nom Service</th>';
                        echo '<th class="SubtitleTable">Date Emission</th>';
                        echo '<th class="SubtitleTable">Prix total</th>';
                        echo '<th class="SubtitleTable">Somme Restante</th>';
                        echo '<th class="SubtitleTable">PDF</th>';
                        echo '<th class="SubtitleTable">Regler</th>';
                        echo '</tr>';
                        echo '</thead>';

                        echo '<tbody>';

                        foreach ($rows as $row) {

                            if($row["statut"] ==0) {



                                echo '<tr>';
                                echo '<td>' . $row["idFacture"] . '</td>';
                                echo '<td>' . $row["nom"] . '</td>';
                                echo '<td>' . $row["dateEmission"] . '</td>';
                                echo '<td>' . $row["prixTotal"]/100 . '€</td>';
                                echo '<td>' . $row["sommeRestante"]/100 . '€</td>';
                                echo '<td class ="buttonCase" ><a href="bill.php?id=\''.$row["idSouscription"].'\'" class="btn btn-dark">PDF</a></td>';
                                echo '<td class ="buttonCase"><a type="button" class="btn btn-warning" href="checkPayment.php?id=\''.$row["idSouscription"].'\'">Regler</a></td>';
                                echo '</tr>';
                            }
                        }
                        echo '</tbody>';
                        echo '</table>';

                        echo '<br>';

                        echo '<table class="table table-hover" >';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th id = "titleTable" >Factures réglées</th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th class="SubtitleTable">Numéro Facture</th>';
                        echo '<th class="SubtitleTable">Service</th>';
                        echo '<th class="SubtitleTable">Date Emission</th>';
                        echo '<th class="SubtitleTable">Prix total</th>';
                        echo '<th class="SubtitleTable">PDF</th>';
                        echo '</tr>';
                        echo '</thead>';

                        echo '<tbody>';

                        foreach ($rows as $row) {

                            if ($row["statut"] == 1) {
                                echo '<tr>';
                                echo '<td>' . $row["idFacture"] . '</td>';
                                echo '<td>' . $row["nom"] . '</td>';
                                echo '<td>' . $row["dateEmission"] . '</td>';
                                echo '<td>' . $row["prixTotal"]/100 . '€</td>';
                                echo '<td class ="buttonCase" ><a href="bill.php?id=\''.$row["idSouscription"].'\'" class="btn btn-dark">PDF</a></td>';
                                echo '</tr>';
                            }
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '<br>';

                        ?>

                    </div>

                    <div id="tableHisBillSouscription">
                        <div id="RadioButton" class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio"checked onchange="displayHisBill()"> Services
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" onchange="displayHisBillSouscription()"> Abonnements
                            </label>
                        </div>

                        <?php
                        $connect=  connectDb();

                        $query = $connect->query('SELECT facture.statut,facture.idFacture,abonnement.nom,DATE_FORMAT(facture.dateEmission,"%d/%m/%Y") as dateEmission,facture.prixTotal,facture.sommeRestante,souscription_abonnement.idSouscriptionAbonnement as idSouscription FROM abonnement, facture, souscription_abonnement WHERE facture.FK_idSouscriptionAbonnement = souscription_abonnement.idSouscriptionAbonnement AND souscription_abonnement.FK_idAbonnement = abonnement.idAbonnement AND facture.FK_idPersonne ='.$_SESSION['user']['idPersonne']);
                        $query->execute();

                        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

                        echo '<table class="table" >';

                        echo '<thead>';
                        echo '<tr>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th>Factures à regler</th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th class="SubtitleTable">Numéro Facture</th>';
                        echo '<th class="SubtitleTable">Nom Abonnement</th>';
                        echo '<th class="SubtitleTable">Date Emission</th>';
                        echo '<th class="SubtitleTable">Prix total</th>';
                        echo '<th class="SubtitleTable">Somme Restante</th>';
                        echo '<th class="SubtitleTable">PDF</th>';
                        echo '<th class="SubtitleTable">Regler</th>';
                        echo '</tr>';
                        echo '</thead>';

                        echo '<tbody>';

                        foreach ($rows as $row) {

                            if($row["statut"] ==0) {

                                echo '<tr>';
                                echo '<td>' . $row["idFacture"] . '</td>';
                                echo '<td>' . $row["nom"] . '</td>';
                                echo '<td>' . $row["dateEmission"] . '</td>';
                                echo '<td>' . $row["prixTotal"]/100 . '€</td>';
                                echo '<td>' . $row["sommeRestante"]/100 . '€</td>';
                                echo '<td class ="buttonCase" ><a href="bill.php?id=\''.$row["idSouscription"].'\'" class="btn btn-dark">PDF</a></td>';
                                echo '<td class ="buttonCase"><a type="button" class="btn btn-warning" href="checkPayment.php?id=\''.$row["idSouscription"].'\'">Regler</a></td>';
                                echo '</tr>';
                            }
                        }
                        echo '</tbody>';
                        echo '</table>';

                        echo '<br>';

                        echo '<table class="table" >';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th id = "titleTable" >Factures réglées</th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th class="SubtitleTable">Numéro Facture</th>';
                        echo '<th class="SubtitleTable">Abonnement</th>';
                        echo '<th class="SubtitleTable">Date Emission</th>';
                        echo '<th class="SubtitleTable">Prix total</th>';
                        echo '<th class="SubtitleTable">PDF</th>';
                        echo '</tr>';
                        echo '</thead>';

                        echo '<tbody>';

                        foreach ($rows as $row) {

                            if ($row["statut"] == 1) {
                                echo '<tr>';
                                echo '<td>' . $row["idFacture"] . '</td>';
                                echo '<td>' . $row["nom"] . '</td>';
                                echo '<td>' . $row["dateEmission"] . '</td>';
                                echo '<td>' . $row["prixTotal"]/100 . '€</td>';
                                echo '<td class ="buttonCase" ><a href="bill.php?id=\''.$row["idSouscription"].'\'" class="btn btn-dark">PDF</a></td>';
                                echo '</tr>';
                            }
                        }
                        echo '</tbody>';
                        echo '</table>';


                        echo '<br>';

                        ?>

                    </div>


                    <div id="tableHisQuote">
                        <?php


                         $connect=  connectDb();

                        $query = $connect->prepare('SELECT idDevis,DATE_FORMAT(dateEmission,"%d/%m/%Y") as dateEmission,titre,statut FROM devis WHERE FK_idPersonne = :id');
                        $query->execute([":id" => $_SESSION['user']["idPersonne"]]);

                        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

                     
                        echo '<table class="table" >';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th id ="titleTable" >Devis</th>';
                        echo '<th>';
                        echo '<th>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th class="SubtitleTable">Numéro Devis</th>';
                        echo '<th class="SubtitleTable">Titre</th>';
                        echo '<th class="SubtitleTable">Date</th>';
                        echo '<th class="SubtitleTable">Actions</th>';
                        echo '</tr>';
                        echo '</thead>';

                        echo '<tbody>';

                           foreach ($rows as $row) {

                             echo '<tr>';
                                echo '<td>' . $row["idDevis"] . '</td>';
                                echo '<td>' . $row["titre"] . '</td>';
                                echo '<td>' . $row["dateEmission"] . '</td>';
                                echo '<td> <a href="generateQuote.php?id='. $row['idDevis'].'" class ="btn btn-dark">PDF</a>';

                                if ($row['statut'] == 0) {
                                    
                                    echo ' <a href="acceptQuote.php?id='. $row['idDevis'].'" class ="btn btn-warning">Accepter</a>';
                                }
                                   
                                echo '</td>';
                            echo '</tr>';

                           }

                           
                        echo '</tbody>';
                        echo '</table>';
                        ?>

                    </div>
            </div>
        </div>

</section>

    <script src="../../js/history.js"></script>

<?php
require "../footer.php";
?>