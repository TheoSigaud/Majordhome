<?php
session_start ();

if (!isset($_SESSION['user']) || ($_SESSION['user']['statut'] != 2 && $_SESSION['user']['statut'] != 3)) {
    header('Location: ../login.php');
}

require("../functions.php");
$connect = connectDb();

if(!empty($_POST['id'])) {

    $id = $_POST['id'];
    $req = $connect->prepare("UPDATE abonnement set statut =:status WHERE idAbonnement =:id;");
    $req->execute([
        ':status'=>-1,
        ':id'=>$id
    ]);

}



?>