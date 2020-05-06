<?php
require "headerBack.php";

if ($_SESSION['user']['statut'] != 3) {
    header('Location: ../login.php');
}

if (!empty($_SESSION["confirmFormAuth"])) {
    echo "<div class='alert alert-success'>";
    foreach ($_SESSION["confirmFormAuth"] as $confirm) {
        echo "<li>" . $confirm;
    }
    echo "</div>";
    unset($_SESSION["confirmFormAuth"]);
}


if (!empty($_SESSION["delete"])) {
    echo "<div class='alert alert-danger'>";
    foreach ($_SESSION["delete"] as $delete) {
        echo "<li>" . $delete;
    }
    echo "</div>";
    unset($_SESSION["delete"]);
}


?>


    <section>
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Employés</h1>
            <hr class="hr">
        </div>
        <div class="container borderCustomer">
            <a class="btn btn-success" id="add" href="createWorker.php">Ajouter un employé</a>
            <div class="container">

                <div class="row">
                    <label for="type">Trier par:</label>
                    <select name="type" id="type" class="form-control">
                        <option value="nom">Nom</option>
                        <option value="prenom">Prénom</option>
                        <option value="dateNaissance">Date de naissance</option>
                        <option value="adresse">Adresse</option>
                        <option value="ville">Ville</option>
                        <option value="codePostal">Code Postal</option>
                        <option value="telephone">Téléphone</option>
                    </select>

                    <input class="form-control" type="text" id="search" placeholder="Rechercher">

                </div>

                <div id="tab">
                    <table class="table table-bordered">
                        <thead>
                        <th scope="col">Prénom</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Date de naissance</th>
                        <th scope="col">Adresse</th>
                        <th scope="col">Ville</th>
                        <th scope="col">Code postal</th>
                        <th scope="col">Téléphone</th>
                        <th scope="col">Actions</th>
                        </thead>
                        <tbody id="worker">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    <div id="content-delete" class="content-delete">
        <div class="delete">
            <span class="cross">&times;</span>
            <p>Voulez-vous vraiment supprimer cet employé ?</p>
            <button class="btn btn-primary" id="no">Non</button>
            <button class="btn btn-danger" id="yes">Oui</button>
        </div>
    </div>


    <script src="../../js/worker.js" type="text/javascript"></script>

<?php
require "../footer.php";
?>