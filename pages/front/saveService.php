<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['statut'] != 0) {
    header('Location: ../login.php');
}

if (!isset($_SESSION['idService']) || !isset($_SESSION['idCaracteristique']) || !isset($_SESSION['valueService']) || !isset($_SESSION['priceService'])){
    header('Location: services.php');
}

require("../functions.php");
$connect = connectDb();

$idService = $_SESSION['idService'];
$idCaracteristique = $_SESSION['idCaracteristique'];
$valueService = $_SESSION['valueService'];
$priceService = $_SESSION['priceService'];
unset($_SESSION['idService']);
unset($_SESSION['idCaracteristique']);
unset($_SESSION['valueService']);


$number = $valueService[count($valueService)-1];

function pwdGenerator($numberCaracteres, $string = 'abcdefghigklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789')
{
    $numberLetters = strlen($string) - 1;
    $generation = '';
    for($i=0; $i < $numberCaracteres; $i++)
    {
        $pos = mt_rand(0, $numberLetters);
        $caractere = $string[$pos];
        $generation .= $caractere;
    }
    return $generation;
}

$idSouscriptionService = pwdGenerator(10);


checkId($idSouscriptionService, $connect);

function checkId($idSouscriptionService, $connect)
{
    $query = $connect->query('SELECT idSouscriptionService FROM souscription_service;');
    $query->execute();
    foreach ($query->fetchAll() as $value) {

        if ($idSouscriptionService == $value['idSouscriptionService']) {
            $idSouscriptionService = pwdGenerator(10);
            checkId($idSouscriptionService, $connect);
        }

    }
}
if ($valueService[0] < date('Y-m-d')) {
    $_SESSION["dateService"] = 'Vous ne pouvez pas choisir une date ultérieure';
    header('Location: registerServices.php?id='.$idService);
}else {
    $req = $connect->prepare("SELECT nombreServices FROM souscription_abonnement WHERE statut = 0 AND FK_idPersonne =" . $_SESSION['user']['idPersonne']);
    $req->execute(array());
    $numberService = $req->fetch();

    if ($numberService['nombreServices'] == 0) {
        $_SESSION["service"] = 'Vous avez épuisé votre abonnement';
        header('Location: services.php');
    }

    if ($numberService['nombreServices']>0) {
        $numberService['nombreServices']--;
    }

    $req = $connect->prepare("UPDATE souscription_abonnement set nombreServices =:nombreServices WHERE FK_idPersonne =:id AND statut =:statut;");
    $req->execute([':nombreServices' => $numberService['nombreServices'],
        ':id' => $_SESSION['user']['idPersonne'],
        ':statut' => 0
    ]);


    $req = $connect->prepare('INSERT INTO souscription_service(FK_idPersonne, FK_idService, dateIntervention, duree, idSouscriptionService, statutReservation) VALUES(:FK_idPersonne, :FK_idService, :dateIntervention, :duree, :idSouscriptionService, :statutReservation)');
    $req->execute([':FK_idPersonne' => $_SESSION['user']['idPersonne'],
        ':FK_idService' => $idService,
        'dateIntervention' => $valueService[0],
        'duree' => $valueService[1],
        'idSouscriptionService' => $idSouscriptionService,
        'statutReservation' => 0
    ]);


    for ($i = 0; $i < count($idCaracteristique); $i++) {
        $req = $connect->prepare('INSERT INTO donnees_service(information, FK_idSouscriptionService, FK_idCaracteristique) VALUES(:information, :FK_idSouscriptionService, :FK_idCaracteristique)');
        $req->execute([':information' => $valueService[$i + 2],
            ':FK_idSouscriptionService' => $idSouscriptionService,
            ':FK_idCaracteristique' => $idCaracteristique[$i]
        ]);
    }

    if ($number != 1) {
        $req = $connect->prepare('INSERT INTO facture(prixTotal, sommeVersee, sommeRestante, statut, FK_idPersonne, FK_idSouscriptionService, nombreEcheance) VALUES(:prixTotal, :sommeVersee, :sommeRestante, :statut, :FK_idPersonne, :FK_idSouscriptionService, :nombreEcheance)');
        $req->execute([':prixTotal' => $priceService,
            ':sommeVersee' => $priceService / $number,
            ':sommeRestante' => $priceService - ($priceService / $number),
            ':statut' => 0,
            ':FK_idPersonne' => $_SESSION['user']['idPersonne'],
            ':FK_idSouscriptionService' => $idSouscriptionService,
            ':nombreEcheance' => $number
        ]);

        $req = $connect->prepare("SELECT idFacture FROM facture WHERE FK_idSouscriptionService = '" . $idSouscriptionService . "'");
        $req->execute(array());
        $invoice = $req->fetch();

        $data = $connect->prepare('INSERT INTO versement(date, somme, statut, FK_idFacture, datePaiement) VALUES(:date, :somme, :statut, :FK_idFacture, :datePaiement)');
        $data->execute([':date' => date('Y-m-d H:i:s'),
            ':somme' => $priceService / $number,
            ':statut' => 1,
            ':FK_idFacture' => $invoice['idFacture'],
            ':datePaiement' => date('Y-m-d H:i:s')
        ]);

        for ($i = 1; $i < $number; $i++) {

            $date = new DateTime();
            $date->add(new DateInterval('P' . $i . 'M'));

            $data = $connect->prepare('INSERT INTO versement(date, somme, statut, FK_idFacture) VALUES(:date, :somme, :statut, :FK_idFacture)');
            $data->execute([':date' => $date->format('Y-m-d H:i:s'),
                ':somme' => 0,
                ':statut' => 0,
                ':FK_idFacture' => $invoice['idFacture']
            ]);
        }
    } else {
        $req = $connect->prepare('INSERT INTO facture(prixTotal, sommeVersee, sommeRestante, statut, FK_idPersonne, FK_idSouscriptionService, dateFinFacturation, nombreEcheance) VALUES(:prixTotal, :sommeVersee, :sommeRestante, :statut, :FK_idPersonne, :FK_idSouscriptionService, :dateFinFacturation, :nombreEcheance)');
        $req->execute([':prixTotal' => $priceService,
            ':sommeVersee' => $priceService,
            ':sommeRestante' => 0,
            ':statut' => 1,
            ':FK_idPersonne' => $_SESSION['user']['idPersonne'],
            ':FK_idSouscriptionService' => $idSouscriptionService,
            ':dateFinFacturation' => date('Y-m-d H:i:s'),
            ':nombreEcheance' => $number
        ]);

        $req = $connect->prepare("SELECT idFacture FROM facture WHERE FK_idSouscriptionService = '" . $idSouscriptionService . "'");
        $req->execute(array());
        $invoice = $req->fetch();

        $data = $connect->prepare('INSERT INTO versement(date, somme, statut, FK_idFacture, datePaiement) VALUES(:date, :somme, :statut, :FK_idFacture, :datePaiement)');
        $data->execute([':date' => date('Y-m-d H:i:s'),
            ':somme' => $priceService,
            ':statut' => 1,
            ':FK_idFacture' => $invoice['idFacture'],
            ':datePaiement' => date('Y-m-d H:i:s')
        ]);
    }
}
header('Location: success.php');
?>