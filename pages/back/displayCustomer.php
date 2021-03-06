<?php
session_start ();

if (!isset($_SESSION['user']) || ($_SESSION['user']['statut'] != 2 && $_SESSION['user']['statut'] != 3)) {
    header('Location: ../login.php');
}

require("../functions.php");
$connect = connectDb();

$search =  $_POST['search'];
$type = $_POST['type'];



if($search == '' || !preg_match("/^[^'|;\"\/]+$/", $search)) {
    $data = $connect->query("SELECT idPersonne, prenom, nom, mail, dateNaissance, adresse, ville, codePostal, telephone FROM personne WHERE statut = 0 ORDER BY dateCreation DESC");
}else{
    $data = $connect->query("SELECT idPersonne, prenom, nom, mail, dateNaissance, adresse, ville, codePostal, telephone FROM personne WHERE statut = 0 AND $type LIKE '$search%' ORDER BY dateCreation DESC");
}
    $rows = $data->fetchAll(PDO::FETCH_ASSOC);

echo '<div class="container">';

foreach ($rows as $row) {

    echo '<tr>';
        echo'<td>'.$row["prenom"].'</td>';
        echo '<td>'.$row["nom"].'</td>';
        echo '<td>'.$row["mail"].'</td>';
        echo '<td>'.strftime($row["dateNaissance"]).'</td>';
        echo '<td>'.$row["adresse"].'</td>';
        echo '<td>'.$row["ville"].'</td>';
        echo '<td>'.$row["codePostal"].'</td>';
        echo '<td>'.$row["telephone"].'</td>';
        echo '<td>';
            echo '<a class="btn btn-primary my-primary" href="modificationCustomer.php?id='.$row['idPersonne'].'">Modifier</a>';
            echo '<button class="btn btn-danger my-danger" onclick="show('.$row['idPersonne'].')">Supprimer</button>';
            echo '<a class="btn btn-warning my-warning" href="reservationBack.php?id='.$row['idPersonne'].'">Réservations</a>';
            echo '<a class="btn btn-info my-info" href="subscriptionCustomer.php?id='.$row['idPersonne'].'">Abonnements</a>';
        echo '</td>';
    echo '</tr>';
}

echo '<div>';