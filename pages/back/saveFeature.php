<?php
require('../functions.php');


if(!empty($_POST['name'])
    && !empty($_POST['id'])
    && !empty($_POST['selectValue'])
   
){


	$name = trim($_POST['name']);
	$id = $_POST['id'];
	$selectValue = trim($_POST['selectValue']);

	$found = 0;
	$errors = [];

	$values = ['text','Date','number'];


	foreach ($values as  $value) {
		
		if ($selectValue == $value) {
			
			$found = 1;
		}
	}


	if ($found == 0) {
		
		$errors[] = "Champ incorrect !";
	}


	if(strlen($name)<2 || strlen($name)>80){
    			
    	$errors[]= "nom trop court ou trop long ! ";
   	}else{


   		$connect = connectDb();

   		$queryPrepared = $connect->prepare('SELECT c.idCaracteristique FROM caracteristique c, service s WHERE c.idService = :id AND c.nom = :nom AND c.idService = s.idService');
		
		$queryPrepared->execute([

					":id"=>$id, 
					":nom"=>$name

				]);

		$array = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($array)) {
			
			$errors[]= "Nom du champ existe déjà !";
		}


   	}


 


   	if (empty($errors)) {
   		
		$connect = connectDb();

		

		
		$queryPrepared = $connect->prepare('INSERT INTO caracteristique(nom,type,idService) VALUES (:nom,:type,:id)');
		
		$res =$queryPrepared->execute([

					":nom"=>$name, 
					":type"=>$selectValue, 
					":id"=>$id
					

				]);
	

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