<?php
session_start();
require('../functions.php');

if (isset($_GET['id'])) {
	
	$connect = connectDb();

	
	$query = $connect->prepare('SELECT m.idMessagerie,m.serviceMessagerie,m.titre,m.texte,m.dateEnvoie,p.mail FROM messagerie m INNER JOIN personne p ON p.idPersonne = m.idSource WHERE idMessagerie = ?');
 	
 	
 	$query->execute([$_GET['id']]);


 	$data = $query->fetch(PDO::FETCH_ASSOC);


    $date = $data['dateEnvoie'];
    $phpdate = strtotime( $date );
    $date = date( 'd/m/Y H:i', $phpdate );
    $dateExplode = explode(' ', $date);

?>
	

	<div class="p-2 viewMessage">

	<button onclick="window.location.reload()" class="btn btn-primary m-2">Retour <i class="fas fa-arrow-circle-left"></i></button>
	
	<h5 class="titleMessage"> Objet : <?php echo $data['titre'];?></h5>

	<p class='contains'><?php 

		if ($data['serviceMessagerie'] == NULL){

			echo "Centre de messagerie Majord'home." . "<br>" . $dateExplode[0] . " " . $dateExplode[1];;
			
		}else{

			echo $data['mail'] . "<br>" . $dateExplode[0] . " " . $dateExplode[1];
		}

	 ?>


	  </p>
	
	<p class="contains" "> À :  <?php

		if ($data['serviceMessagerie'] == NULL) {

			echo $_SESSION['user']['mail'];
			 
		}else{

			echo "Centre de messagerie Majord'home.";
		}
	 ?> 

	</p>
	<hr>
	<p class="contains"> <?php echo $data['texte']; ?></p>

		
	</div>

<?php

}
