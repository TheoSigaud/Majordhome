<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Inscription</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../css/register.css">
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
            <a class="navbar-brand active" href="index.php" title="">
                <img class="logo" src="../img/majordhome.png" title="logo" alt="Logo Majord'home">
            </a>
        </div>
    </nav>
</header>


<section >
    <?php if(!empty($_SESSION["errorsFormAuth"])){
        echo "<div class='alert alert-danger'>";
        foreach ($_SESSION["errorsFormAuth"] as $error) {
            echo "<li>".$error;
        }
        echo "</div>";
        unset($_SESSION["errorsFormAuth"]);
    }


    if(!empty($_SESSION["hackFormAuth"])){
        echo "<div class='alert alert-danger'>";
        foreach ($_SESSION["hackFormAuth"] as $hack) {
            echo "<li>".$hack;
        }
        echo "</div>";
        unset($_SESSION["hackFormAuth"]);
    }
    ?>


    <div class="container">
    <div class="form">
    <form class="form-signin" action="saveUser.php" method="post">


    <h3 class="text-center title">Créer un compte</h3>
    <hr class="hr">
   
    <div class="row pt-4">
        <div class="col-md-6">
            <label for="firstName">Prénom *</label>
            <input name="firstName" type="text" id="firstName" class="form-control inputRegister" placeholder="Jean" required="" autocomplete="off" autofocus="" value="<?php echo isset($_SESSION["dataFormAuth"]["firstName"])?$_SESSION["dataFormAuth"]["firstName"]:"" ?>">
        </div>

        <div class=" col-md-6">
            <label for="lastName">Nom *</label>
            <input name="lastName" type="text" id="lastName" class="form-control inputRegister" placeholder="Dufour" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["lastName"])?$_SESSION["dataFormAuth"]["lastName"]:"" ?>">
        </div>

    </div>

        <div class="">
            <label for="inputEmail">Email *</label>
            <input name="email" type="email" id="inputEmail" class="form-control inputRegister" placeholder="jeandufour@gmail.com" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["email"])?$_SESSION["dataFormAuth"]["email"]:"" ?>">
        </div>

        <div class="row">
        <div class="col-md-6">
            <label for="date">Date de naissance *</label>
            <input name="date" type="date" id="date" class="form-control inputRegister" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["date"])?$_SESSION["dataFormAuth"]["date"]:"" ?>">
        </div>

        <div class="col-md-6">
            <label for="phone">Téléphone *</label>
            <input name="phone" type="tel" id="phone" class="form-control inputRegister" placeholder="0606060606" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["phone"])?$_SESSION["dataFormAuth"]["phone"]:"" ?>">
        </div>

        </div>

        <div class="">
            <label for="address">Adresse *</label>
            <input name="address" type="text" id="address" class="form-control inputRegister" placeholder="75 rue George" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["address"])?$_SESSION["dataFormAuth"]["address"]:"" ?>">
        </div>

        <div class="row">

        <div class=" col-md-6">
            <label for="city">Ville *</label>
            <input name="city" type="text" id="city" class="form-control inputRegister" placeholder="Paris" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["city"])?$_SESSION["dataFormAuth"]["city"]:"" ?>">
        </div>

        <div class="col-md-6">
            <label for="code">Code postal *</label>
            <input name="code" type="text" id="code" class="form-control inputRegister" placeholder="75000" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["code"])?$_SESSION["dataFormAuth"]["code"]:"" ?>">
        </div>


        </div>

        <div class="">
            <label for="inputPassword">Mot de passe *</label>
            <input name="pwd" type="password" id="inputPassword" class="form-control inputRegister" required="" autocomplete="off">
        </div>

        <div class="">
            <label for="inputConfirm">Confirmation du mot de passe *</label>
            <input name="pwdConfirm" type="password" id="inputConfirm" class="form-control inputRegister" required="" autocomplete="off">
        </div>


        <div class="row">

        <div class="col-md-6">
        <img class="pb-3" src="../captcha/image.php" width="200px">
    </div>
    <div class="col-md-6">
        <input name="captcha" type="captcha" id="captcha" class="form-control inputRegister" placeholder="Veuillez saisir le captcha *" required="" autocomplete="off">
    </div>

    <i class="p-2">* Champs obligatoires</i>
    <br>

        <button class="btn m-3" id="btnSubscription" type="submit">Inscription</button>

        </div>
    </form>
    </div>
    </div>
</section>
<?php unset($_SESSION["dataFormAuth"]);?>

<footer>

    <p class="text-center pt-4">Copyright © Majord'home 2020</p>

</footer>



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>