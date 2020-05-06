<?php
session_start();
if (!isset($_SESSION['user']) || ($_SESSION['user']['statut'] != 2 && $_SESSION['user']['statut'] != 3)) {
    header('Location: ../index.php');
}

require('functions.php');
$connect = connectDb();

$date = $_POST['date'];

$arrayService = $connect->query("SELECT personne.idPersonne, personne.nom, personne.prenom, souscription_service.dateReservation, souscription_service.idSouscriptionService, service.nom AS nom_service, souscription_service.FK_idPrestataire, souscription_service.dateIntervention, souscription_service.duree, categorie.idCategorie FROM souscription_service, personne, service, categorie WHERE personne.idPersonne = souscription_service.FK_idPersonne AND souscription_service.statutReservation = 0 AND souscription_service.FK_idService = service.idService AND service.idCategorie = categorie.idCategorie AND DATE_FORMAT(souscription_service.dateIntervention,'%Y-%m-%d') = '" . $date . "' ORDER BY souscription_service.dateIntervention");
$arrayRequest = $connect->query("SELECT personne.idPersonne, personne.nom, personne.prenom, souscription_service.dateReservation, souscription_service.idSouscriptionService, service.nom AS nom_service, souscription_service.FK_idPrestataire, souscription_service.dateIntervention, souscription_service.duree FROM souscription_service, personne, service WHERE personne.idPersonne = souscription_service.FK_idPersonne AND souscription_service.statutReservation = 0 AND souscription_service.FK_idService = service.idService AND service.nom = 'Demande' AND DATE_FORMAT(souscription_service.dateIntervention,'%Y-%m-%d') = '" . $date . "' ORDER BY souscription_service.dateIntervention");

$rows1 = $arrayRequest->fetchAll(PDO::FETCH_ASSOC);
$rows2 = $arrayService->fetchAll(PDO::FETCH_ASSOC);



$req = $connect->query("SELECT personne.idPersonne, personne.nom, personne.prenom, categorie.idCategorie, metier.nom AS nom_metier FROM  personne, metier, categorie WHERE personne.statut = 1 AND personne.FK_metier = metier.nom AND metier.FK_categorie = categorie.idCategorie");

$rowsReq = $req->fetchAll(PDO::FETCH_ASSOC);


foreach ($rows2 as $row) {

    echo '<tr>';
    echo '<td>' . $row["prenom"] . ' ' . $row['nom'] . '</td>';
    echo '<td>' . $row['nom_service'] . '</td>';
    echo '<td>' . $row['dateReservation'] . '</td>';
    echo '<td>' . $row['dateIntervention'] . '</td>';
    echo '<td>' . $row['duree'] . '</td>';
    $timeService = explode(' ', $row['dateIntervention']); //Client

    echo '<td>';
    if (empty($row['FK_idPrestataire'])) { //Si il n'y a pas de presta
        echo '<select id="' . $row["idPersonne"] . '" class="custom-select d-block w-100">';

        foreach ($rowsReq as $rowReq) {
            $result = $connect->query("SELECT dateIntervention, duree FROM  souscription_service WHERE statutReservation = 0 AND FK_idPrestataire =" . $rowReq['idPersonne']); //Vérification de l'horaire
            $resultData = $result->fetchAll(PDO::FETCH_ASSOC);

            $tabTime = [];

            foreach ($resultData as $resData) {
                $time = explode(' ', $resData['dateIntervention']); //Récup heures Presta
                $timeIntervention = $resData['duree'];
                if ($time[0] == $date) {
                    $tabTime[] = $time[1];
                }
            }
            $countSoustraction = 0;

            if (!empty($tabTime)) {
                for ($i = 0; $i < count($tabTime); $i++) {

                    if (!empty($timeIntervention)) {
                        $dateTime = new DateTime($tabTime[$i]);//On ajoute la durée à l'heure
                        $rowExplode = explode(':', $timeIntervention);
                        $dateTime->add(new DateInterval('PT' . $rowExplode[0] . 'H'));
                        $dateTime->add(new DateInterval('PT' . $rowExplode[1] . 'M'));
                        $resultSoustraction = date('H:i:s', strtotime($timeService[1]) - strtotime($dateTime->format('H:i:s')));//Soustraction


                        $dateTimeInvers = new DateTime($timeService[1]);//On ajoute la durée à l'heure
                        $rowExplodeInvers = explode(':', $row['duree']);
                        $dateTimeInvers->add(new DateInterval('PT' . $rowExplodeInvers[0] . 'H'));
                        $dateTimeInvers->add(new DateInterval('PT' . $rowExplodeInvers[1] . 'M'));
                        $resultSoustractionInvers = date('H:i:s', strtotime($dateTimeInvers->format('H:i:s')) - strtotime($tabTime[$i]));//Soustraction

                        if ((strtotime($resultSoustraction) <= strtotime('00:30:00') && strtotime($resultSoustraction) >= strtotime('00:00:01')) || (strtotime($resultSoustractionInvers) >= strtotime('23:30:00') && strtotime($resultSoustractionInvers) <= strtotime('23:59:59')) || (strtotime($resultSoustraction) == strtotime('00:00:00')) || (strtotime($resultSoustractionInvers) == strtotime('00:00:00'))) {
                            $countSoustraction = 1;
                        }

                    } else {
                        $resultSoustraction = date('H:i:s', strtotime($timeService[1]) - strtotime($tabTime[$i]));//Soustraction

                        if ((strtotime($resultSoustraction) <= strtotime('01:00:00') && strtotime($resultSoustraction) >= strtotime('00:00:01')) || (strtotime($resultSoustraction) >= strtotime('23:00:00') && strtotime($resultSoustraction) <= strtotime('23:59:59')) || (strtotime($resultSoustraction) == strtotime('00:00:00'))) {
                            $countSoustraction = 1;
                        }
                    }


                }
            }

            if ($countSoustraction != 1 && $rowReq['idCategorie'] == $row['idCategorie']) {
                echo '<option value="' . $rowReq['idPersonne'] . '">' . $rowReq['prenom'] . ' ' . $rowReq['nom'] . ' (' . $rowReq['nom_metier'] . ')</option>';
            }
            unset($tabTime);

        }
        echo '</select>';
        echo '<button class="btn btn-success" onclick="attribution(' . $row["idPersonne"] . ',\'' . $row["idSouscriptionService"] . '\')">Attribuer</button>';
    } else {
        echo '<button class="btn btn-danger" onclick="deleteAttribution(' . $row["idPersonne"] . ',\'' . $row["idSouscriptionService"] . '\')">X</button>';
    }
    echo '</td>';
    echo '</tr>';

}



foreach ($rows1 as $row) {

    echo '<tr>';
    echo '<td>' . $row["prenom"] . ' ' . $row['nom'] . '</td>';
    echo '<td>' . $row['nom_service'] . '</td>';
    echo '<td>' . $row['dateReservation'] . '</td>';
    echo '<td>' . $row['dateIntervention'] . '</td>';
    echo '<td>' . $row['duree'] . '</td>';
    $timeService = explode(' ', $row['dateIntervention']); //Client

    echo '<td>';
    if (empty($row['FK_idPrestataire'])) { //Si il n'y a pas de presta
        echo '<select id="' . $row["idPersonne"] . '" class="custom-select d-block w-100">';

        foreach ($rowsReq as $rowReq) {
            $result = $connect->query("SELECT dateIntervention, duree FROM  souscription_service WHERE statutReservation = 0 AND FK_idPrestataire =" . $rowReq['idPersonne']); //Vérification de l'horaire
            $resultData = $result->fetchAll(PDO::FETCH_ASSOC);

            $tabTime = [];

            foreach ($resultData as $resData) {
                $time = explode(' ', $resData['dateIntervention']); //Récup heures Presta
                $timeIntervention = $resData['duree'];
                if ($time[0] == $date) {
                    $tabTime[] = $time[1];
                }
            }
            $countSoustraction = 0;

            if (!empty($tabTime)) {
                for ($i = 0; $i < count($tabTime); $i++) {

                    if (!empty($timeIntervention)) {
                        $dateTime = new DateTime($tabTime[$i]);//On ajoute la durée à l'heure
                        $rowExplode = explode(':', $timeIntervention);
                        $dateTime->add(new DateInterval('PT' . $rowExplode[0] . 'H'));
                        $dateTime->add(new DateInterval('PT' . $rowExplode[1] . 'M'));
                        $resultSoustraction = date('H:i:s', strtotime($timeService[1]) - strtotime($dateTime->format('H:i:s')));//Soustraction


                        $dateTimeInvers = new DateTime($timeService[1]);//On ajoute la durée à l'heure
                        $rowExplodeInvers = explode(':', $row['duree']);
                        $dateTimeInvers->add(new DateInterval('PT' . $rowExplodeInvers[0] . 'H'));
                        $dateTimeInvers->add(new DateInterval('PT' . $rowExplodeInvers[1] . 'M'));
                        $resultSoustractionInvers = date('H:i:s', strtotime($dateTimeInvers->format('H:i:s')) - strtotime($tabTime[$i]));//Soustraction

                        if ((strtotime($resultSoustraction) <= strtotime('00:30:00') && strtotime($resultSoustraction) >= strtotime('00:00:01')) || (strtotime($resultSoustractionInvers) >= strtotime('23:30:00') && strtotime($resultSoustractionInvers) <= strtotime('23:59:59')) || (strtotime($resultSoustraction) == strtotime('00:00:00')) || (strtotime($resultSoustractionInvers) == strtotime('00:00:00'))) {
                            $countSoustraction = 1;
                        }

                    } else {
                        $resultSoustraction = date('H:i:s', strtotime($timeService[1]) - strtotime($tabTime[$i]));//Soustraction

                        if ((strtotime($resultSoustraction) <= strtotime('01:00:00') && strtotime($resultSoustraction) >= strtotime('00:00:01')) || (strtotime($resultSoustraction) >= strtotime('23:00:00') && strtotime($resultSoustraction) <= strtotime('23:59:59')) || (strtotime($resultSoustraction) == strtotime('00:00:00'))) {
                            $countSoustraction = 1;
                        }
                    }


                }
            }
            if ($row['nom_service'] == 'Demande' && $countSoustraction != 1) {
                echo '<option value="' . $rowReq['idPersonne'] . '">' . $rowReq['prenom'] . ' ' . $rowReq['nom'] . ' (' . $rowReq['nom_metier'] . ')</option>';
            }
            unset($tabTime);

        }
        echo '</select>';
        echo '<button class="btn btn-success" onclick="attribution(' . $row["idPersonne"] . ',\'' . $row["idSouscriptionService"] . '\')">Attribuer</button>';
    } else {
        echo '<button class="btn btn-danger" onclick="deleteAttribution(' . $row["idPersonne"] . ',\'' . $row["idSouscriptionService"] . '\')">X</button>';
    }
    echo '</td>';
    echo '</tr>';

}
?>