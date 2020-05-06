<?php
session_start();

if (!isset($_SESSION['user']) || ($_SESSION['user']['statut'] != 2 && $_SESSION['user']['statut'] != 3)) {
    header('Location: ../login.php');
}

require("../functions.php");
$connect = connectDb();

if (!isset($_SESSION['idUpdateReservationBack']) || !isset($_SESSION['idCaracteristique']) || !isset($_POST) || !isset($_SESSION['priceService'])) {
    header('Location: customer.php');
}

$id = $_SESSION['idUpdateReservationBack'];
$idCaracteristique = $_SESSION['idCaracteristique'];
unset($_SESSION['idCaracteristique']);
unset($_SESSION['idUpdateReservationBack']);

$valueService = [];

foreach ($_POST as $key => $value) {
    $valueService[] = $value;
}


$confirm[] = "La réservation a bien été modifié";
$_SESSION["confirmFormAuth"] = $confirm;


$req = $connect->prepare("UPDATE souscription_service set dateIntervention =:dateIntervention, duree =:duree WHERE idSouscriptionService =:id;");
$req->execute([':dateIntervention' => $valueService[0],
    ':duree'=> $valueService[1],
    ':id' => $id
]);


for ($i = 0; $i < count($idCaracteristique); $i++) {
    $req = $connect->prepare("UPDATE donnees_service set information =:information WHERE FK_idSouscriptionService =:id AND FK_idCaracteristique =:idCaracteristique;");
    $req->execute([':information' => $valueService[$i + 2],
        ':id' => $id,
        ':idCaracteristique'=>$idCaracteristique[$i]
    ]);
}


header("Location: reservationBack.php?id=".$_SESSION['idCustomer']);


