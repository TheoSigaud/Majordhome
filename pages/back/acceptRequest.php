<?php
require('../functions.php');

$connect = connectDb();



if (isset($_POST['idSouscriptionService'])) {


$query = $connect->prepare('UPDATE souscription_service SET statutReservation = 2 WHERE idSouscriptionService = ?');
$query->execute([$_POST['idSouscriptionService']]);

echo "<div class='alert alert-success'>Demande validé !</div>";

}