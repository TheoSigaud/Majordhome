<?php
require "headerBack.php";


if(!empty($_GET)){
    $id = $_GET['id'];
}else{
    $id = 0;
}

$req = $connect->prepare("SELECT prenom, nom, mail, dateNaissance, telephone, adresse, ville, codePostal FROM personne WHERE idPersonne = $id");
$req->execute(array());
$customer = $req->fetch();

$count = $req->rowCount();

if ($count == 0){
    header('Location: 404.php');
}

$_SESSION["id"] = $id;
?>


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

        <h3 class="text-center title">Modification d'un client</h3>
        <hr class="hr">
        
        <div class="form">
            <form class="form-signin" action="updateCustomer.php" method="post">

                <div class="row pt-4">
                    <div class="col-md-6">
                        <label for="firstName">Prénom *</label>
                        <input name="firstName" type="text" id="firstName" class="form-control inputRegister" placeholder="Jean" required="" autocomplete="off" autofocus="" value="<?php echo isset($_SESSION["dataFormAuth"]["firstName"])?$_SESSION["dataFormAuth"]["firstName"]:$customer['prenom'] ?>">
                    </div>

                    <div class=" col-md-6">
                        <label for="lastName">Nom *</label>
                        <input name="lastName" type="text" id="lastName" class="form-control inputRegister" placeholder="Dufour" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["lastName"])?$_SESSION["dataFormAuth"]["lastName"]:$customer['nom'] ?>">
                    </div>

                </div>

                <div class="">
                    <label for="inputEmail">Email *</label>
                    <input name="email" type="email" id="inputEmail" class="form-control inputRegister" placeholder="jeandufour@gmail.com" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["email"])?$_SESSION["dataFormAuth"]["email"]:$customer['mail'] ?>">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="date">Date de naissance *</label>
                        <input name="date" type="date" id="date" class="form-control inputRegister" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["date"])?$_SESSION["dataFormAuth"]["date"]:$customer['dateNaissance'] ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="phone">Téléphone *</label>
                        <input name="phone" type="tel" id="phone" class="form-control inputRegister" placeholder="0606060606" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["phone"])?$_SESSION["dataFormAuth"]["phone"]:$customer['telephone'] ?>">
                    </div>

                </div>

                <div class="">
                    <label for="address">Adresse *</label>
                    <input name="address" type="text" id="address" class="form-control inputRegister" placeholder="75 rue George" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["address"])?$_SESSION["dataFormAuth"]["address"]:$customer['adresse'] ?>">
                </div>

                <div class="row">

                    <div class=" col-md-6">
                        <label for="city">Ville *</label>
                        <input name="city" type="text" id="city" class="form-control inputRegister" placeholder="Paris" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["city"])?$_SESSION["dataFormAuth"]["city"]:$customer['ville'] ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="code">Code postal *</label>
                        <input name="code" type="text" id="code" class="form-control inputRegister" placeholder="75000" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["code"])?$_SESSION["dataFormAuth"]["code"]:$customer['codePostal'] ?>">
                    </div>


                </div>

                <label for="pwd">Générer un nouveau mot de passe *</label>
                <select name="pwd" id="pwd" class="form-control" required="">
                    <option value="no">Non</option>
                    <option value="yes">Oui</option>
                </select>


                <div class="row">

                    <i class="p-2">* Champs obligatoires</i>
                    <br>

                    <button class="btn m-3" id="btnSubscription" type="submit">Modifier</button>

                </div>
            </form>
        </div>
    </div>
</section>

<?php
unset($_SESSION["dataFormAuth"]);
require "../footer.php";
?>