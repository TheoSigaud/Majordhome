<?php
require("header.php");

if (!isset($_GET['date'])){
    header('Location: dashboard.php');
}

$date = $_GET['date'];

echo "<input type='date' id='date' value='".$date."'>";

$date = explode('-', $date);

?>



<h1 id="titleAttribution"><?php echo $date[2]."-".$date[1]."-".$date[0] ?></h1>



<table class="table table-striped" id="tableAttribution">
    <thead>
    <tr>
        <th scope="col">Client</th>
        <th scope="col">Service</th>
        <th scope="col">Date Réservation</th>
        <th scope="col">Date Intervention</th>
        <th scope="col">Durée</th>
        <th scope="col">Attribution</th>
    </tr>
    </thead>
    <tbody id="reservation">
    </tbody>
</table>


<script src="../js/attribution.js" type="text/javascript"></script>
</body>
</html