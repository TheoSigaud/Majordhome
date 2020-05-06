<?php
session_start();
require("pages/functions.php");
$connect = connectDb();


if (isset($_POST['email']) && isset($_POST['pwd'])) {

	$email = $_POST['email'];
	$pwd = $_POST['pwd'];


		$queryPrepared = $connect->prepare('SELECT * FROM personne WHERE mail = :email');
		$queryPrepared->execute([':email' => $email]);
		$user = $queryPrepared->fetch();

		$pwd = hash("sha256", $pwd);
				
		if (hash_equals($pwd,$user['mdp']) && ($user['statut'] == 2 || $user['statut'] == 3)){
                $_SESSION['user'] = $user;
                header('Location: pages/dashboard.php');
			}else{

				$error =  "Identifiants incorrects";
				$_SESSION['errorsAuth'] = $error;
				header('Location: index.php');
			}


}

