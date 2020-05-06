<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['statut'] != 0) {
    header('Location: ../login.php');
}

if (!isset($_SESSION['dateTime']) || !isset($_SESSION['idSubscription'])){
    header('Location: subscription.php');
}

require("../functions.php");
$connect = connectDb();

$priceSubscription = $_SESSION['priceSubscription'];
$dateTime = $_SESSION['dateTime'];
$idSubscription = $_SESSION['idSubscription'];
$number = $_SESSION['numberSubscription'];
unset($_SESSION['dateTime']);
unset($_SESSION['idSubscription']);


$date = explode(":", $dateTime);

$days = date('d') + $date[2];
$months = date('m') + $date[1];
$years = date('Y') + $date[0];
$time = date('H:i:s');

$endTime = $years.'-'.$months.'-'.$days.' '.$time;

$format = 'Y-m-d H:i:s';
$date = DateTime::createFromFormat($format, $endTime);

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


$idSouscriptionAbonnement = pwdGenerator(10);


checkId($idSouscriptionAbonnement, $connect);

function checkId($idSouscriptionAbonnement, $connect)
{
    $query = $connect->query('SELECT idSouscriptionAbonnement FROM souscription_abonnement;');
    $query->execute();
    foreach ($query->fetchAll() as $value) {

        if ($idSouscriptionAbonnement == $value['idSouscriptionAbonnement']) {
            $idSouscriptionAbonnement = pwdGenerator(10);
            checkId($idSouscriptionAbonnement, $connect);
        }

    }
}

$data = $connect->prepare("SELECT temps FROM abonnement WHERE idAbonnement = ".$idSubscription);
$data->execute(array());
$numberServices = $data->fetch();


$req = $connect->prepare('INSERT INTO souscription_abonnement(idSouscriptionAbonnement, dateFin, FK_idPersonne, FK_idAbonnement, statut, nombreServices) VALUES(:idSouscriptionAbonnement, :date, :FK_idPersonne, :FK_idSubscription, :statut, :nombreServices)');
$req->execute([':idSouscriptionAbonnement'=> $idSouscriptionAbonnement,
    ':date'=>$endTime,
    ':FK_idPersonne'=>  $_SESSION['user']['idPersonne'],
    ':FK_idSubscription'=>  $idSubscription,
    ':statut'=> 0,
    ':nombreServices'=> $numberServices['temps']
]);

if ($number != 1) {
    $req = $connect->prepare('INSERT INTO facture(prixTotal, sommeVersee, sommeRestante, statut, FK_idPersonne, FK_idSouscriptionAbonnement, nombreEcheance) VALUES(:prixTotal, :sommeVersee, :sommeRestante, :statut, :FK_idPersonne, :FK_idSouscriptionAbonnement, :nombreEcheance)');
    $req->execute([':prixTotal' => $priceSubscription,
        ':sommeVersee' => $priceSubscription / $number,
        ':sommeRestante' => $priceSubscription - ($priceSubscription / $number),
        ':statut' => 0,
        ':FK_idPersonne' => $_SESSION['user']['idPersonne'],
        ':FK_idSouscriptionAbonnement' => $idSouscriptionAbonnement,
        ':nombreEcheance'=> $number
    ]);

    $req = $connect->prepare("SELECT idFacture FROM facture WHERE FK_idSouscriptionAbonnement = '".$idSouscriptionAbonnement."'");
    $req->execute(array());
    $invoice = $req->fetch();

    $data = $connect->prepare('INSERT INTO versement(date, somme, statut, FK_idFacture, datePaiement) VALUES(:date, :somme, :statut, :FK_idFacture, :datePaiement)');
    $data->execute([':date' => date('Y-m-d H:i:s'),
        ':somme'=> $priceSubscription / $number,
        ':statut'=> 1,
        ':FK_idFacture'=> $invoice['idFacture'],
        ':datePaiement'=> date('Y-m-d H:i:s')
    ]);

    for ($i = 1; $i < $number; $i++){

        $date = new DateTime();
        $date->add(new DateInterval('P'.$i.'M'));

        $data = $connect->prepare('INSERT INTO versement(date, somme, statut, FK_idFacture) VALUES(:date, :somme, :statut, :FK_idFacture)');
        $data->execute([':date' => $date->format('Y-m-d H:i:s'),
            ':somme'=> 0,
            ':statut'=> 0,
            ':FK_idFacture'=> $invoice['idFacture']
        ]);
    }
}else{
    $req = $connect->prepare('INSERT INTO facture(prixTotal, sommeVersee, sommeRestante, statut, FK_idPersonne, FK_idSouscriptionAbonnement, dateFinFacturation, nombreEcheance) VALUES(:prixTotal, :sommeVersee, :sommeRestante, :statut, :FK_idPersonne, :FK_idSouscriptionAbonnement, :dateFinFacturation, :nombreEcheance)');
    $req->execute([':prixTotal' => $priceSubscription,
        ':sommeVersee' => $priceSubscription / $number,
        ':sommeRestante' => $priceSubscription - ($priceSubscription / $number),
        ':statut' => 1,
        ':FK_idPersonne' => $_SESSION['user']['idPersonne'],
        ':FK_idSouscriptionAbonnement' => $idSouscriptionAbonnement,
        ':dateFinFacturation'=> date('Y-m-d H:i:s'),
        ':nombreEcheance'=> $number
    ]);

    $req = $connect->prepare("SELECT idFacture FROM facture WHERE FK_idSouscriptionAbonnement = '".$idSouscriptionAbonnement."'");
    $req->execute(array());
    $invoice = $req->fetch();

    $data = $connect->prepare('INSERT INTO versement(date, somme, statut, FK_idFacture, datePaiement) VALUES(:date, :somme, :statut, :FK_idFacture, :datePaiement)');
    $data->execute([':date' => date('Y-m-d H:i:s'),
        ':somme'=> $priceSubscription,
        ':statut'=> 1,
        ':FK_idFacture'=> $invoice['idFacture'],
        ':datePaiement'=> date('Y-m-d H:i:s')
    ]);
}

header('Location: success.php');
?>