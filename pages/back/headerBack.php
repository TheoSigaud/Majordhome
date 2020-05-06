<?php
session_start();
require('../functions.php');
$connect = connectDb();
if (!isset($_SESSION['user']) || ($_SESSION['user']['statut'] != 2 && $_SESSION['user']['statut'] != 3)) {
    header('Location: ../login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Majord'Home</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Lien Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Lien police d'écriture -->
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <!-- Lien Icon -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="../../css/import.css">

</head>
<body onload="init(<?php echo $_GET['id'] ?>);">

<header>
    <nav class="navbar navbar-expand-lg navbar-dark" id="nav">
        <div class="container-fluid">
            <a class="navbar-brand active" href="subscriptionBack.php" title="Majord'home">
                <img class="logo" src="../../img/majordhome.png" title="logo" alt="Logo Majord'home">
            </a>


            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item ">
                        <a class="nav-link colorLink" href="category.php" title="">Catégories</a>

                    <li class="nav-item ">
                        <a class="nav-link colorLink" href="servicesBack.php" title="">Services</a>


                    <li class="nav-item ">
                        <a class="nav-link colorLink" href="subscriptionBack.php" title="Abonnements">Abonnements</a>

                    <li class="nav-item ">
                        <a class="nav-link colorLink" href="customer.php" title="Clients">Clients</a>

                    <?php
                        if ($_SESSION['user']['statut'] == 3){
                            echo  '<li class="nav-item">';
                            echo '<a class="nav-link colorLink" href="worker.php" title="Clients">Employés</a>';
                        }
                    ?>

                    <li class="nav-item">
                        <a class="nav-link colorLink" href="messagesBack.php" title="">Boîte de réception</a>
                    
                    <li class="nav-item">
                        <a class="nav-link colorLink" href="pageRequestService.php" title="">Demandes</a>

                    <li class="nav-item">
                        <a class="nav-link colorLink" href="displayQuote.php" title="">Devis</a>

                    <li class="nav-item">

                        <a class="nav-link colorLink" href="bills.php" title="">Factures</a>


                    <li class="nav-item">

                        <a class="nav-link btnServices" href="../logout.php" title="">Déconnexion</a>


                </ul>
            </div>
        </div>
    </nav>
</header>