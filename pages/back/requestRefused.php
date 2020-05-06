<?php
require('headerBack.php');
$connect = connectDb();

$queryPrepared = $connect->prepare('SELECT s.idSouscriptionService , DATE_FORMAT(s.dateReservation,"%d/%m/%Y %H:%m") AS dateReservation ,p.nom ,p.prenom FROM souscription_service s, personne p WHERE s.FK_idPersonne = p.idPersonne AND s.FK_idService = 0 AND s.statutReservation = -1');
$queryPrepared->execute();

$data = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);



?>


<section class="container pt-4">
	
<div class="title text-center pt-1 pb-3">
	<h1>Demandes</h1>
	<hr class="hr">
	
</div>

<div>
	<a class="mr-2" href="pageRequestService.php">Demandes en cours</a>
	<a href="requestAccepted.php">Demandes acceptées</a>
</div>

<h5 class="pt-2">Demandes refusées</h5>
<hr>
<div>
<table class='table table-striped table-hover table-bordered'>
	
	<thead>
		<tr>
			<th><i class="far fa-file-alt"></i></th>
			<th scope="col">Id</th>
			<th>Date</th>
			<th>Client</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>


	<?php

		foreach ($data as $value) {
		
		
			echo "<tr>";
				echo '<td>
					<button onclick="detailsRequest(\'' . $value["idSouscriptionService"] . '\')" class="btn btn-primary" data-toggle="modal" data-target="#request"><i class="far fa-file-alt"></i></button>
				</td>';
				echo "<td>".$value['idSouscriptionService']."</td>";
				echo "<td>".$value['dateReservation']."</td>";
				echo "<td>".$value['prenom'] . " " . $value['nom']."</td>";
				echo "<td>

					</td>";
			
				
			echo "</tr>";
		}
	?>

	</tbody>


</table>
</div>







<div id="request" class="modal fade" role="dialog">
  			<div class="modal-dialog">
  				<div class="modal-content">
					<div class="modal-header">
					    <h4 class="modal-title"><i class="far fa-file-alt"></i> Détails de la demande :</h4>
					    <button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<div id="information" class="p-3"></div>


					 <div class="modal-footer">
					      	<button class="btn btn-danger" data-dismiss="modal">Fermer</button>
       						
					  </div>

				</div>

			</div>
		</div>


</section>


































<script src="../../js/pageRequestService.js"></script>

<?php require "../footer.php"; ?>