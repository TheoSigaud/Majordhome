<?php
require "header.php";

?>


<section>
	
	<?php

if(!empty($_SESSION["successForm"])){
        echo "<div class='alert alert-success'>";
          echo "<li>".$_SESSION["successForm"];
        echo "</div>";
        unset($_SESSION["successForm"]);
    }


if(!empty($_SESSION["errorsForm"])){
        echo "<div class='alert alert-danger'>";
        foreach ($_SESSION["errorsForm"] as $error) {
            echo "<li>".$error;
        }
        echo "</div>";
        unset($_SESSION["errorsForm"]);
}


if(!empty($_SESSION["errors"])){
        echo "<div class='alert alert-danger'>";
   
            echo "<li>".$_SESSION["errors"];
     
        echo "</div>";
        unset($_SESSION["errors"]);
}


?>
	<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
	        <h1 class="display-5">Demande de service</h1>
	        <hr class="hr">
	</div>


	<div class="container">

		<form method="POST" action="saveRequestService.php">
				
			<div class="form">
	           <div class="form-group">
	            <label>Nom du service *</label>
	            <input placeholder="Demande d'un coca" name="name" type="text" class="form-control" required="required">
	            </div>
	        <div class="row form-group">

	        	
	            <div class="col-md-6">
		            <label>Date de début *</label>
		            <input name="startDate" type="date" class="form-control" required="required">
		        </div>

		        <div class="col-md-6">
		            <label>Date de fin <i>(Si différent de date de début)</i></label>
		            <input name="endDate" type="date"  class="form-control">
		        </div>

	        </div>

	           <div class="row form-group">

	            <div class="col-md-6">
		            <label>Heure de début *</label>
		            <input  name="startTime" type="time" class="form-control" required="">
		        </div>

		        <div class="col-md-6">
		            <label>Heure de fin <i>(Si nécessaire)</i></label>
		            <input name="endTime" type="time" class="form-control">
		        </div>

	        </div>



	        <div class="form-group">
	        	
	        	  <label>Adresse <i>(Si différent de votre adresse)</i></label>
		          <input placeholder="105 Avenue des Champs-Elysées" name="address" type="text" class="form-control">

	        </div>


	         <div class="row form-group">

	            <div class="col-md-6">
		            <label>Ville</label>
		            <input placeholder="Paris" name="city" type="text"  class="form-control">
		        </div>

		        <div class="col-md-6">
		            <label>Code postal</label>
		            <input placeholder="75008" name="code" type="text"  class="form-control" >
		        </div>

	        </div>


	         <div class="form-group">
	        	
	        	  <label>Informations supplémentaires</i></label>
		          <textarea name="informations" class="form-control" rows="5" placeholder="(Coca zéro/nombre de personne pour un anniversaire...)"></textarea>

	        </div>


	        <button type="submit" class="btn btn-primary">Soumettre votre demande <i class="fas fa-paper-plane"></i></button>

		</form>
		
	
	</div>








</section>



<?php
require "../footer.php";
?>