<?php
session_start();
if (!isset($_SESSION['user']) || ($_SESSION['user']['statut'] != 2 && $_SESSION['user']['statut'] != 3 )) {
    header('Location: ../index.php');
}

require('functions.php');
$connect = connectDb();

$idCustomer = $_POST['idCustomer'];
$idSouscriptionService = $_POST['idSouscriptionService'];


$req = $connect->prepare("UPDATE souscription_service set FK_idPrestataire =:FK_idPrestataire WHERE idSouscriptionService =:idSouscriptionService AND FK_idPersonne =:FK_idPersonne;");
$req->execute([':FK_idPrestataire' => NULL,
    ':idSouscriptionService'=> $idSouscriptionService,
    ':FK_idPersonne' => $idCustomer
]);

?>