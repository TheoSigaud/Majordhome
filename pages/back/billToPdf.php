<?php
session_start();

require('../../lib/fpdf.php');
require ('../functions.php');


if (isset($_GET['id']) && !empty($_GET['id'])) {
	
$connect=  connectDb();

$query = $connect->query("SELECT FK_idSouscriptionService FROM facture WHERE idFacture =".$_GET['id']);
$query->execute();
$serv=$query->fetch(PDO::FETCH_ASSOC);


$query = $connect->query("SELECT FK_idSouscriptionAbonnement FROM facture WHERE idFacture =".$_GET['id']);
$query->execute();
$subs=$query->fetch(PDO::FETCH_ASSOC);



if(empty($serv) && empty($subs) ){

    header('Location: ../../404.php');
}else {

    if ($subs["FK_idSouscriptionAbonnement"] == NULL) {
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
    $query = $connect->prepare("SELECT DATE_FORMAT(f.dateEmission,\"%d/%m/%Y\") as date,prixTotal,p.nom,p.prenom FROM facture f , personne p WHERE f.idFacture= ? AND f.FK_idPersonne=p.idPersonne");
    $query->execute([$_GET['id']]);
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $result) {
        $date = $result["date"];
        $price = $result["prixTotal"] / 100;
        $nom = $result["nom"];
        $prenom = $result["prenom"];
    }
    $stringDevice = " euros";
    $header = array('Details');


    if ($nameDelivery == "service"){


        $query = $connect->prepare("SELECT service.nom,prixTotal,sommeVersee,sommeRestante FROM facture, souscription_service, service WHERE FK_idSouscriptionService= ? AND facture.FK_idSouscriptionService = souscription_service.idSouscriptionService AND souscription_service.FK_idService = service.idService");
    	$query->execute([$serv["FK_idSouscriptionService"]]);
    }else{
        $query = $connect->prepare("SELECT abonnement.nom,prixTotal,sommeVersee,sommeRestante FROM facture, souscription_abonnement,abonnement WHERE FK_idSouscriptionAbonnement= ? AND facture.FK_idSouscriptionAbonnement = souscription_abonnement.idSouscriptionAbonnement AND souscription_abonnement.FK_idAbonnement = abonnement.idAbonnement");
    	$query->execute([$subs["FK_idSouscriptionAbonnement"]]);

    }
    
    $data = $query->fetchAll(PDO::FETCH_BOTH);

    



    //Creation of pdf
    $pdf = new pdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 14);
    $pdf->ln(20);
    $pdf->SetDrawColor(170, 149, 111);
    $pdf->Cell(100, 20, 'Client : ' . $_SESSION['user']['nom'] . ' ' . $_SESSION['user']['prenom'], 1, 0, 'C');
    $pdf->ln(5);
    $pdf->Cell(100, 20, 'Numero facture : ' . $_GET["id"], 0, 0, 'C');
    $pdf->Cell(100, 20, 'Date Emission : ' . $date, 0, 0, 'C');
    $pdf->ln(30);
    $pdf->FancyTABLE($header, $data);
    $pdf->ln(20);
    $pdf->SetX(-100);
    $pdf->Cell(80, 20, 'Prix Total : ' . $price . $stringDevice, 1, 0, 'C');

    // file name
    $nom = 'Facture-' . $_GET['id'] . '.pdf';

    // Download of pdf (parameter D, diplay = I)
    $pdf->Output($nom, 'I');

}





























}else{


	header("Location: bills.php");
}