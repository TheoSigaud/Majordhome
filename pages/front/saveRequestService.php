<?php
session_start();
require("../functions.php");
$connect = connectDb();



date_default_timezone_set('Europe/Paris');
if(count($_POST) >= 3
    && !empty($_POST['name'])
    && !empty($_POST['startDate'])
    && !empty($_POST['startTime'])
    
){

$name = trim($_POST['name']);
$startDate = trim($_POST['startDate']);
$startTime = trim($_POST['startTime']);

$endDate = NULL;
$endTime = NULL;
$address = NULL;
$city = NULL;
$code = NULL;
$informations = NULL;
$category = "Non défini";
$array = [];
$errors = [];



$date = date('Y-m-d');
$time = date('H:i');

$time2 = date("H:i", strtotime("+30 minutes"));




	if (strlen($name) > 80) {
		
		$errors['name'] = "Nom du service trop long !";
	}


	if (!preg_match("#\d{4}-\d{2}-\d{2}#", $startDate)){
	    
	    $errors['startDate'] = "La date de début doit être au format YYYY-MM-DD";

	}else{


		if ($startDate < $date) {
			
			$errors['startDate'] = "Erreur date de début !";
		}

	}


	if ($startDate == $date && $startTime < $time2 ) {

			$errors['startTime'] = "Erreur heure de début";	
	}



	if (isset($_POST['endDate']) && !empty($_POST['endDate'])) {
		
		$endDate = trim($_POST['endDate']);

		if (!preg_match("#\d{4}-\d{2}-\d{2}#", $endDate)){
		    
		    $errors['endDate'] = "La date de fin doit être au format YYYY-MM-DD";

		}else{

			if ($endDate < $startDate) {
				
				$errors['endDate'] = "Erreur date de fin !";
			}

		}


	}


	if (isset($_POST['endTime']) && !empty($_POST['endTime'])) {
		
		$endTime = trim($_POST['endTime']);

		if ($startDate == $date && $endTime < $startTime || empty($endDate) && $endTime < $startTime ) {

			$errors['endTime'] = "Erreur heure de fin";	
		}

	}

	if (isset($_POST['address']) && !empty($_POST['address'])) {

		$address = trim($_POST['address']);

	}

	if (isset($_POST['city']) && !empty($_POST['city'])) {

		$city = trim($_POST['city']);

	}

	if (isset($_POST['code']) && !empty($_POST['code'])) {

		$code = trim($_POST['code']);
		
		if(strlen($code) != 5 || !preg_match('/^[0-9_]+$/', $code)) {

	    	$errors['code'] = "Le code postal que vous avez indiqué n'est pas valide.";
	    }

	}


	if (isset($_POST['informations']) && !empty($_POST['-informations'])) {

		$informations = trim($_POST['informations']);

	}


	$array = array($name,$startDate,$endDate,$startTime,$endTime,$address,$informations,$category);



	if (empty($errors)) {

		
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

		checkId($idSouscriptionService, $connect);

			
		$queryPrepared = $connect->prepare("INSERT INTO souscription_service(idSouscriptionService,statutReservation,dateIntervention,FK_idPersonne,FK_idService) VALUES(:id,3,:dateIntervention,:idPersonne,0);");


		$res = $queryPrepared->execute([

			":id" =>$idSouscriptionService,
			":dateIntervention"=>$startDate,
			":idPersonne"=>$_SESSION['user']['idPersonne']

		]);

		$req = $connect->prepare("SELECT idSouscriptionService FROM souscription_service WHERE FK_idPersonne = ? AND FK_idService = 0 ORDER BY dateReservation DESC LIMIT 1" );
		$req->execute([$_SESSION["user"]['idPersonne']]);
		$dataSouscription = $req->fetch();


		$req = $connect->prepare("SELECT idCaracteristique FROM caracteristique WHERE idService = 0");
		$req->execute();
		$dataCaracteristique = $req->fetchAll(PDO::FETCH_ASSOC);


		foreach ($array as $key => $value) {

			if ($value != NULL) {

				$req = $connect->prepare("INSERT INTO donnees_service(information,FK_idSouscriptionService,FK_idCaracteristique) VALUES(:info,:idSous,:idCar)");
				$req->execute([
						":info" => $value,
						":idSous" => $dataSouscription['idSouscriptionService'],
						":idCar" => $dataCaracteristique[$key]['idCaracteristique']
				]);
			}

		

		}

		header('Location: requestService.php');

		$_SESSION["successForm"] = "Votre demande de service a bien été envoyé. Si votre demande est validé, un devis vous sera alors proposé dans la partie Devis";




	}else{


		$_SESSION["errorsForm"] = $errors;
		header('Location: requestService.php');

	}





	
}else{


	$_SESSION['errors'] = "Merci de bien vouloir remplir les champs obligatoires !";

	header('Location: requestService.php');
}