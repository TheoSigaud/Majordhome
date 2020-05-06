<?php
require('../functions.php');

if(isset($_GET['id'])) {

  $connect = connectDb();


  if (isset($_GET['action']) && $_GET['action'] == 'd') {

  	 $stmt = $connect->prepare('UPDATE messagerie SET statutDestinataire = -1 WHERE idMessagerie = ?');
  	$res = $stmt->execute([
      $_GET['id']
    ]);

  	
  }else{

  $stmt = $connect->prepare('UPDATE messagerie SET statutDestinataire = 1 WHERE idMessagerie = ?');
  $res = $stmt->execute([
      $_GET['id']
    ]);



}
   
}