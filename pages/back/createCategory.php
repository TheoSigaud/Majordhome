<?php
require('../functions.php');
if (!empty($_POST['name'])) {


	$name = trim($_POST['name']);
	$description = trim($_POST['description']);

	$errors = [];

    		
    if(strlen($description)>150){
    				
    	$errors[]= "Votre description doit être inférieur à 150 caractères !";
   	}


	$connect = connectDb();


   	$queryPrepared = $connect->prepare("SELECT nom FROM categorie WHERE nom = :name");
   	$queryPrepared->execute([":name" => $name]);
   	$data = $queryPrepared->fetch(PDO::FETCH_ASSOC);


   	if (!empty($data)) {

   		$errors[]= "La catégorie existe déjà ";
   		
   	}else{

   		if(strlen($name)<2 || strlen($name)>80){
    			
    		$errors[]= "nom trop court ou trop long ! ";
   		}
   	}

   	if (empty($errors)) {
   		$connect = connectDb();
			
		$queryPrepared = $connect->prepare("INSERT INTO categorie(nom,description) VALUES(:name,:description);");
		$queryPrepared->execute([
			":name"=>$name,
			":description"=>$description
		]);


		echo "<div class='alert alert-success'> Catégorie créée !</div>";


   	}else{


   			echo "<div class='alert alert-danger'>";
   			foreach ($errors as  $value) {
				echo "<li>".	$value. "</li>";
	
   			}

   			echo "</div>";
   	}


	
	


}else{

	echo "<div class='alert alert-danger'> Vous devez obligatoirement saisir le nom de la catégorie !</div>";

}