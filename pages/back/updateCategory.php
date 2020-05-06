<?php
require('../functions.php');
if (isset($_POST['name']) && !empty($_POST['name'])) {


	$name = trim($_POST['name']);
	

	if (isset($_POST['description']) && $name != "") {


		$connect = connectDb();

		$description = trim($_POST['description']);
		
		$queryPrepared = $connect->prepare("UPDATE categorie SET nom = :name, description = :description WHERE idCategorie = :id");
		$res = $queryPrepared->execute([
			":name"=>$name,
			":description"=>$description,
			":id"=>$_POST['id']
		]);


		echo "<div class='alert alert-success'>Catégorie modifiée ! </div>";

	}else{

		echo "<div class='alert alert-danger'>Erreur de saisie !</div>";

	}


}else{

	echo "<div class='alert alert-danger'> Vous devez obligatoirement saisir le nom de la catégorie !</div>";

}