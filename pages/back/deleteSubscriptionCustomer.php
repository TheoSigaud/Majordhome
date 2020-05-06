<?php
session_start ();

if (!isset($_SESSION['user']) || ($_SESSION['user']['statut'] != 2 && $_SESSION['user']['statut'] != 3)) {
    header('Location: ../login.php');
}

require("../functions.php");
$connect = connectDb();

if(!empty($_POST['idSubscriptionCustomer'])) {

    $idSubscriptionCustomer = $_POST['idSubscriptionCustomer'];


    $req = $connect->prepare("UPDATE souscription_abonnement set statut =:statut WHERE idSouscriptionAbonnement =:id;");
    $req->execute([
        ':statut'=>-1,
        ':id'=>$idSubscriptionCustomer
    ]);

    $req = $connect->prepare("UPDATE facture set statut =:statut WHERE FK_idSouscriptionAbonnement =:id;");
    $req->execute([
        ':statut'=>-1,
        ':id'=>$idSubscriptionCustomer
    ]);

}



?>