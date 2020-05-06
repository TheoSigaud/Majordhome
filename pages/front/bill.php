<?php
session_start();

require('../../lib/fpdf.php');
require ('../functions.php');

// Check permission of the client
$connect=  connectDb();

$query = $connect->query("SELECT count(idSouscriptionService) as count FROM souscription_service WHERE souscription_service.FK_idPersonne =".$_SESSION['user']['idPersonne']." AND idSouscriptionService =".$_GET['id']);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_ASSOC);

foreach ( $results as $result) {
    $countService = $result["count"];
}

$query = $connect->query("SELECT count(idSouscriptionAbonnement) as count FROM souscription_abonnement WHERE souscription_abonnement.FK_idPersonne =".$_SESSION['user']['idPersonne']." AND idSouscriptionAbonnement =".$_GET['id']);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_ASSOC);

foreach ( $results as $result) {
    $countSouscription = $result["count"];
}



if($countService==0 && $countSouscription==0 ){

    header('Location: ../../404.php');
}else {

    if ($countService != 0) {
        $nameDelivery = "service";
    } else {
        $nameDelivery = "abonnement";
    }


    class PDF extends FPDF
    {

        function Header()
        {
            // Logo
            $this->Image('../../img/majordhome.png', 10, 6, 30);
            // Police Arial gras 15
            $this->SetFont('Arial', 'B', 15);
            // Décalage à droite
            $this->Cell(80);
            // Titre
            $this->SetDrawColor(170, 149, 111);
            $this->Cell(30, 10, 'Facture', 1, 0, 'C');
            // Saut de ligne
            $this->Ln(20);
        }


        function Footer()
        {
            $this->SetFont('Arial', 'I', 8);
            // Positionnement à 3,0 cm du bas
            $this->SetY(-20);
            //Droit entreprise
            $this->Cell(190, 10, 'Entreprise de HomeService Majord\'home - Siege social PARIS', 0, 0, 'C');
            // Positionnement à 1,5 cm du bas
            $this->SetY(-15);
            // Police Arial italique 8
            $this->SetFont('Arial', 'I', 8);
            // Numéro de page
            $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
        }

        function LoadData($file)
        {
            // Lecture des lignes du fichier
            $lines = file($file);
            $data = array();
            foreach ($lines as $line)
                $data[] = explode(';', trim($line));
            return $data;
        }

        function FancyTable($header, $data)
        {
            // Couleurs, épaisseur du trait et police grasse
            $this->SetFillColor(35, 39, 45);
            $this->SetTextColor(170, 149, 111);
            $this->SetDrawColor(170, 149, 111);
            $this->SetLineWidth(.3);
            $this->SetFont('', 'B');
            // En-tête
            for ($i = 0; $i < count($header); $i++)
                $this->Cell(185, 7, $header[$i], 1, 0, 'C', true);
            $this->Ln();
            // Restauration des couleurs et de la police
            $this->SetFillColor(228, 213, 210);
            $this->SetTextColor(0);
            $this->SetFont('');
            // Données
            $fill = false;
            foreach ($data as $row) {
                $this->Cell(185, 6, 'Prestation facturee : ' . $row[0], 'LR', 0, 'L', $fill);
                $this->Ln();
                $fill = !$fill;
                $this->Cell(185, 6, 'Prix total de la prestation : ' . ($row[1] / 100) . ' euros', 'LR', 0, 'L', $fill);
                $this->Ln();
                $fill = !$fill;
                $this->Cell(185, 6, 'Somme deja versee  : ' . ($row[2] / 100) . ' euros', 'LR', 0, 'L', $fill);
                $this->Ln();
                $fill = !$fill;
                $this->Cell(185, 6, 'Reste somme due : ' . ($row[3] / 100) . ' euros', 'LR', 0, 'L', $fill);
                $this->Ln();

            }
            // Line of the end
            $this->Cell(185, 0, '', 'T');
        }

    }

    //Load of data
    $query = $connect->query("SELECT DATE_FORMAT(dateEmission,\"%d/%m/%Y\") as date,prixTotal FROM facture WHERE FK_idSouscriptionService=" . $_GET["id"] . " OR FK_idSouscriptionAbonnement=" . $_GET["id"]);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $result) {
        $date = $result["date"];
        $price = $result["prixTotal"] / 100;
    }
    $stringDevice = " euros";
    $header = array('Details');

    if ($nameDelivery == "service")
        $query = $connect->query("SELECT service.nom,prixTotal,sommeVersee,sommeRestante FROM facture, souscription_service, service WHERE FK_idSouscriptionService=" . $_GET["id"] . " AND facture.FK_idSouscriptionService = souscription_service.idSouscriptionService AND souscription_service.FK_idService = service.idService");
    else
        $query = $connect->query("SELECT abonnement.nom,prixTotal,sommeVersee,sommeRestante FROM facture, souscription_abonnement,abonnement WHERE FK_idSouscriptionAbonnement= " . $_GET["id"] . " AND facture.FK_idSouscriptionAbonnement = souscription_abonnement.idSouscriptionAbonnement AND souscription_abonnement.FK_idAbonnement = abonnement.idAbonnement");

    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_BOTH);



    //Creation of pdf
    $pdf = new pdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 14);
    $pdf->ln(20);
    $pdf->SetDrawColor(170, 149, 111);
    $pdf->Cell(100, 20, 'Client : ' . $_SESSION['user']['nom'] . ' ' . $_SESSION['user']['prenom'], 1, 0, 'C');
    $pdf->ln(5);
    $pdf->Cell(100, 20, 'Code souscription : ' . $_GET["id"], 0, 0, 'C');
    $pdf->Cell(100, 20, 'Date Emission : ' . $date, 0, 0, 'C');
    $pdf->ln(30);
    $pdf->FancyTABLE($header, $data);
    $pdf->ln(20);
    $pdf->SetX(-100);
    $pdf->Cell(80, 20, 'Prix Total : ' . $price . $stringDevice, 1, 0, 'C');

    // file name
    $nom = 'Facture-' . $_GET['id'] . '.pdf';

    // Download of pdf (parameter D, diplay = I)
    $pdf->Output($nom, 'D');

}

?>