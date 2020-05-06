<?php
function connectDb(){

	try{

		$connect = new PDO("mysql:host=localhost;dbname=majordhome;port=3306","majordhome","L4*&uwL29cq5#B");

	}catch(Exception $e){
					
		die("Erreur SQL".$e->getMessage());
	}

	return $connect;

}


?>
