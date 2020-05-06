<?php
session_start ();

if (!isset($_SESSION['user']) || ($_SESSION['user']['statut'] != 2 && $_SESSION['user']['statut'] != 3)) {
    header('Location: ../login.php');
}

require("../functions.php");
$connect = connectDb();

if(!empty($_POST['id'])) {

    $id = $_POST['id'];




    $req = $connect->prepare("UPDATE personne set statut =:statut WHERE idPersonne =:id;");
    $req->execute([
        ':statut'=>-1,
        ':id'=>$id
    ]);

}



?>