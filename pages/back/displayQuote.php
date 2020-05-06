<?php
require "headerBack.php";



$connect = connectDb();


$queryPrepared = $connect->query('SELECT d.idDevis, d.titre, DATE_FORMAT(d.dateEmission,"%d/%m/%Y") as dateEmission,DATE_FORMAT(d.dateValidation,"%d/%m/%Y") as dateValidation,p.nom,p.prenom,d.statut FROM devis d, personne p WHERE d.FK_idPersonne = p.idPersonne ORDER BY d.dateEmission DESC');


$queryPrepared->execute();

$data = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);


?>

<section class="container">



	<?php if(!empty($_SESSION["confirmQuote"])){
        echo "<div class='alert alert-success'>";
       	foreach ($_SESSION["confirmQuote"] as $success) {
            echo "<li>".$success;
        }
        echo "</div>";
        unset($_SESSION["confirmQuote"]);
    }

    ?>
	


<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-5">Devis</h1>
        <hr class="hr">
</div>





<table class='table table-striped table-hover table-bordered'>
	
	<thead>
		<tr>
			<th><i class="far fa-file-alt"></i></th>
			<th scope="col">Numéro devis</th>
			<th>Date Emission</th>
			<th>Titre</th>
			<th>Client</th>
			<th>Statut</th>
			
		</tr>
	</thead>
	<tbody>


	<?php

		foreach ($data as $value) {
		
		
			echo "<tr>";
					echo '<td>

						<a href="quoteToPdf.php?id='. $value['idDevis'].'" class="btn btn-dark"><i class="far fa-file-alt"></i></a>
					</td>';
				echo "<td>".$value['idDevis']."</td>";
				echo "<td>".$value['dateEmission']."</td>";
				echo "<td>".$value['titre']."</td>";
				
				echo "<td>".$value['prenom'] . " " . $value['nom']."</td>";
				echo "<td>";
					if ($value['statut'] == 0) {
						echo "En cours ... ";
					}else{

						echo "Devis accepté." . "<br>" . "Date de validation : " . $value['dateValidation']  ;
					}

				echo "</td>";
		
			
				
			echo "</tr>";
		}
	?>

	</tbody>


</table>



</section>
























<?php

require"../footer.php";

?>