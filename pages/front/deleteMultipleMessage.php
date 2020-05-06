<?php
require('../functions.php');

if(isset($_GET['array']) && !empty($_GET['array'])) {

$array = explode(',', $_GET['array']);

$connect = connectDb();

  	
  	foreach ($array as $value) {
		
		$stmt = $connect->prepare('UPDATE messagerie SET statutDestinataire = 1 WHERE idMessagerie = ?');
  		$res = $stmt->execute([
   				$value
     ]);
  	 } 

}
