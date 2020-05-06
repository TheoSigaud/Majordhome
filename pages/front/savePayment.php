<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['statut'] != 0) {
    header('Location: ../login.php');
}

if (!isset($_SESSION['pricePayment']) || !isset($_SESSION['numberPayment'])){
    header('Location: history.php');
}

$pricePayment = $_SESSION['pricePayment'];
$numberPayment = $_SESSION['numberPayment'];
$idFacturePayment = $_SESSION['idFacturePayment'];

unset($_SESSION['pricePayment']);
unset($_SESSION['numberPayment']);
unset($_SESSION['idFacturePayment']);

require("../functions.php");
$connect = connectDb();


for ($i = 0; $i < count($numberPayment); $i++){
    $req = $connect->prepare("UPDATE versement set somme =:somme, statut =:statut, datePaiement =:datePaiement WHERE idVersement =:id;");
    $req->execute([':somme'=>$pricePayment/count($numberPayment),
        ':statut'=> 1,
        ':datePaiement'=> date('Y-m-d H:i:s'),
        ':id'=>$numberPayment[$i]
    ]);
}


$data = $connect->prepare("SELECT statut, somme FROM versement WHERE FK_idFacture =".$idFacturePayment);
$data->execute(array());
$payment = $data->fetchAll(PDO::FETCH_ASSOC);


$data = $connect->prepare("SELECT prixTotal FROM facture WHERE idFacture = ".$idFacturePayment." AND FK_idPersonne =".$_SESSION['user']['idPersonne']);
$data->execute(array());
$bill = $data->fetch();

$countCheck = 0;
$amount = 0;

foreach ($payment as $value) {
    $amount += $value['somme'];
    if ($value['statut'] == 0){
        $countCheck++;
    }
}

if ($countCheck == 0){
    $req = $connect->prepare("UPDATE facture set statut =:statut, dateFinFacturation =:dateFinFacturation, sommeRestante =:sommeRestante, sommeVersee =:sommeVersee WHERE idFacture =:id AND FK_idPersonne =:idPersonne;");
    $req->execute([':statut'=> 1,
        ':dateFinFacturation'=> date('Y-m-d H:i:s'),
        ':sommeRestante'=> 0,
        ':sommeVersee'=> $amount,
        ':id'=>$idFacturePayment,
        ':idPersonne'=> $_SESSION['user']['idPersonne']
    ]);
}else{
    $req = $connect->prepare("UPDATE facture set sommeRestante =:sommeRestante, sommeVersee =:sommeVersee WHERE idFacture =:id AND FK_idPersonne =:idPersonne;");
    $req->execute([':sommeRestante'=> $bill['prixTotal'] - $amount,
        ':sommeVersee'=> $amount,
        ':id'=>$idFacturePayment,
        ':idPersonne'=> $_SESSION['user']['idPersonne']
    ]);
}



header('Location: success.php');
?>