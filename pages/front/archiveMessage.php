<?php
require('../functions.php');

if(isset($_GET['id'])) {


  $connect = connectDb();

  $stmt = $connect->prepare('UPDATE messagerie SET statutDestinataire = 2 WHERE idMessagerie = ?');
  $res = $stmt->execute([
      $_GET['id']
    ]);
   
}