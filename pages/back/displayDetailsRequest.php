<?php
require("../functions.php");

$connect = connectDb();

if (isset($_GET['id']) && !empty($_GET['id'])) {
	

	$queryPrepared = $connect->prepare("SELECT d.information, d.FK_idSouscriptionService,c.nom FROM donnees_service d , caracteristique c WHERE d.FK_idSouscriptionService = ? AND d.FK_idCaracteristique = c.idCaracteristique");

	$queryPrepared->execute([$_GET['id']]);

	$data = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);


	foreach ($data as $value) {
		
		echo "<h6><b>" .$value['nom']." : </b></h6>";
		echo "<p>" .$value['information'] . "</p>";
	}






}