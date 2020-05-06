<?php

require('../functions.php');

$connect = connectDb();

$queryPrepared = $connect->prepare('SELECT s.idService,s.nom,s.prix,s.description,c.nom AS nomCateg FROM service s, categorie c WHERE s.idCategorie = c.idCategorie  AND s.statut = 0;');

$queryPrepared->execute();
$dataService = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);


echo "<table class='table table-striped table-hover table-bordered'>";
    echo "<thead>";
      echo "<tr>";
        echo "<th scope='col'>Id</th>";   
        echo "<th>Nom</th>";    
        echo "<th>Description</th>";    
        echo "<th>Prix €</th>";    
        echo "<th>Catégorie</th>";   
        echo "<th>Action</th>";   
      echo "</tr>";   
    echo "</thead>";      
    echo "<tbody>";     
  
    foreach ($dataService as $value) {
    
      if ($value['prix']%100 == 0){
          $price[0] = $value['prix']/100;
          $price[1] = '00';
      }else{
          $price = explode(".", $value['prix']/100);
      }


    echo '<tr id="service-' . $value['idService'] .'">';
          echo "<th scope='row'>".$value['idService']."</th>";
          echo "<td>".$value['nom']."</td>";
          echo "<td>".$value['description']."</td>";    
          echo "<td>". $price[0] . "," .$price[1] .  "</td>";    
          echo "<td>".$value['nomCateg']."</td>";   
          echo "<td>";
            echo "<a href='updateService.php?id=".$value['idService']."'><button data-toggle='modal' data-target='#myModal' class='btn btn-primary m-1'><i class='fas fa-edit'></i></button></a>";
            echo "<button onclick='deleteConfirm(".$value['idService'].");'  data-toggle='modal' data-target='#modalDelete' class='btn btn-danger m-1'><i class='fas fa-trash-alt'></i></button>";  
            echo "<button onclick='publishConfirm(".$value['idService'].");' data-toggle='modal' data-target='#modalPublished' class='btn btn-success m-1'>Publié</button>";  

          echo "</td>";
      echo "</tr>";   
  }


  echo "</tbody>";
echo "</table>";