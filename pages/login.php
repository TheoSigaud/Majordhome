<?php
session_start();

if (isset($_SESSION['user']) && $_SESSION['user']['statut'] == 0) {
    header('Location: front/services.php');
}else if (isset($_SESSION['user']) && ($_SESSION['user']['statut'] == 2 || $_SESSION['user']['statut'] == 3)){
    header('Location: back/subscriptionBack.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Inscription</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../css/login.css">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Lien Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<!-- Lien police d'écriture -->
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

  <!-- Lien Icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark" id="nav">
        <div class="container">
            <a class="navbar-brand active" href="../index.php" title="">
                <img class="logo" src="../img/majordhome.png" title="logo" alt="Logo Majord'home">
            </a>
        </div>
    </nav>
</header>

<section>

    <?php

            if(!empty($_SESSION["confirmFormAuth"])){
            echo "<div class='alert alert-success'>";
                foreach ($_SESSION["confirmFormAuth"] as $confirm) {
                echo "<li>".$confirm;
                    }
                    echo "</div>";
            unset($_SESSION["confirmFormAuth"]);
            }


          if(!empty($_SESSION["errorsAuth"])){
            echo "<div class='alert alert-danger'>";

                echo "<li>".$_SESSION["errorsAuth"];

            echo "</div>";
            unset($_SESSION["errorsAuth"]);
        }
    ?>



 <div class="container">
    <div class="form">
    <form class="formLogin" action="auth.php" method="post">


    <h3 class="text-center title">Connectez-vous</h3>
    <hr class="hr">
   
    

        <div class="form-group">
            <label for="inputEmail">Email *</label>
            <input name="email" type="email" id="inputEmail" class="form-control" placeholder="jeandufour@gmail.com" required="required">
        </div>

        <div class="form-group">
            <label for="pwd">Mot de passe *</label>
            <input name="pwd" type="password" id="pwd" class="form-control" placeholder="*****" required="required">
        </div>

   

    <i class="p-2">* Champs obligatoires</i>
    <br>
    <a href="register.php" class="p-3">Je n'ai pas de compte</a>
    <br>

        <center><button class="btn m-3" id="btnLogin" type="submit">Connexion</button></center>

        </div>
    </form>
    </div>
    </div>
</section>




<footer>
  
  <p class="text-center pt-4">Copyright © Majord'home 2020</p>
 
</footer>







<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>