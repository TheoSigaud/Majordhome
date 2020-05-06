<?php
require("../functions.php");
$connect = connectDb();


if (isset($_GET['id'])) {

$queryPrepared = $connect->prepare('SELECT c.idCaracteristique, c.nom,c.type FROM caracteristique c, service s WHERE c.idService = s.idService AND c.idService = :id ');

$queryPrepared->execute([

	":id"=>$_GET['id']
]);

$array = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);



foreach ($array as  $value) {


echo "<div class='row' id='feature-".$value['idCaracteristique']."'>";					
	echo "<div class='col-md-10'>";
		echo "<div class='form-group'>";
			echo "<label>" . $value["nom"] . "</label>";
			echo "<input type='".$value["type"]."' class='form-control' placeholder='".$value["nom"]."'>";
		echo "</div>";
	echo "</div>";

	echo "<div class='col-md-2'>";
		echo "<button class='btn btn-danger' onclick='deleteFeature(".$value["idCaracteristique"].")'><i class='fas fa-trash'></i></button>";
	echo "</div>";
	echo "</div>";
}

	
}