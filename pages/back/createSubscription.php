<?php
require "headerBack.php";
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
    ?>

    <?php if(!empty($_SESSION["hackFormAuth"])){
        echo "<div class='alert alert-danger'>";
        foreach ($_SESSION["hackFormAuth"] as $hack) {
            echo "<li>".$hack;
        }
        echo "</div>";
        unset($_SESSION["hackFormAuth"]);
    }
    ?>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Création d'un abonnement</h1>
        <hr class="hr">
    </div>
    <div class="container borderSubscription">
        <form method="POST" action="saveSubscription.php">

            <label for="title" class="lab">Titre *</label>
            <input id="title" type="text" class="form-control" required="required" name="title" placeholder="Titre" autofocus="" value="<?php echo isset($_SESSION["dataFormAuth"]["title"])?$_SESSION["dataFormAuth"]["title"]:"" ?>">


            <div class="row pt-4">
                <div class="col-md-6">
                    <label for="priceEur">Euros *</label>
                    <input name="priceEur" type="number" id="priceEur" class="form-control inputRegister" placeholder="20" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["priceEur"])?$_SESSION["dataFormAuth"]["priceEur"]:"" ?>">
                </div>

                <div class=" col-md-6">
                    <label for="priceCent">Centimes *</label>
                    <input name="priceCent" type="number" id="priceCent" class="form-control inputRegister" placeholder="99" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["priceCent"])?$_SESSION["dataFormAuth"]["priceCent"]:"00" ?>">
                </div>

            </div>


            <div class="row pt-4">


                <div class="col-md-6">
                    <label for="time">Nombre de services par mois</label>
                    <input name="time" type="number" id="time" class="form-control inputRegister" placeholder="5" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["days"])?$_SESSION["dataFormAuth"]["days"]:"" ?>">
                </div>

                <div class="col-md-6">
                    <label for="week">Nombre de jours par semaine *</label>
                    <select name="week" id="week" class="custom-select d-block w-100">
                        <?php
                        for ($i = 1; $i < 8; $i++){
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>
                </div>


            </div>

            <div class="custom-control custom-checkbox">
                <input name="unlimited" type="checkbox" class="custom-control-input" id="unlimited">
                <label class="custom-control-label" for="unlimited">Nombre de services illimités</label>
            </div>

            <div class="row pt-4">

                <div class="col-md-6">
                    <label for="timeStart">Heure de début *</label>
                    <select name="timeStart" id="timeStart" class="custom-select d-block w-100">
                        <?php
                        for ($i = 1; $i < 25; $i++){
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="timeEnd">Heure de fin *</label>
                    <select name="timeEnd" id="timeEnd" class="custom-select d-block w-100">
                        <?php
                        for ($i = 1; $i < 25; $i++){
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="row pt-4">

                <div class="col-md-4">
                    <label for="years">Nombre d'années *</label>
                    <select name="years" id="years" class="custom-select d-block w-100">
                        <?php
                            for ($i = 0; $i < 11; $i++){
                                echo '<option value="'.$i.'">'.$i.'</option>';
                            }
                        ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="months">Nombre de mois *</label>
                    <select name="months" id="months" class="custom-select d-block w-100">
                        <?php
                        for ($i = 0; $i < 12; $i++){
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="days">Nombre de jours *</label>
                    <input name="days" type="number" id="days" class="form-control inputRegister" placeholder="5" required="" autocomplete="off" value="<?php echo isset($_SESSION["dataFormAuth"]["days"])?$_SESSION["dataFormAuth"]["days"]:"0" ?>">
                </div>



            </div>



            <label for="description" class="lab area">Description *</label>
            <textarea id="description" class="form-control area" name="description" required="required" rows="3"><?php echo isset($_SESSION["dataFormAuth"]["description"])?$_SESSION["dataFormAuth"]["description"]:"" ?></textarea>


            <input type="submit" class="btn btn-success area" value="Ajouter un abonnement">

        </form>
    </div>
</section>
<?php
unset($_SESSION["dataFormAuth"]);
require "../footer.php";
?>
