<?php
session_start();
require('../functions.php');
$connect = connectDb();


if(count($_POST) == 2
    
    && !empty($_POST['title'])
    && !empty($_POST['message'])
   
){



	
	$title = trim($_POST['title']);
	$message = trim($_POST['message']);


	$errors = [];


    if (strlen($title) > 80) {
    	
    	$errors['title'] = " Titre trop long";
    }




    if (empty($errors)) {


    	$queryPrepared = $connect->prepare("INSERT INTO messagerie(statut,titre,texte,serviceMessagerie,idSource,statutSource,statutDestinataire) VALUES(1,:titre,:texte,'majordhome',:idSource,0,0)");

        $queryPrepared->execute([

            ":titre"=>$title, 
            ":texte"=>$message, 
            ":idSource"=>$_SESSION['user']['idPersonne']

        ]);


       
        echo "<div class='alert alert-success'> Message envoyé !</div>";


    }else{


            echo "<div class='alert alert-danger'>";
            foreach ($errors as  $value) {
                echo "<li>".    $value. "</li>";
    
            }

            echo "</div>";
    }



}