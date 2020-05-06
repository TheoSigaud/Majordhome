<?php
session_start();
if (!isset($_SESSION['user']) || ($_SESSION['user']['statut'] != 2 && $_SESSION['user']['statut'] != 3 )) {
    header('Location: ../index.php');
}

require('../lib/fpdf.php');

if (count($_POST) == 10
	&& !empty($_POST['lastname'])
	&& !empty($_POST['firstname'])
	&& !empty($_POST['profession'])
	&& !empty($_POST['address'])
	&& !empty($_POST['city'])
	&& !empty($_POST['code'])
	&& !empty($_POST['days'])
	&& !empty($_POST['place'])
	&& !empty($_POST['date'])
	&& !empty($_POST['dateContract']))

 {



$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$profession = $_POST['profession'];
$address = $_POST['address'];
$city = $_POST['city'];
$code = $_POST['code'];
$days = $_POST['days'];
$birthday = $_POST['date'];
$place = $_POST['place'];
$dateContract = $_POST['dateContract'];




 $birthday = date('d/m/Y', strtotime($birthday));
 $dateContract = date('d/m/Y', strtotime($dateContract));

 $dateDepartTimestamp = strtotime($dateContract);
 $endContract =  date('m/d/Y', strtotime('+'.$days.'year', $dateDepartTimestamp ));


class PDF extends FPDF
    {

        function Header()
        {
            // Logo
            $this->Image('../img/majordhome.png', 10, 6, 30);
            // Police Arial gras 15
            $this->SetFont('Arial', 'B', 15);
            // Décalage à droite
            $this->Cell(80);
            // Titre
            $this->SetDrawColor(170, 149, 111);
            $this->Cell(50, 10, 'Contrat de travail', 1, 0, 'C');
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

      
}
    //Creation of pdf
    $pdf = new pdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 14);
    $pdf->ln(20);
    $pdf->SetDrawColor(170, 149, 111);
    $pdf->SetFont('Arial', '', 13);

    $txt = "Entre les soussigné(e)s : ";
    $txt = utf8_decode($txt);
    $pdf->Write(20,$txt);
    $pdf->ln(20);
    $pdf->SetFont('Arial', '', 11);
    $txt = "La société Majord'Home, dont le siège est situé à Paris, representée par " . $_SESSION['user']['nom'] . " " . $_SESSION['user']['prenom'] . ", en sa qualité de Employé(e)," ;
    $txt = utf8_decode($txt);
    $pdf->Write(8,$txt);
    $pdf->ln(15);
    $txt = "Ci-après dénomée  \"l'Employeur\", " ;
    $txt = utf8_decode($txt);
    $pdf->Write(10,$txt);

    $pdf->ln(10);
    $pdf->Write(15,"Et");
    $pdf->ln(15);
    $txt = $lastname . " " .  $firstname . ", né(e) le " . $birthday . " à " . $place . ", demeurant " . $address . " " . $code . " ". $city;
    $txt = utf8_decode($txt);
    $pdf->Write(10,$txt);

    $pdf->ln(20);
    $txt = "Ci-après dénomée le \"Salarié\", " ;
    $txt = utf8_decode($txt);
    $pdf->Write(10,$txt);

    $pdf->ln(20);
    $pdf->SetFont('Arial', '', 13);
    $pdf->Write(20,"ARTICLE 1 - ENGAGEMENT");


    $pdf->ln(20);
    $pdf->SetFont('Arial', '', 11);
    $txt = "Sous réserve des résultats de la visite médicale d'embauche, le Salarié est engagé à compter du " . $dateContract . " en qualité de " . $profession . ".";
    $txt = utf8_decode($txt);
    $pdf->Write(8,$txt);

    $pdf->ln(15);
    $pdf->SetFont('Arial', '', 13);
    $pdf->Write(20,"ARTICLE 2 - DUREE DE CONTRAT");

    $pdf->ln(20);
    $pdf->SetFont('Arial', '', 11);
    $txt = "Le présent contrat, qui prend effet le " . $dateContract . ", est conclu pour une durée déterminée de " . $days . " ans et prendra fin le " . $endContract ;
    $txt = utf8_decode($txt);
    $pdf->Write(8,$txt);

    $pdf->ln(25);
    $pdf->SetFont('Arial', '', 13);
    $pdf->Write(30,"ARTICLE 3 - FONCTIONS");

    $pdf->ln(25);
    $pdf->SetFont('Arial', '', 11);
    $txt = "Le Salarié exercera les fonctions de " . $profession;
    $txt = utf8_decode($txt);
    $pdf->Write(8,$txt);
    $pdf->ln(5);
    $txt = "Le Salarié consacrera à l'accomplissement des différentes tâches lui incombant les soins les plus diligents.";
    $txt = utf8_decode($txt);
    $pdf->Write(20,$txt);


    $pdf->ln(15);
    $pdf->SetFont('Arial', '', 13);
    $pdf->Write(20,"ARTICLE 4 - REMUNERATION");

    $pdf->ln(15);
    $pdf->SetFont('Arial', '', 11);
    $txt = "En contrepartie de son travail, le Salarié percevra une rémunération de 40 % sur chaque prestation.";
    $txt = utf8_decode($txt);
    $pdf->Write(20,$txt);


    $pdf->ln(15);
    $pdf->SetFont('Arial', '', 13);
    $pdf->Write(20,"ARTICLE 5 - MATERIELS ET DOCUMENTS");

    $pdf->ln(20);
    $pdf->SetFont('Arial', '', 11);
    $txt = "L'employeur pourra être amené à confier au Salarié des produits, matériels, plans, fichiers et documents divers. Il s'interdit expressément d'en faire un autre usage que celui autorisé par son employeur et s'engage à les lui présenter ou les lui restituer sur simple demande. Au cours de l'exécution du présent contrat et après sa cessation pour quelque cause que ce soit pendant une durée de 10 ans, le Salarié sera tenu à une discrétion absolue sur tous les faits, événements, documents ou renseignements dont il/elle aurait eu connaissance en raison de ses fonctions ou de son appartenance à l'Employeur, et qui concerne tant sa gestion et son fonctionnement que son savoir-faire et ses projets et clients. Cette clause constitue une clause essentielle du présent contrat et tout manquement à l'obligation de réserve est susceptible de constituer une faute grave entraînant la rupture anticipée du présent contrat et engageant la responsabilité du Salarié à l'égard de l'Employeur.";
    $txt = utf8_decode($txt);
    $pdf->Write(8,$txt);

 	$pdf->ln(15);
 	$txt = "Fait en double exemplaire, dont un est remis a chacune des parties,";
    $txt = utf8_decode($txt);
 	$pdf->Write(8,$txt);
 	$pdf->ln(15);
 	$pdf->Write(8,"A _________________________, le __________________");
    

 	$pdf->ln(20);
 	$pdf->Write(8,"L'employeur,");

    $pdf->SetX(-100);
    $txt = "Le Salarié,";
    $txt = utf8_decode($txt);
 	$pdf->Write(8,$txt);
   
  
 

    // Download of pdf (parameter D, diplay = I)
    $pdf->Output('contrat.pdf', 'I');



}