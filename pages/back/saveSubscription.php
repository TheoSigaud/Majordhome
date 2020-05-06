<?php
session_start();

if (!isset($_SESSION['user']) || ($_SESSION['user']['statut'] != 2 && $_SESSION['user']['statut'] != 3)) {
    header('Location: ../login.php');
}

require("../functions.php");
$connect = connectDb();
echo count($_POST);
if(count($_POST) >= 11 && count($_POST) <=12
    && !empty($_POST['title'])
    && !empty($_POST['priceEur'])
    && !empty($_POST['description'])
    && !empty($_POST['week'])
    && !empty($_POST['timeStart'])
    && !empty($_POST['timeEnd'])
){
    $errors = [];

    $title = trim($_POST['title']);
    $priceEur = trim($_POST['priceEur']);
    $priceCent = trim($_POST['priceCent']);
    $years = trim($_POST['years']);
    $months = trim($_POST['months']);
    $days = trim($_POST['days']);
    $description = trim($_POST['description']);
    $week = trim($_POST['week']);
    if(!empty($_POST['unlimited'])) {
        $time = -1;
    }else if (!empty($_POST['time'])){
        $time = trim($_POST['time']);
        if(!empty($time) && !preg_match('/^[0-9]+$/', $time)) {
            $errors['time'] = "Le nombre de services par mois n'est pas valide.";
        }
    }
    $timeStart = trim($_POST['timeStart']);
    $timeEnd = trim($_POST['timeEnd']);



    if (empty($_POST['unlimited']) && empty($_POST['time'])){
        $errors['unlimited'] = "Vous devez choisir un nombre d'heures";
    }


    $data = $connect->query("SELECT nom FROM abonnement WHERE nom = '$title' && statut = 0");

    foreach ($data->fetchAll() as $key => $subscription) {
        $count = $data->rowCount();

        if ($count != 0) {
            $errors['title'] = "Un abonnement avec un titre similaire existe déjà";
        }
    }
    

    if(!preg_match('/^[0-9]+$/', $priceEur)) {
        $errors['priceEur'] = "Les euros indiqués ne sont pas valides.";
    }

    if(!preg_match('/^[0-9][0-9]$/', $priceCent)) {
        $errors['priceCent'] = "Les centimes indiqués ne sont pas valides. Il est obligatoire d'y insérer 2 chiffres.";
    }

    if(!empty($years) && !preg_match('/^[0-9]{1,2}$/', $years)) {
        $errors['years'] = "Le nombre d'années n'est pas valide.";
    }

    if(!empty($months) && !preg_match('/^[0-9]{1,2}$/', $months)) {
        $errors['months'] = "Le nombre de mois n'est pas valide.";
    }

    if(!empty($days) && !preg_match('/^[0-9]+$/', $days)) {
        $errors['days'] = "Le nombre de jours n'est pas valide.";
    }

    if (empty($years) && empty($months) && (empty($days) || $days == 0)){
        $errors['days'] = "L'abonnement doit avoir une durée minimum d'un jour.";
    }

    if(!empty($week) && !preg_match('/^[1-7]$/', $week)) {
        $errors['week'] = "Le nombre de jours par semaine n'est pas valide.";
    }


    if(!empty($timeStart) && !preg_match('/^[0-9]{1,2}$/', $timeStart)) {
        $errors['timeStart'] = "L'heure de début n'est pas valide.";
    }

    if(!empty($timeEnd) && !preg_match('/^[0-9]{1,2}$/', $timeEnd)) {
        $errors['timeEnd'] = "L'heure de fin n'est pas valide.";
    }


    if ($timeStart >= $timeEnd && ($timeStart != 24 && $timeEnd != 24)){
        $errors['timeStartEnd'] = "L'heure de début ne peut pas être supérieur ou la même que l'heure de fin.";
    }

    $price = $priceEur.$priceCent;



    if(empty($errors)) {

        $req = $connect->prepare('INSERT INTO abonnement(nom, prix, description, annee, mois, jours, semaine, temps, debutTemps, finTemps, statut) VALUES(:title, :price, :description, :years, :months, :days, :week, :time, :timeStart, :timeEnd, :status)');
        $req->execute([':title'=>$title,
            ':price'=>$price,
            ':description'=>$description,
            ':years'=>$years,
            ':months'=>$months,
            ':days'=>$days,
            ':week'=>$week,
            ':time'=>$time,
            ':timeStart'=>$timeStart,
            ':timeEnd'=>$timeEnd,
            ':status'=>0
        ]);


        $confirm[] = "L'abonnement a bien été créé";
        $_SESSION["confirmFormAuth"] = $confirm;
        header("Location: subscriptionBack.php");
        exit;
    }

    if (!empty($errors)){
        $_SESSION["errorsFormAuth"] = $errors;
        $_SESSION["dataFormAuth"] = $_POST;
        header("Location: createSubscription.php");
        exit;
    }

}else{
    $Hack[] = "Tentative de hack detectée";
    $_SESSION["hackFormAuth"] = $Hack;
    header("Location: createSubscription.php");
    exit;
}


