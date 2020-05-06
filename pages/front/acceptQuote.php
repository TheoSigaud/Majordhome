<?php
require('../functions.php');
if (isset($_GET['id']) && !empty($_GET['id'])) {
	
	$connect = connectDb();

	$date = date("Y-m-d");
	$updt = $connect->prepare("UPDATE devis SET statut = 1, dateValidation = ? WHERE idDevis = ?");
	$updt->execute([$date,$_GET['id']]);


	$getData = $connect->prepare("SELECT prix,FK_idSouscriptionService,FK_idPersonne FROM devis WHERE idDevis = ?");
	$getData->execute([$_GET['id']]);
	$res = $getData->fetch(PDO::FETCH_ASSOC);



	$prixTotal = $res["prix"];
	$idPersonne = $res["FK_idPersonne"];
	$idService = $res["FK_idSouscriptionService"];


	$updt = $connect->prepare("UPDATE souscription_service SET statutReservation = 0 WHERE idSouscriptionService = ?");
	$updt->execute([$idService]);



	$time = strtotime(date("Y-m-d H:i:s"));
	$final = date("Y-m-d H:i:s", strtotime("+1 month", $time));


	$query = $connect->prepare('INSERT INTO facture(prixTotal,sommeVersee,sommeRestante,dateEmission,dateFinFacturation,statut,FK_idPersonne,FK_idSouscriptionService,nombreEcheance) VALUES(:prixTotal,0,:sommeRestante,:dateEmission,:dateFin,0,:idPersonne,:idService,1) ');



	$stmt = $query->execute([

		"prixTotal"=> $prixTotal,
		"sommeRestante"=> $prixTotal,
		"dateEmission"=> date("Y-m-d H:i:s"),
		"dateFin"=> $final,
		":idPersonne"=> $idPersonne,
		":idService"=> $idService


	]);

	$getData = $connect->prepare("SELECT MAX(idFacture) FROM facture ");
	$getData->execute();

	$res = $getData->fetch();
	var_dump($res[0]);

	$query = $connect->prepare('INSERT INTO versement(somme,FK_idFacture,statut,date) VALUES(0,:facture,0,:dateEmission) ');
	$query->execute([

		":facture" => $res[0],
		":dateEmission"=>date("Y-m-d H:i:s")


	]);




	header("Location: history.php");


}