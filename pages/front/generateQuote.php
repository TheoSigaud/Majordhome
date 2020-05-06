<?php
session_start();
require('../functions.php');
require('../../lib/fpdf.php');
if (isset($_GET['id']) && !empty($_GET['id'])) {
	
	$connect = connectDb();
	$updt = $connect->prepare('SELECT d.idDevis,d.titre,d.description,DATE_FORMAT(d.dateEmission,"%d/%m/%Y") as dateEmission,d.prix,p.nom,p.prenom FROM devis d,personne p WHERE d.FK_idPersonne = p.idPersonne AND idDevis = :idDev AND d.FK_idPersonne = :idPers ');
	$updt->execute([

		"idDev"=>$_GET['id'],
		"idPers"=>$_SESSION['user']['idPersonne']
	]);
	$data = $updt->fetch(PDO::FETCH_ASSOC);

	if (empty($data)) {
			
		header("Location: history.php");
	}else{

		$dateEmission = $data['dateEmission'];
		$price = $data['prix'];

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
            $this->Cell(30, 10, 'Devis', 1, 0, 'C');
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
            $fill = true;
          
                $this->Cell(185, 6, 'Titre de la prestation : ' . $data["titre"], 'LR', 0, 'L', $fill);
                $this->Ln();
                $fill = !$fill;


             

    
            // Line of the end
            $this->Cell(185, 0, '', 'T');
        }

    }

   
    $header = array('Details du devis');



    //Creation of pdf
    $pdf = new pdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 14);
    $pdf->ln(20);
    $pdf->SetDrawColor(170, 149, 111);
    $pdf->Cell(100, 20, 'Client : ' . $_SESSION['user']['nom'] . ' ' . $_SESSION['user']['prenom'], 1, 0, 'C');
    $pdf->ln(5);
    $pdf->Cell(100, 20, 'Num Devis : ' . $_GET["id"], 0, 0, 'C');
     $pdf->Cell(100, 20, 'Date Emission : ' . $dateEmission, 0, 0, 'C');
    $pdf->ln(30);
    $pdf->FancyTABLE($header, $data);

    $pdf->Write(7,"Description de la prestation : ");
    $pdf->ln();
    $pdf->setFillColor(0,0,0);
    $pdf->Cell(0,0,'',0,1,'L',true);
    $pdf->ln();
     $txt = utf8_decode($data["description"]);
    			$pdf->Write(7, $txt);
    $pdf->ln(20);
    $pdf->SetX(-100);
    $pdf->Cell(80, 20, 'Prix Total : ' . $price/100 . " euros", 1, 0, 'C');

    // file name
    $nom = 'Devis-' . $_GET['id'] . '.pdf';

    // Download of pdf (parameter D, diplay = I)
    $pdf->Output($nom, 'I');




	

}else{

	header("Location: history.php");

}