<?php
require('../functions.php');

if (isset($_POST['name']) && !empty($_POST['name']) 
	&& isset($_POST['price']) && !empty($_POST['price']) 
	&& isset($_POST['selectValue']) && !empty($_POST['selectValue'])
	&& isset($_POST['id']) && !empty($_POST['id'])
	&& isset($_POST['description'])
){

	$name = trim($_POST['name']);
	$price = $_POST['price'];
	$description = trim($_POST['description']);
	$selectValue = $_POST['selectValue'];

	$errors = [];



	if (strlen($name )< 2 || strlen($name )> 80) {
		 $errors[] = " Nom trop court ou trop long ! ";
	}

	if (strlen($description )> 150){

		$errors[] = "Votre description doit être inférieur à 150 caractères !";

	}

	$connect = connectDb();


   	$queryPrepared = $connect->prepare("SELECT idCategorie,nom FROM categorie WHERE nom = :nom");
   	$queryPrepared->execute([":nom" => $selectValue]);
   	$data = $queryPrepared->fetch(PDO::FETCH_ASSOC);

   	if (empty($data)) {

   		$errors[]= "La catégorie n'existe pas ";
   		
   	}


   	if (empty($errors)) {
   		
		$connect = connectDb();

				

		$queryPrepared = $connect->prepare("UPDATE service SET nom = :nom, description = :description,prix= :price,idCategorie = :idCategorie WHERE idService = :id;");

				

		$queryPrepared->execute([

					":nom"=>$name, 
					":description"=>$description, 
					":price"=>$price, 
					":idCategorie"=>$data["idCategorie"],
					":id"=>$_POST['id']					

				]);


		echo "<div class='alert alert-success'>Votre service à bien été modifié ! </div>";


	

   	}else{

   		echo "<div class='alert alert-danger'>";
   			foreach ($errors as  $value) {
				echo "<li>".$value. "</li>";
	
   			}

   		echo "</div>";

   	}


	
}else{

	echo "<div class='alert alert-danger'> Erreur ! </div>";

}
