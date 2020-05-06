<?php
require('../functions.php');

$connect = connectDb();

$query = $connect->prepare('SELECT m.idMessagerie,m.titre,m.texte,m.statut,m.dateEnvoie,p.nom FROM messagerie m, personne p WHERE m.idSource = p.idPersonne AND serviceMessagerie = "majordhome" AND m.statutSource = 0 ORDER BY m.dateEnvoie desc;');
$query->execute();
$data = $query->fetchAll();


if (empty($data)) {
    echo "<span class='emptyInbox'>Boîte de réception vide</span>";
}

echo "<table class='table table-inbox table-hover'>";

  echo "<tbody>";     
  
    foreach ($data as $value) {

    $date = $value['dateEnvoie'];
    $dateToday = date('d/m/Y');
    $phpdate = strtotime( $date );
    $date = date( 'd/m/Y H:i', $phpdate );

    $dateExplode = explode(' ', $date);



   
    echo "<tr class='unread' id='".$value['idMessagerie']."'>";

     echo "<td> ";
       echo "<input type='checkbox' class='check'>";
     echo "</td>";
      
      echo "<td>".$value['nom']."</td>";
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
     

      if ($value['statut'] == 1) {


        

        echo "<td class='text-right'><i onclick='viewMessage(".$value['idMessagerie'].")' class='fas fa-envelope'></i><span class='status'></span></td>";
      
      }else{

        echo "<td class='text-right'><i onclick='viewMessage(".$value['idMessagerie'].")' class='fas fa-envelope-open'></i></td>";

      }


    echo "</tr>";
  
 


  }



 echo "</tbody>";
echo "</table>";