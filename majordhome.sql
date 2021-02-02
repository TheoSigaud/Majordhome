-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 02, 2021 at 05:06 PM
-- Server version: 5.7.24-log
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `majordhome`
--

-- --------------------------------------------------------

--
-- Table structure for table `abonnement`
--

CREATE TABLE `abonnement` (
  `idAbonnement` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prix` int(32) NOT NULL,
  `description` text NOT NULL,
  `annee` int(11) NOT NULL,
  `mois` int(11) NOT NULL,
  `jours` int(11) NOT NULL,
  `semaine` int(11) NOT NULL,
  `debutTemps` int(11) NOT NULL,
  `finTemps` int(11) NOT NULL,
  `temps` int(11) NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `abonnement`
--

INSERT INTO `abonnement` (`idAbonnement`, `nom`, `prix`, `description`, `annee`, `mois`, `jours`, `semaine`, `debutTemps`, `finTemps`, `temps`, `statut`) VALUES
(3, 'Abonnement de base', 240000, 'Magnifique', 1, 0, 0, 5, 9, 20, 12, 0),
(6, 'Abonnement Familial', 360000, 'Magnifique description', 1, 0, 0, 6, 9, 20, 25, 0),
(7, 'Abonnement Premium', 600000, 'Superbe', 1, 0, 0, 1, 24, 24, 50, 0);

-- --------------------------------------------------------

--
-- Table structure for table `caracteristique`
--

CREATE TABLE `caracteristique` (
  `idCaracteristique` int(11) NOT NULL,
  `nom` varchar(80) NOT NULL,
  `type` varchar(50) NOT NULL,
  `idService` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `caracteristique`
--

INSERT INTO `caracteristique` (`idCaracteristique`, `nom`, `type`, `idService`) VALUES
(20, 'Nom', 'text', 3),
(21, 'Prénom', 'text', 3),
(23, 'banane', 'text', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `idCategorie` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`idCategorie`, `nom`, `description`) VALUES
(89, 'Voyage', NULL),
(90, 'Plombier Cuisine', NULL),
(91, 'Coiffure', NULL),
(92, 'Esthéticienne', NULL),
(93, 'Manucure', NULL),
(94, 'Boulanger', NULL),
(95, 'Plombier Salle de bain', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `devis`
--

CREATE TABLE `devis` (
  `idDevis` int(11) NOT NULL,
  `titre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `FK_idPersonne` int(11) NOT NULL,
  `dateEmission` datetime NOT NULL,
  `dateValidation` datetime DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `FK_idSouscriptionService` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `devis`
--

INSERT INTO `devis` (`idDevis`, `titre`, `description`, `prix`, `FK_idPersonne`, `dateEmission`, `dateValidation`, `statut`, `FK_idSouscriptionService`) VALUES
(1, 'eeeeeeeeeeeeeeeeee', 'ffe', 1100, 59, '2020-05-02 00:00:00', '2020-05-02 00:00:00', 1, 'kucgHhi3gp'),
(2, 'hrht', 'erge', 1020, 59, '2020-05-02 00:00:00', '2020-05-02 00:00:00', 1, 'SrrQkm7dkt');

-- --------------------------------------------------------

--
-- Table structure for table `donnees_service`
--

CREATE TABLE `donnees_service` (
  `id` int(11) NOT NULL,
  `information` text COLLATE utf8_unicode_ci,
  `FK_idSouscriptionService` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FK_idCaracteristique` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `donnees_service`
--

INSERT INTO `donnees_service` (`id`, `information`, `FK_idSouscriptionService`, `FK_idCaracteristique`) VALUES
(402, 'rzegf', 'uOsWoPGq4L', 20),
(403, 'ZFES', 'uOsWoPGq4L', 21),
(404, 'erzhfu ', 'AEOA3QANsY', 20),
(405, 'eiufhbn', 'AEOA3QANsY', 21),
(406, 'efz', 'ZWPSGgxXnt', 20),
(407, 'sefd', 'ZWPSGgxXnt', 21),
(408, 'efz', 'fTPGObecMD', 20),
(409, 'sefd', 'fTPGObecMD', 21),
(410, 'dff', '7y4bkYJrSS', 20),
(411, 'dfbdf', '7y4bkYJrSS', 21),
(412, 'ezafz', 'kucgHhi3gp', NULL),
(413, '2020-10-23', 'kucgHhi3gp', NULL),
(414, '10:00', 'kucgHhi3gp', NULL),
(415, 'rgqze', 'kucgHhi3gp', NULL),
(416, 'zfgz', 'kucgHhi3gp', NULL),
(417, '75016', 'kucgHhi3gp', NULL),
(418, 'zfzf', 'SrrQkm7dkt', NULL),
(419, '2020-10-23', 'SrrQkm7dkt', NULL),
(420, '11:11', 'SrrQkm7dkt', NULL),
(421, 'iugi', 'SrrQkm7dkt', NULL),
(422, 'huvjk', 'SrrQkm7dkt', NULL),
(423, '75016', 'SrrQkm7dkt', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `facture`
--

CREATE TABLE `facture` (
  `idFacture` int(11) NOT NULL,
  `prixTotal` double NOT NULL,
  `sommeVersee` double NOT NULL,
  `sommeRestante` double NOT NULL,
  `dateEmission` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dateFinFacturation` datetime DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `FK_idPersonne` int(11) NOT NULL,
  `FK_idSouscriptionService` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FK_idSouscriptionAbonnement` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombreEcheance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `facture`
--

INSERT INTO `facture` (`idFacture`, `prixTotal`, `sommeVersee`, `sommeRestante`, `dateEmission`, `dateFinFacturation`, `statut`, `FK_idPersonne`, `FK_idSouscriptionService`, `FK_idSouscriptionAbonnement`, `nombreEcheance`) VALUES
(114, 4900, 4900, 0, '2020-04-19 18:12:36', '2020-04-19 18:12:36', 1, 59, 'uOsWoPGq4L', NULL, 1),
(115, 4900, 4900, 0, '2020-04-19 18:13:20', '2020-04-19 18:13:20', 1, 59, 'AEOA3QANsY', NULL, 1),
(116, 4900, 4900, 0, '2020-04-19 18:13:51', '2020-04-19 18:13:51', 1, 59, 'ZWPSGgxXnt', NULL, 1),
(117, 4900, 4900, 0, '2020-04-19 18:13:59', '2020-04-19 18:13:59', 1, 59, 'fTPGObecMD', NULL, 1),
(118, 4900, 0, 4900, '2020-04-20 09:39:21', NULL, 0, 59, '7y4bkYJrSS', NULL, 4),
(119, 1100, 1100, 0, '2020-05-02 13:52:37', '2020-05-02 13:52:37', 1, 59, 'kucgHhi3gp', NULL, 1),
(120, 1020, 0, 1020, '2020-05-02 11:38:24', '2020-06-02 13:38:24', 0, 59, 'SrrQkm7dkt', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messagerie`
--

CREATE TABLE `messagerie` (
  `idMessagerie` int(11) NOT NULL,
  `statut` int(11) NOT NULL,
  `titre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `texte` text COLLATE utf8_unicode_ci NOT NULL,
  `serviceMessagerie` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idSource` int(11) NOT NULL,
  `idDestinataire` int(11) DEFAULT NULL,
  `statutSource` int(11) NOT NULL,
  `statutDestinataire` int(11) NOT NULL,
  `dateEnvoie` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `messagerie`
--

INSERT INTO `messagerie` (`idMessagerie`, `statut`, `titre`, `texte`, `serviceMessagerie`, `idSource`, `idDestinataire`, `statutSource`, `statutDestinataire`, `dateEnvoie`) VALUES
(1, 1, 'ss', 'dd', 'majordhome', 60, NULL, 2, -1, '2020-03-29 14:16:55'),
(2, 0, 'test', 'ddd', NULL, 58, 60, 0, 2, '2020-03-29 14:43:49'),
(3, 1, 'ok', 'ok', NULL, 58, 59, 0, 0, '2020-03-29 14:49:30'),
(4, 1, 'Re : test', 'D\'accord', 'majordhome', 60, NULL, 0, 1, '2020-03-29 16:40:47'),
(5, 1, 'Re : test', 'Salut', 'majordhome', 60, NULL, 0, 0, '2020-03-29 23:10:00'),
(6, 0, 'Test', 'Bonjour', 'majordhome', 59, NULL, 0, 0, '2020-04-03 12:43:06');

-- --------------------------------------------------------

--
-- Table structure for table `metier`
--

CREATE TABLE `metier` (
  `nom` varchar(50) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `FK_categorie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `metier`
--

INSERT INTO `metier` (`nom`, `description`, `FK_categorie`) VALUES
('biologiste', NULL, NULL),
('boulanger', NULL, 91),
('chimiste', NULL, NULL),
('couturière', NULL, NULL),
('cuisinier', NULL, 89),
('eleveur poulet', NULL, NULL),
('informaticien', NULL, NULL),
('jardinier', NULL, NULL),
('kinesitherapie', NULL, NULL),
('musicien', NULL, NULL),
('oenologue', NULL, NULL),
('pompier', NULL, NULL),
('restaurateur', NULL, NULL),
('sage femme', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personne`
--

CREATE TABLE `personne` (
  `idPersonne` int(11) NOT NULL,
  `idCode` varchar(11) DEFAULT NULL,
  `nom` varchar(80) NOT NULL,
  `prenom` varchar(80) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `dateNaissance` date NOT NULL,
  `telephone` char(10) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `codePostal` char(5) NOT NULL,
  `mdp` varchar(64) NOT NULL,
  `statut` int(11) NOT NULL,
  `FK_metier` varchar(50) DEFAULT NULL,
  `dateCreation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `personne`
--

INSERT INTO `personne` (`idPersonne`, `idCode`, `nom`, `prenom`, `mail`, `dateNaissance`, `telephone`, `adresse`, `ville`, `codePostal`, `mdp`, `statut`, `FK_metier`, `dateCreation`) VALUES
(58, NULL, 'Sigaud', 'Théo', 'theodoresigaud@gmail.com', '1999-10-23', '0655889977', 'fsvgsd', 'adygvf', '75016', 'f716879c16044c95ece01bf61a1799b392594c2c013f4207c875ffb1579b8526', 3, NULL, '2020-03-19 18:03:49'),
(59, NULL, 'Mich', 'Jean', 'jean@gmail.com', '1999-10-23', '0644223366', 'feuygez', 'uyzdtyu', '75016', 'f716879c16044c95ece01bf61a1799b392594c2c013f4207c875ffb1579b8526', 0, NULL, '2020-03-19 18:13:02'),
(60, NULL, 'Nassurally', 'Waseem', 'waseem11@hotmail.fr', '1999-04-11', '0761740282', '41 rue jean jacques rousseau', 'Drancy', '93700', '$2y$10$Ew5rBa6SuRKyUQHOhRiuNuOXvg0dLRRD//kIK8Nki3XagwY9lRWBK', 2, NULL, '2020-03-19 18:14:10'),
(61, NULL, 'uevbvb', 'ddygtu', 'toto@gmail.com', '1999-10-23', '0655885566', 'efhyiue', 'gdzyug', '75016', '$2y$10$aULyAz/6ywtItUKE9RZG4e/GNgsFFxamHVX5jITFGu13n/T76Oo8O', 1, 'boulanger', '2020-03-20 17:42:14'),
(62, NULL, 'Mich', 'Cuistot', 'fhezffz@gmail.com', '1999-10-23', '0655889966', 'ezfijzquçf', 'yzegfbyu', '75016', '$2y$10$PHabKA1VXLPBIf0a1zhd2Oc5K1.psb3UvIF1jiLUzGgNOXL4PtGe.', 1, 'cuisinier', '2020-04-02 13:54:42');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `idService` int(11) NOT NULL,
  `nom` varchar(80) NOT NULL,
  `description` text,
  `prix` float DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  `idCategorie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`idService`, `nom`, `description`, `prix`, `statut`, `idCategorie`) VALUES
(0, 'Demande', '', NULL, NULL, NULL),
(1, 'Plombier', 'Test', 4900, 0, 89),
(3, 'Plombier', '', 4900, 1, 89),
(7, 'Théo', '', 0.1, 0, 93);

-- --------------------------------------------------------

--
-- Table structure for table `souscription_abonnement`
--

CREATE TABLE `souscription_abonnement` (
  `idSouscriptionAbonnement` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `dateAchat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dateFin` datetime NOT NULL,
  `statut` int(11) NOT NULL,
  `FK_idPersonne` int(11) DEFAULT NULL,
  `FK_idAbonnement` int(11) DEFAULT NULL,
  `nombreServices` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `souscription_abonnement`
--

INSERT INTO `souscription_abonnement` (`idSouscriptionAbonnement`, `dateAchat`, `dateFin`, `statut`, `FK_idPersonne`, `FK_idAbonnement`, `nombreServices`) VALUES
('ooDvCaAAP9', '2020-05-02 12:16:02', '2020-04-19 15:56:18', 0, 59, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `souscription_service`
--

CREATE TABLE `souscription_service` (
  `idSouscriptionService` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `statutReservation` int(11) NOT NULL,
  `dateReservation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateIntervention` datetime DEFAULT NULL,
  `duree` time DEFAULT NULL,
  `FK_idPersonne` int(11) NOT NULL,
  `FK_idService` int(11) NOT NULL,
  `FK_idPrestataire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `souscription_service`
--

INSERT INTO `souscription_service` (`idSouscriptionService`, `statutReservation`, `dateReservation`, `dateIntervention`, `duree`, `FK_idPersonne`, `FK_idService`, `FK_idPrestataire`) VALUES
('7y4bkYJrSS', 0, '2020-04-20 09:39:21', '2021-10-23 10:00:00', '00:30:00', 59, 3, NULL),
('AEOA3QANsY', 0, '2020-04-19 18:13:20', '2021-10-23 10:30:00', '00:30:00', 59, 3, NULL),
('fTPGObecMD', 0, '2020-04-19 18:13:59', '2021-10-23 11:00:00', '00:30:00', 59, 3, 62),
('kucgHhi3gp', 0, '2020-05-02 13:23:34', '2020-05-21 00:00:00', NULL, 59, 0, NULL),
('SrrQkm7dkt', 0, '2020-05-02 13:36:58', '2021-10-23 00:00:00', NULL, 59, 0, NULL),
('uOsWoPGq4L', 0, '2020-04-19 18:12:36', '2021-10-23 11:30:00', '00:30:00', 59, 3, NULL),
('ZWPSGgxXnt', 0, '2020-04-19 18:13:51', '2021-10-23 12:00:00', '00:30:00', 59, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `nom` varchar(45) NOT NULL,
  `decription` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`nom`, `decription`) VALUES
('agriculture', NULL),
('agroalimentaire-alimentation', NULL),
('animaux', NULL),
('architecture-amenagement interieur', NULL),
('artisanat-metier d\'art', NULL),
('Autres secteurs', NULL),
('Banque-Finance-Assurance', NULL),
('Batiment- travaux publics ', NULL),
('Biologie-chimie', NULL),
('Commerce -immobilier', NULL),
('Communication - information', NULL),
('Culture-spectacle', NULL),
('Defense - securite - secours', NULL),
('Droit', NULL),
('Edition - imprimerie - livre', NULL),
('Enseignement - formation', NULL),
('Environnement - nature - nettoyage', NULL),
('Gestion - audit - ressources humaines', NULL),
('Hotellerie - restauration - tourisme', NULL),
('Humanitaire', NULL),
('Industrie - materiaux', NULL),
('Informatique - Electronique ', NULL),
('Lettre - sciences humaines', NULL),
('Mecanique - Maintenance', NULL),
('Numerique - Multimedia - Audiovisuel', NULL),
('Sante', NULL),
('Sciences - Maths - Physique', NULL),
('Secretariat - accueil', NULL),
('Social - Services a la personne', NULL),
('Soin - Esthetique - Coiffure', NULL),
('Sport - Animation', NULL),
('Transport - logistique', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `versement`
--

CREATE TABLE `versement` (
  `idVersement` int(11) NOT NULL,
  `somme` double NOT NULL,
  `FK_idFacture` int(11) NOT NULL,
  `statut` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `datePaiement` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `versement`
--

INSERT INTO `versement` (`idVersement`, `somme`, `FK_idFacture`, `statut`, `date`, `datePaiement`) VALUES
(96, 4900, 114, 1, '2020-04-19 18:12:36', '2020-04-19 18:12:36'),
(97, 4900, 115, 1, '2020-04-24 18:13:20', NULL),
(98, 4900, 116, 1, '2020-04-24 18:13:51', NULL),
(99, 4900, 117, 1, '2020-04-24 18:13:59', NULL),
(100, 0, 118, 0, '2020-04-25 09:39:21', NULL),
(101, 0, 118, 0, '2020-05-20 09:39:21', NULL),
(102, 0, 118, 0, '2020-06-20 09:39:21', NULL),
(103, 0, 118, 0, '2020-07-20 09:39:21', NULL),
(104, 1100, 119, 1, '2020-05-02 13:32:01', '2020-05-02 13:52:37'),
(105, 0, 120, 0, '2020-05-02 13:38:24', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abonnement`
--
ALTER TABLE `abonnement`
  ADD PRIMARY KEY (`idAbonnement`);

--
-- Indexes for table `caracteristique`
--
ALTER TABLE `caracteristique`
  ADD PRIMARY KEY (`idCaracteristique`),
  ADD KEY `idService` (`idService`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`idCategorie`);

--
-- Indexes for table `devis`
--
ALTER TABLE `devis`
  ADD PRIMARY KEY (`idDevis`),
  ADD KEY `FK_personne` (`FK_idPersonne`);

--
-- Indexes for table `donnees_service`
--
ALTER TABLE `donnees_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_idCaracteristique` (`FK_idCaracteristique`),
  ADD KEY `FK_idSouscriptionService` (`FK_idSouscriptionService`);

--
-- Indexes for table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`idFacture`),
  ADD KEY `FK_idPersonne` (`FK_idPersonne`),
  ADD KEY `FK_idSouscriptionService` (`FK_idSouscriptionService`),
  ADD KEY `FK_idSouscriptionAbonnement` (`FK_idSouscriptionAbonnement`);

--
-- Indexes for table `messagerie`
--
ALTER TABLE `messagerie`
  ADD PRIMARY KEY (`idMessagerie`),
  ADD KEY `FK_idDestinataire` (`idSource`),
  ADD KEY `FK_idSource` (`idDestinataire`);

--
-- Indexes for table `metier`
--
ALTER TABLE `metier`
  ADD PRIMARY KEY (`nom`),
  ADD KEY `FK_categorie` (`FK_categorie`);

--
-- Indexes for table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`idPersonne`),
  ADD KEY `FK_metier` (`FK_metier`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`idService`),
  ADD KEY `idCategorie` (`idCategorie`);

--
-- Indexes for table `souscription_abonnement`
--
ALTER TABLE `souscription_abonnement`
  ADD PRIMARY KEY (`idSouscriptionAbonnement`),
  ADD KEY `souscription_abonnement_ibfk_1` (`FK_idPersonne`),
  ADD KEY `FK_abonnement` (`FK_idAbonnement`);

--
-- Indexes for table `souscription_service`
--
ALTER TABLE `souscription_service`
  ADD PRIMARY KEY (`idSouscriptionService`),
  ADD KEY `FK_idPersonne` (`FK_idPersonne`),
  ADD KEY `FK_idService` (`FK_idService`),
  ADD KEY `FK_idPrestataire` (`FK_idPrestataire`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`nom`);

--
-- Indexes for table `versement`
--
ALTER TABLE `versement`
  ADD PRIMARY KEY (`idVersement`),
  ADD KEY `FK_idFacture` (`FK_idFacture`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abonnement`
--
ALTER TABLE `abonnement`
  MODIFY `idAbonnement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `caracteristique`
--
ALTER TABLE `caracteristique`
  MODIFY `idCaracteristique` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `idCategorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `devis`
--
ALTER TABLE `devis`
  MODIFY `idDevis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `donnees_service`
--
ALTER TABLE `donnees_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=424;

--
-- AUTO_INCREMENT for table `facture`
--
ALTER TABLE `facture`
  MODIFY `idFacture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `messagerie`
--
ALTER TABLE `messagerie`
  MODIFY `idMessagerie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personne`
--
ALTER TABLE `personne`
  MODIFY `idPersonne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `idService` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `versement`
--
ALTER TABLE `versement`
  MODIFY `idVersement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `caracteristique`
--
ALTER TABLE `caracteristique`
  ADD CONSTRAINT `caracteristique_ibfk_1` FOREIGN KEY (`idService`) REFERENCES `service` (`idService`);

--
-- Constraints for table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `devis_ibfk_1` FOREIGN KEY (`FK_idPersonne`) REFERENCES `personne` (`idPersonne`);

--
-- Constraints for table `donnees_service`
--
ALTER TABLE `donnees_service`
  ADD CONSTRAINT `donnees_service_ibfk_1` FOREIGN KEY (`FK_idCaracteristique`) REFERENCES `caracteristique` (`idCaracteristique`),
  ADD CONSTRAINT `donnees_service_ibfk_2` FOREIGN KEY (`FK_idSouscriptionService`) REFERENCES `souscription_service` (`idSouscriptionService`);

--
-- Constraints for table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`FK_idPersonne`) REFERENCES `personne` (`idPersonne`),
  ADD CONSTRAINT `facture_ibfk_2` FOREIGN KEY (`FK_idSouscriptionService`) REFERENCES `souscription_service` (`idSouscriptionService`),
  ADD CONSTRAINT `facture_ibfk_3` FOREIGN KEY (`FK_idSouscriptionAbonnement`) REFERENCES `souscription_abonnement` (`idSouscriptionAbonnement`);

--
-- Constraints for table `messagerie`
--
ALTER TABLE `messagerie`
  ADD CONSTRAINT `messagerie_ibfk_1` FOREIGN KEY (`idSource`) REFERENCES `personne` (`idPersonne`),
  ADD CONSTRAINT `messagerie_ibfk_2` FOREIGN KEY (`idDestinataire`) REFERENCES `personne` (`idPersonne`);

--
-- Constraints for table `metier`
--
ALTER TABLE `metier`
  ADD CONSTRAINT `metier_ibfk_1` FOREIGN KEY (`FK_categorie`) REFERENCES `categorie` (`idCategorie`);

--
-- Constraints for table `personne`
--
ALTER TABLE `personne`
  ADD CONSTRAINT `personne_ibfk_1` FOREIGN KEY (`FK_metier`) REFERENCES `metier` (`nom`);

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `service_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `souscription_abonnement`
--
ALTER TABLE `souscription_abonnement`
  ADD CONSTRAINT `souscription_abonnement_ibfk_1` FOREIGN KEY (`FK_idPersonne`) REFERENCES `personne` (`idPersonne`),
  ADD CONSTRAINT `souscription_abonnement_ibfk_2` FOREIGN KEY (`FK_idAbonnement`) REFERENCES `abonnement` (`idAbonnement`);

--
-- Constraints for table `souscription_service`
--
ALTER TABLE `souscription_service`
  ADD CONSTRAINT `souscription_service_ibfk_1` FOREIGN KEY (`FK_idPersonne`) REFERENCES `personne` (`idPersonne`),
  ADD CONSTRAINT `souscription_service_ibfk_2` FOREIGN KEY (`FK_idService`) REFERENCES `service` (`idService`),
  ADD CONSTRAINT `souscription_service_ibfk_3` FOREIGN KEY (`FK_idPrestataire`) REFERENCES `personne` (`idPersonne`);

--
-- Constraints for table `versement`
--
ALTER TABLE `versement`
  ADD CONSTRAINT `versement_ibfk_1` FOREIGN KEY (`FK_idFacture`) REFERENCES `facture` (`idFacture`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
