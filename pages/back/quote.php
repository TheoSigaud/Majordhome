<?php
require "headerBack.php";


if (isset($_GET['idSouscription']) && isset($_GET['idUser'])) {

		$idSouscription = $_GET['idSouscription'];
		$idUser = $_GET['idUser'];



		$queryVerify = $connect->prepare("SELECT s.FK_idPersonne,p.nom,p.prenom,p.mail FROM souscription_service s, personne p WHERE s.idSouscriptionService = ? AND s.FK_idPersonne = p.idPersonne");
		$queryVerify->execute([$idSouscription]);

		$data = $queryVerify->fetch();

		
		if ($data[0] != $idUser){

			header("Location: pageRequestService.php");

		}

		$lastname = $data[1];
		$firstname = $data[2];
		$mail = $data[3];

}else{

	header("Location: pageRequestService.php");
}



$queryPrepared= $connect->prepare("SELECT nom FROM categorie");
$queryPrepared->execute();
$data = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);


?>



<section>
	


<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-5">Création devis <?php  if (isset($lastname)){  echo "M/Mme " . $lastname . " " . $firstname;} ?></h1>
        <hr class="hr">
</div>



<div class="container">

		<form method="POST" action="saveQuote.php">
				
			<div class="form">

				<?php

				if (isset($idSouscription)) {

				?>
					
				<div class="form-group">
	            <label>Identifiant souscription</label>
	            <input placeholder="" name="id" type="text" class="form-control" required="required" value="<?php if( isset($idSouscription)){ echo $idSouscription;} ?>">
	            </div>

	            <?php

				}
				?>

				<div class="form-group">
	            <label>Email</label>
	            <input placeholder="" name="mail" type="text" class="form-control" required="required" value="<?php if( isset($mail)){ echo $mail;} ?>">
	            </div>
	      		

	           <div class="form-group">
	            <label>Titre de la prestation*</label>
	            <input placeholder="Demande d'un coca" name="request" type="text" class="form-control" required="required">
	            </div>
	      		

	      		<p>€ Prix de la prestation</p>

	           <div class="row form-group">

	            <div class="col-md-6">
		            <label>Euros *</label>
		            <input  name="priceEur" type="number" class="form-control" required="">
		        </div>

		        <div class="col-md-6">
		            <label>Centimes</label>
		            <input name="priceCent" type="number" class="form-control">
		        </div>

	        </div>


	        <div class="form-group">
	            <label>Catégorie</label>
	            <select name="categ" class="form-control">
	            	<?php

	            		 foreach ($data as $value) {

                            echo "<option value='".$value['nom']."'>".$value['nom']."</option>";

                     }

	            	?>
	            	
	            </select>
	        </div>




	         <div class="form-group">
	        	
	        	  <label>Détails du devis</i></label>
		          <textarea name="informations" class="form-control" rows="5" placeholder="..."></textarea>

	        </div>


	        <button type="submit" class="btn btn-primary">Sauvegarde du devis</button>

		</form>
		
	
	</div>








</section>




































<?php
require "../footer.php";
?>