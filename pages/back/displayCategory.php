<?php

require('../functions.php');

$connect = connectDb();

$query = $connect->query('SELECT idCategorie,nom,description FROM categorie;');
$query->execute();



echo "<table class='table table-striped table-hover table-bordered'>";
  	echo "<thead>";
   		echo "<tr>";
     		echo "<th scope='col'>Id</th>";		
     		echo "<th>Nom</th>";		
     		echo "<th>Description</th>";		
     		echo "<th>Action</th>";		
     	echo "</tr>";		
    echo "</thead>";			
    echo "<tbody>";			
  
  	foreach ($query->fetchAll() as $value) {
		
		echo '<tr id="category-' . $value['idCategorie'] .'">';
      		echo "<th scope='row'>".$value['idCategorie']."</th>";
      		echo "<td>".$value['nom']."</td>";
      		echo "<td>".$value['description']."</td>";		
      		echo "<td>";
      			echo "<button onclick='getData(".$value['idCategorie'].");' type='button' data-toggle='modal' data-target='#myModal' class='btn btn-primary m-1'><i class='fas fa-edit'></i></button>";
      			echo "<button onclick='deleteConfirm(".$value['idCategorie'].");'  data-toggle='modal' data-target='#modalDelete' class='btn btn-danger m-1'><i class='fas fa-trash-alt'></i></button>";				
      		echo "</td>";
    	echo "</tr>";		
	}


	echo "</tbody>";
echo "</table>";