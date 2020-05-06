<?php
session_start();
require('../functions.php');

$connect = connectDb();

if(count($_POST) == 7
    && !empty($_POST['mail'])
    && !empty($_POST['request'])
    && !empty($_POST['priceEur'])
    && !empty($_POST['priceCent'])
    && !empty($_POST['informations'])
    && !empty($_POST['id'])
    && !empty($_POST['categ'])
   
){


$dateEmission = date("Y-m-d");



$request = $_POST['request'];
$mail = $_POST['mail'];
$priceEur = $_POST['priceEur'];
$priceCent = $_POST['priceCent'];
$informations = $_POST['informations'];
$idSouscription = trim($_POST['id']);
$errors = [];

if( !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            
            $errors['email'] = "L'email que vous avez indiqué n'est pas valide.";
} else {

	$req = $connect->prepare("SELECT idPersonne FROM personne WHERE mail = :mail");
    $req->execute([":mail" => $mail]);

    $data = $req->fetch();
           
            if (empty($data)) {
                
                $errors['email']= "L'email n'existe pas";
            }
       }



$queryPrepared = $connect->prepare('SELECT idSouscriptionService FROM souscription_service WHERE idSouscriptionService = ?');
$queryPrepared->execute([$idSouscription]);
$res = $queryPrepared->fetch();


if (empty($res)) {


	$errors['idSouscription'] = "Identifiant incorrect !";
}



if (strlen($mail) > 100 || strlen($mail) < 2) {
	 $errors['request'] = "Demande trop long";
}


if(!preg_match('/^[0-9]+$/', $priceEur)) {
        $errors['priceEur'] = "Les euros indiqués ne sont pas valides.";
    }

    if(!preg_match('/^[0-9][0-9]$/', $priceCent)) {
        $errors['priceCent'] = "Les centimes indiqués ne sont pas valides. Il est obligatoire d'y insérer 2 chiffres.";
    }




 $price = $priceEur.$priceCent;



	if(empty($errors)) {



		$id = $data[0];


        $select = $connect->prepare('SELECT idCaracteristique FROM caracteristique WHERE nom = "Categorie" ');
        $select->execute();
        $carac = $select->fetch();


        $updt = $connect->prepare("UPDATE donnees_service SET information = :categ WHERE FK_idSouscriptionService = :service AND FK_idCaracteristique = :id ");


         $updt->execute([

            ":categ" => $_POST['categ'],
            ":service" => $idSouscription,
            ":id" => $carac[0]

        ]);

     	$query = $connect->prepare("INSERT INTO devis(dateEmission,titre,description,prix,statut,FK_idPersonne,FK_idSouscriptionService) VALUES(:dateEmission,:titre,:description,:prix,0,:id,:idSouscription)");

     	$query->execute([

     		":dateEmission"=>$dateEmission,
     		":titre"=>$request,
     		":description"=>$informations,
     		":prix"=>$price,
     		":id"=>$id,
     		":idSouscription"=>$idSouscription

     	]);




        $confirm[] = "Devis créé";
        $_SESSION["confirmQuote"] = $confirm;
        header("Location: displayQuote.php");



        
    }else{

    	$_SESSION["errorsQuote"] = $errors;
        header("Location: requestAccepted.php");

    }
















}