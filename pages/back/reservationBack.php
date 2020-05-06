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

if (!empty($_SESSION["service"])) {
    echo "<div class='alert alert-danger'>";
    echo "<li>" . $_SESSION['service'];
    echo "</div>";
    unset($_SESSION["service"]);
}

if (!empty($_SESSION["numberService"])) {
    echo "<div class='alert alert-danger'>";
    echo "<li>" . $_SESSION['numberService'];
    echo "</div>";
    unset($_SESSION["numberService"]);
}
?>



    <section >
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Réservations</h1>
            <hr class="hr">
        </div>
        <div class="container borderCustomer">
            <a class="btn btn-success" id="add" href="addReservation.php">Ajouter une réservation</a>
            <div class="container">

                <div id="tab">
                    <table class="table table-bordered">
                        <thead>
                        <th scope="col">Nom</th>
                        <th scope="col">Date de la réservation</th>
                        <th scope="col">Date de l'intervention</th>
                        <th scope="col">Durée</th>
                        <th scope="col">Statut de la réservation</th>
                        <th scope="col">Statut du paiement</th>
                        <th scope="col">Nombre de paiements</th>
                        <th scope="col">Actions</th>
                        </thead>
                        <tbody id="reservation">
                        </tbody>
                    </table>
                </div>
            </div>
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


    <script src="../../js/reservationBack.js" type="text/javascript"></script>

<?php
require "../footer.php";
?>