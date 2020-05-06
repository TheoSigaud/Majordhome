<?php
session_start();
require('../functions.php');

$connect = connectDb();

$query = $connect->prepare('SELECT m.idMessagerie,m.titre,m.texte,m.dateEnvoie,p.nom AS destinataire,p1.nom AS source FROM messagerie m INNER JOIN personne p ON p.idPersonne = m.idDestinataire INNER JOIN personne p1 ON p1.idPersonne = m.idSource WHERE m.serviceMessagerie IS NULL AND m.statutSource = 0 ORDER BY m.dateEnvoie desc;');
$query->execute();

echo "<table class='table table-inbox table-hover'>";
    

  echo "<tbody>";     
  
  	foreach ($query->fetchAll() as $value) {

    $date = $value['dateEnvoie'];

    $dateToday = date('d/m/Y');
    $phpdate = strtotime( $date );
    $date = date( 'd/m/Y H:i', $phpdate );

    $dateExplode = explode(' ', $date);
   
		echo "<tr class='unread' id='".$value['idMessagerie']."'>";

     echo "<td> ";
       echo "<input type='checkbox' class='check'>";
     echo "</td>";


      
      echo "<td>".$value['destinataire']."</td>";
      echo "<td><p class='view-message'>".$value['texte']."</p></td>";
      echo "<td class='text-right'>
      <i onclick='deleteMessage(".$value['idMessagerie'].")' class=' fas fa-trash'></i>
      <i onclick='archiveMessage(".$value['idMessagerie'].")' class=' fas fa-archive'></i>
    
      </td>";

      if ( $dateToday === $dateExplode[0]) {
        echo "<td class='text-right'>".$dateExplode[1]."</td>";
      }else{

         echo "<td class='text-right'>".$dateExplode[0]."</td>";
      }
     

     echo "<td class='text-right'><i onclick='viewMessage(".$value['idMessagerie'].")' class='fas fa-envelope'></i></td>";

    echo "</tr>";
  
 


  }



 echo "</tbody>";
echo "</table>";