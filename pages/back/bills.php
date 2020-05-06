<?php

require("headerBack.php");


$connect = connectDb();



$queryPrepared = $connect->prepare('SELECT f.idFacture, DATE_FORMAT(f.dateEmission,"%d/%m/%Y") as dateEmission, f.sommeRestante,f.SommeVersee, f.prixTotal, p.nom,p.prenom,f.statut FROM facture f , personne p WHERE f.FK_idPersonne = p.idPersonne AND f.FK_idSouscriptionAbonnement IS NULL ORDER BY f.dateEmission DESC');

$queryPrepared->execute();
$dataService = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);


$queryPrepared = $connect->prepare('SELECT f.idFacture, DATE_FORMAT(f.dateEmission,"%d/%m/%Y") as dateEmission, f.sommeRestante,f.SommeVersee, f.prixTotal, p.nom,p.prenom,f.statut FROM facture f , personne p WHERE f.FK_idPersonne = p.idPersonne AND f.FK_idSouscriptionService IS NULL ORDER BY f.dateEmission DESC');

$queryPrepared->execute();
$dataSubscription = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);





?>






<section class="container">

	<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-5">Factures</h1>
        <hr class="hr">
	</div>
	

	<button class="btn btn-primary" onclick="displayService()"">Services</button>
	<button class="btn btn-primary" onclick="displaySubscription()">Abonnements</button>
	<hr>


	<div id="quoteService">
	
	<h5>Factures services</h5>

	<table class="table table-bordered table-hover">
		<thead>
		<tr>
			<th col="">Id Facture</th>
			<th>Date Emission</th>
			<th>Client</th>
			<th>Statut</th>
			<th>Actions</th>
		</tr>
		</thead>
		<tbody>
			


		<?php

			foreach ($dataService as $value) {
			


				echo "<tr>";
				echo "<td>".$value['idFacture']."</td>";
				echo "<td>".$value['dateEmission']."</td>";
				echo "<td>".$value['prenom'] . " " . $value['nom']."</td>";
				echo "<td>";

						if ($value['statut'] == 0) {
							echo "En cours de traitement <br>";
							echo "Somme restante : " . $value["prixTotal"] / 100 . " €";
						}

						if ($value['statut'] == 1) {
							echo "Payé en une fois";
						}

						if ($value['statut'] == 2) {
							echo "Payé en plusieurs fois <br>";
							echo "Somme versée : " . $value["SommeVersee"] . " €<br>";
							echo "Somme restante : " . $value["sommeRestante"] . " €";
						}


				echo "</td>";
					echo '<td>

						<a href="billToPdf.php?id='.$value["idFacture"].'" class="btn btn-dark"><i class="far fa-file-alt"></i></a>
					</td>';
		
			
				
			echo "</tr>";
			}



		?>



		</tbody>


		
	</table>

	</div>





	<div id="quoteSubscription">

	<h5>Factures abonnements</h5>

	<table class="table table-bordered table-hover">
		<thead>
		<tr>
			<th col="">Id Facture</th>
			<th>Date Emission</th>
			<th>Client</th>
			<th>Statut</th>
			<th>Actions</th>
		</tr>
		</thead>
		<tbody>
			


		<?php

			foreach ($dataSubscription as $value) {
			


				echo "<tr>";
				echo "<td>".$value['idFacture']."</td>";
				echo "<td>".$value['dateEmission']."</td>";
				echo "<td>".$value['prenom'] . " " . $value['nom']."</td>";
				echo "<td>";

						if ($value['statut'] == 0) {
							echo "En cours de traitement <br>";
							echo "Somme restante : " . $value["prixTotal"] / 100 . " €";
						}

						if ($value['statut'] == 1) {
							echo "Payé en une fois";
						}

						if ($value['statut'] == 2) {
							echo "Payé en plusieurs fois <br>";
							echo "Somme versée : " . $value["SommeVersee"] . " €<br>";
							echo "Somme restante : " . $value["sommeRestante"] . " €";
						}


				echo "</td>";
					echo '<td>

						<a href="billToPdf.php?id='.$value["idFacture"].'" class="btn btn-dark"><i class="far fa-file-alt"></i></a>
					</td>';
		
			
				
			echo "</tr>";
			}



		?>



		</tbody>


		
	</table>

	</div>




</section>
































 <script src="../../js/billsBack.js"></script>

<?php

require("../footer.php")

?>