<?php
require("header.php");

?>



<section class="container pt-4">
	
<div class="title text-center pt-1 pb-3">

	<h1>Contrats</h1>
	<hr class="hr">
</div>




<div>
	

	<form method="POST" action="createContract.php">

		<h5>Informations personnelles du prestataire : </h5>
		<hr>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					
					<label>Nom</label>
					<input type="text" name="lastname" class="form-control" placeholder="Jean" required="">
				</div>
			</div>


			<div class="col-md-6">
				<div class="form-group">
					
					<label>Prénom</label>
					<input type="text" name="firstname" class="form-control" placeholder="Dupont" required="">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					
					<label>Date de naissance</label>
					<input type="date" name="date" class="form-control" placeholder="" required="">
				</div>
			</div>


			<div class="col-md-6">
				<div class="form-group">
					
					<label>Lieu de Naissance</label>
					<input type="text" name="place" class="form-control" placeholder="Drancy" required="">
				</div>
			</div>
		</div>


	

		<div class="form-group">
			<label>Adresse</label>
			<input type="text" name="address" class="form-control" placeholder="105 rue Versailles" required="">
		</div>


		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					
					<label>Ville</label>
					<input type="text" name="city" class="form-control" placeholder="Paris" required="">
				</div>
			</div>


			<div class="col-md-6">
				<div class="form-group">
					
					<label>Code postal</label>
					<input type="number" name="code" class="form-control" placeholder="75016" required="">
				</div>
			</div>



		</div>

		<div class="form-group">
			<label>Métier</label>
			<input type="text" name="profession" class="form-control" placeholder="Plombier" required="">
		</div>
		<h5>Durée du contrat : </h5>
		<hr>

		<div class="form-group">
	        <label for="days">Date de début</label>
	        <input name="dateContract" type="date" class="form-control">
	    </div>

		<div class="form-group">
	        <label for="days">Nombre d'année *</label>
	        <input name="days" type="number" class="form-control" placeholder="2" required="">
	    </div>

	  

		<div class="form-group">
			
			<button type="submit" class="btn btn-primary">Générer le contrat en PDF</button>
		</div>


	</form>


</div>


</section>