-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 20 juin 2020 à 15:14
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `assurance`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `idCmt` int(11) NOT NULL,
  `idClt` int(11) NOT NULL,
  `idOfr` int(11) NOT NULL,
  `cmt` text NOT NULL,
  `activate` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`idCmt`, `idClt`, `idOfr`, `cmt`, `activate`) VALUES
(3, 19, 3, 'test comment 2', 1),
(5, 30, 6, 'nklbnklbklbn', 0);

-- --------------------------------------------------------

--
-- Structure de la table `form`
--

CREATE TABLE `form` (
  `idFrm` int(11) NOT NULL,
  `idAsr` int(11) NOT NULL,
  `idClt` int(11) NOT NULL,
  `idRes` int(11) NOT NULL,
  `debut` date NOT NULL,
  `fin` date NOT NULL,
  `paye` float NOT NULL,
  `reste` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `form`
--

INSERT INTO `form` (`idFrm`, `idAsr`, `idClt`, `idRes`, `debut`, `fin`, `paye`, `reste`) VALUES
(13, 2, 19, 8, '0000-00-00', '0000-00-00', 1700, 100),
(14, 4, 19, 8, '0000-00-00', '0000-00-00', 1000, 100),
(15, 2, 30, 1, '0000-00-00', '0000-00-00', 1200, 80);

-- --------------------------------------------------------

--
-- Structure de la table `formlog`
--

CREATE TABLE `formlog` (
  `idL` int(11) NOT NULL,
  `idF` int(11) NOT NULL,
  `nature` varchar(50) NOT NULL,
  `etages` int(11) NOT NULL,
  `surrface` int(11) NOT NULL,
  `pieces` int(11) NOT NULL,
  `annexe` varchar(50) NOT NULL,
  `securite` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `formloi`
--

CREATE TABLE `formloi` (
  `idLoi` int(11) NOT NULL,
  `idF` int(11) NOT NULL,
  `activite` varchar(50) NOT NULL,
  `club` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `formloi`
--

INSERT INTO `formloi` (`idLoi`, `idF`, `activite`, `club`) VALUES
(2, 13, 'Saut parachute', 'FAR');

-- --------------------------------------------------------

--
-- Structure de la table `forms`
--

CREATE TABLE `forms` (
  `idS` int(11) NOT NULL,
  `idF` int(11) NOT NULL,
  `RIB` varchar(50) NOT NULL,
  `caisse` varchar(50) NOT NULL,
  `naissance` date NOT NULL,
  `nss` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `formv`
--

CREATE TABLE `formv` (
  `idV` int(11) NOT NULL,
  `idF` int(11) NOT NULL,
  `categorie` varchar(50) NOT NULL,
  `usage` varchar(50) NOT NULL,
  `km` int(11) NOT NULL,
  `marque` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `annee` int(11) NOT NULL,
  `matricule` varchar(50) NOT NULL,
  `permis` varchar(50) NOT NULL,
  `vitesse` int(11) NOT NULL,
  `cheveaux` int(11) NOT NULL,
  `Carbirant` varchar(40) NOT NULL,
  `carteGris` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `formv`
--

INSERT INTO `formv` (`idV`, `idF`, `categorie`, `usage`, `km`, `marque`, `model`, `annee`, `matricule`, `permis`, `vitesse`, `cheveaux`, `Carbirant`, `carteGris`) VALUES
(2, 13, 'Auto', 'Profesionnel', 500, 'Mercedes', 'E-350', 2015, '6500A1', 'A12345', 6, 50, 'Diesel', 'A12345'),
(3, 15, 'Auto', 'Personnel', 240000, 'Volkswagen', 'Passat ', 2010, '6500A1', 'A12345', 6, 30, 'diesel', 'A12345');

-- --------------------------------------------------------

--
-- Structure de la table `insurance`
--

CREATE TABLE `insurance` (
  `idAsr` int(11) NOT NULL,
  `Nom` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Image` varchar(150) CHARACTER SET utf8 NOT NULL,
  `Description` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `insurance`
--

INSERT INTO `insurance` (`idAsr`, `Nom`, `Image`, `Description`) VALUES
(1, 'Home', 'assur-logement.jpg', 'Do you own or rent? Discover our home insurance and protect your home, according to your needs and your budget.'),
(2, 'Vechil', 'assur-auto.png', 'Insurance which guarantees you full cover in the event of a claim, while respecting your budget.'),
(3, 'Helath', 'assur-santé.png', 'Your health capital and that of your family are precious and deserve the best international medical plan.'),
(4, 'Hobbies', 'assur-loisir.jpg', 'The purpose of our insurance is to guarantee policyholders lifetime coverage for expenses incurred following hospitalization following an illness or accident. With Health Plus coverage, you and your loved ones are supported in the event of hospitalization in Morocco or abroad.\r\n\r\nWith the Liability guarantee, exercise your hobby in peace. The guarantee covers the financial consequences of all damage caused in the exercise of your leisure and engaging your responsibility.\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `offer`
--

CREATE TABLE `offer` (
  `idOfr` int(11) NOT NULL,
  `idAsr` int(11) NOT NULL,
  `description` text NOT NULL,
  `tarif` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `offer`
--

INSERT INTO `offer` (`idOfr`, `idAsr`, `description`, `tarif`) VALUES
(1, 2, 'Tous risque', 1700),
(3, 4, 'Chasse', 1500),
(4, 1, 'Vol', 1200),
(5, 3, 'Corona', 1500),
(6, 2, 'Vol', 1000),
(7, 2, ' n', 1500),
(8, 4, 'Dive', 700),
(12, 4, 'ARM', 2020),
(18, 3, 'BIP', 2016),
(20, 3, 'BIP', 2016),
(21, 4, 'ARM', 2020),
(22, 3, 'DEV', 20000);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `Nom` varchar(25) NOT NULL,
  `Prenom` varchar(25) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Tel` varchar(10) DEFAULT NULL,
  `Adresse` text NOT NULL,
  `Password` varchar(25) NOT NULL,
  `Avatar` varchar(50) NOT NULL,
  `GroupID` int(1) NOT NULL DEFAULT 0,
  `Activate` int(1) NOT NULL DEFAULT 0,
  `Added` date NOT NULL,
  `Updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `Nom`, `Prenom`, `Email`, `Tel`, `Adresse`, `Password`, `Avatar`, `GroupID`, `Activate`, `Added`, `Updated`) VALUES
(1, 'Aarchi', 'Ayoub', 'ayoubaa084@gmail.com', '0609019455', 'Hay Salam Bloc 22 N°670 SALE-11000', '12415212', 'Aarchi-Ayoub-2_download.png', 1, 1, '2020-05-27', '2020-05-29'),
(8, 'Boujnane', 'Zineb', 'boujnanezineb@gmail.com', '0600000001', 'Petit prince salé', '2014/2015', 'Boujnane-Zineb-259277_192105.jpg', 2, 1, '2020-05-29', '2020-05-30'),
(18, 'Boujir', 'Tarik', 'ta.rik@bjr.com', '0600000011', 'Meknes', 'Boujir@Tarik', '', 0, 1, '2020-06-03', '0000-00-00'),
(19, 'Aarchi', 'Jamal', 'jamalaar@gmail.com', '0661606179', '1 ere BIP Maamoura SALE', 'Aarchi@Jamal', '', 0, 1, '2020-06-03', '0000-00-00'),
(28, 'Boujir', 'Anass', 'anas@bjr.com', NULL, '', 'rbt_mkns', '', 0, 0, '2020-06-16', '2020-06-16'),
(29, 'Boujir', 'Salma', 'slm@bjr.fr', NULL, '', 'EMI', '', 0, 0, '2020-06-16', '2020-06-16'),
(30, 'Boujir', 'Ibrahim', 'ibr@bjr.com', '0600000111', 'Kenitra', 'kenitra', 'Boujir-Ibrahim-352957_profil-linkedin-300x300.jpg', 0, 0, '2020-06-16', '2020-06-16'),
(31, 'Khaidar', 'Chaimaa', 'khaidar.ch@gmail.com', '0101100100', 'CasaBlanca', 'Khaidar@Chaimaa', '', 0, 1, '2020-06-20', '0000-00-00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`idCmt`),
  ADD KEY `idClt` (`idClt`),
  ADD KEY `idOfr` (`idOfr`);

--
-- Index pour la table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`idFrm`),
  ADD KEY `fk_clt` (`idClt`),
  ADD KEY `fk_res` (`idRes`),
  ADD KEY `fk_asr` (`idAsr`);

--
-- Index pour la table `formlog`
--
ALTER TABLE `formlog`
  ADD PRIMARY KEY (`idL`),
  ADD KEY `formlog_ibfk_1` (`idF`);

--
-- Index pour la table `formloi`
--
ALTER TABLE `formloi`
  ADD PRIMARY KEY (`idLoi`),
  ADD KEY `formloi_ibfk_1` (`idF`);

--
-- Index pour la table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`idS`),
  ADD KEY `forms_ibfk_1` (`idF`);

--
-- Index pour la table `formv`
--
ALTER TABLE `formv`
  ADD PRIMARY KEY (`idV`),
  ADD KEY `formv_ibfk_1` (`idF`);

--
-- Index pour la table `insurance`
--
ALTER TABLE `insurance`
  ADD PRIMARY KEY (`idAsr`);

--
-- Index pour la table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`idOfr`),
  ADD KEY `fk_ins` (`idAsr`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `u_email` (`Email`),
  ADD UNIQUE KEY `u_tel` (`Tel`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `idCmt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `form`
--
ALTER TABLE `form`
  MODIFY `idFrm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `formlog`
--
ALTER TABLE `formlog`
  MODIFY `idL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `formloi`
--
ALTER TABLE `formloi`
  MODIFY `idLoi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `forms`
--
ALTER TABLE `forms`
  MODIFY `idS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `formv`
--
ALTER TABLE `formv`
  MODIFY `idV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `insurance`
--
ALTER TABLE `insurance`
  MODIFY `idAsr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `offer`
--
ALTER TABLE `offer`
  MODIFY `idOfr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`idClt`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`idOfr`) REFERENCES `offer` (`idOfr`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `form`
--
ALTER TABLE `form`
  ADD CONSTRAINT `fk_asr` FOREIGN KEY (`idAsr`) REFERENCES `insurance` (`idAsr`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_clt` FOREIGN KEY (`idClt`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_res` FOREIGN KEY (`idRes`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `formlog`
--
ALTER TABLE `formlog`
  ADD CONSTRAINT `formlog_ibfk_1` FOREIGN KEY (`idF`) REFERENCES `form` (`idFrm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `formloi`
--
ALTER TABLE `formloi`
  ADD CONSTRAINT `formloi_ibfk_1` FOREIGN KEY (`idF`) REFERENCES `form` (`idFrm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`idF`) REFERENCES `form` (`idFrm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `formv`
--
ALTER TABLE `formv`
  ADD CONSTRAINT `formv_ibfk_1` FOREIGN KEY (`idF`) REFERENCES `form` (`idFrm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `offer`
--
ALTER TABLE `offer`
  ADD CONSTRAINT `fk_ins` FOREIGN KEY (`idAsr`) REFERENCES `insurance` (`idAsr`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
