<?php
require "headerBack.php";

$_SESSION['idCustomer'] = $_GET['id'];

if(!empty($_SESSION["confirmFormAuth"])){
    echo "<div class='alert alert-success'>";
    foreach ($_SESSION["confirmFormAuth"] as $confirm) {
        echo "<li>".$confirm;
    }
    echo "</div>";
    unset($_SESSION["confirmFormAuth"]);
}
?>



    <section >
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Abonnements</h1>
            <hr class="hr">
        </div>
        <div class="container borderSubscription">
            <a class="btn btn-success" id="add" href="subscriptionRegister.php">Ajouter un abonnement</a>
            <div class="row text-center" id="subscription"></div>
        </div>
    </section>





    <div id="content-delete" class="content-delete">
        <div class="delete">
            <span class="cross">&times;</span>
            <p>Voulez-vous vraiment supprimer ce client ?</p>
            <button class="btn btn-primary" id="no">Non</button>
            <button class="btn btn-danger" id="yes">Oui</button>
        </div>
    </div>


    <script src="../../js/subscriptionCustomer.js" type="text/javascript"></script>

<?php
require "../footer.php";
?>