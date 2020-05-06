<?php
require('../functions.php');
session_start();

if(!empty($_POST['name'])
    && !empty($_POST['selectValue'])
    && !empty($_POST['priceEur'])
    && !empty($_POST['priceCent'])
   
){

	$name = trim($_POST['name']);
  $description = trim($_POST['description']);
  $selectValue = $_POST['selectValue'];
  $priceEur = trim($_POST['priceEur']);
  $priceCent = trim($_POST['priceCent']);

	$errors = [];


	if(strlen($name)<2 || strlen($name)>80){
    			
    	$errors[]= "nom trop court ou trop long ! ";
   	}
    		
    if(strlen($description)>150){
    				
    	$errors[]= "Votre description doit être inférieur à 150 caractères !";
   	}

   	$connect = connectDb();


   	$queryPrepared = $connect->prepare("SELECT idCategorie,nom FROM categorie WHERE nom = :nom");
   	$queryPrepared->execute([":nom" => $selectValue]);
   	$data = $queryPrepared->fetch(PDO::FETCH_ASSOC);


   	if (empty($data)) {

   		$errors[]= "La catégorie n'existe pas ";
   		
   	}


    if(!preg_match('/^[0-9]+$/', $priceEur)) {
        $errors[] = "Les euros indiqués ne sont pas valides.";
    }

    if(!preg_match('/^[0-9][0-9]$/', $priceCent)) {
        $errors[] = "Les centimes indiqués ne sont pas valides. Il est obligatoire d'y insérer 2 chiffres.";
    }

    $price = $priceEur.$priceCent;



   	if (empty($errors)) {
   		
		$connect = connectDb();

				

		$queryPrepared = $connect->prepare("INSERT INTO service(nom,description,prix,statut,idCategorie) VALUES (:nom,:description,:prix,0,:idCategorie)");

				

		$queryPrepared->execute([

					":nom"=>$name, 
					":description"=>$description, 
					":prix"=>$price, 
					":idCategorie"=>$data["idCategorie"]
					

				]);


		echo "<div class='alert alert-success'>Votre service à bien été crée ! </div>";


	

   	}else{

   		echo "<div class='alert alert-danger'>";
   			foreach ($errors as  $value) {
				echo "<li>".	$value. "</li>";
	
   			}

   		echo "</div>";

   	}

}else{


		echo "<div class='alert alert-danger'>Erreur de saisie ! </div>";
}