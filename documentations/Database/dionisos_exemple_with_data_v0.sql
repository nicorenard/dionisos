-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 14 jan. 2022 à 15:56
-- Version du serveur :  10.4.22-MariaDB
-- Version de PHP : 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dionisos`
--

-- --------------------------------------------------------

--
-- Structure de la table `colonne`
--

DROP TABLE IF EXISTS `colonne`;
CREATE TABLE IF NOT EXISTS `colonne` (
  `id_colonne` int(11) NOT NULL AUTO_INCREMENT,
  `id_machine` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `numero_de_serie` varchar(30) NOT NULL,
  `mise_en_service` date NOT NULL,
  `volume_max` decimal(7,2) NOT NULL,
  `volume_col_encours` decimal(7,2) DEFAULT NULL,
  PRIMARY KEY (`id_colonne`),
  KEY `colonne_ibfk_1` (`id_machine`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `colonne`
--

INSERT INTO `colonne` (`id_colonne`, `id_machine`, `nom`, `numero_de_serie`, `mise_en_service`, `volume_max`, `volume_col_encours`) VALUES
(1, 1, 'SPS_col_acetone', '12201-1', '2022-01-01', '50000.00', '12000.00'),
(2, 1, 'SPS_col_dcm', '12205-2', '2022-01-01', '50000.00', '32000.00'),
(3, 1, 'SPS_col_ether', '12222-5', '2022-01-05', '50000.00', '15000.00'),
(4, 1, 'SPS_col_THF', '152-22', '2022-01-02', '50000.00', '0.00'),
(5, 1, 'SPS_col_acetonitrile', '162-12', '2022-01-02', '50000.00', '0.00');

-- --------------------------------------------------------

--
-- Structure de la table `container`
--

DROP TABLE IF EXISTS `container`;
CREATE TABLE IF NOT EXISTS `container` (
  `id_container` int(11) NOT NULL AUTO_INCREMENT,
  `id_machine` int(11) NOT NULL,
  `numero_de_serie` varchar(30) NOT NULL,
  `taille` int(11) NOT NULL,
  `date_remplissage` date NOT NULL,
  `volume_cont_encours` decimal(7,2) DEFAULT NULL,
  PRIMARY KEY (`id_container`),
  KEY `container_ibfk_1` (`id_machine`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `container`
--

INSERT INTO `container` (`id_container`, `id_machine`, `numero_de_serie`, `taille`, `date_remplissage`, `volume_cont_encours`) VALUES
(1, 1, '123-552', 25000, '2022-01-03', '15000.00'),
(2, 1, '123-553', 10000, '2022-01-02', '8000.00'),
(3, 1, '123-555', 25000, '2022-01-04', '800.00');

-- --------------------------------------------------------

--
-- Structure de la table `date_prelevement`
--

DROP TABLE IF EXISTS `date_prelevement`;
CREATE TABLE IF NOT EXISTS `date_prelevement` (
  `id_DatePrelevement` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) NOT NULL,
  `id_solvant` int(11) NOT NULL,
  `date_heure` date NOT NULL,
  `volume` decimal(7,2) DEFAULT NULL,
  PRIMARY KEY (`id_DatePrelevement`),
  KEY `date_prelevement_ibfk_1` (`id_utilisateur`),
  KEY `date_prelevement_ibfk_2` (`id_solvant`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `date_prelevement`
--

INSERT INTO `date_prelevement` (`id_DatePrelevement`, `id_utilisateur`, `id_solvant`, `date_heure`, `volume`) VALUES
(1, 3, 1, '2022-01-03', '150.00'),
(2, 2, 2, '2022-01-02', '260.00'),
(3, 5, 1, '2022-01-04', '542.00'),
(4, 10, 1, '2022-01-03', '240.00'),
(5, 9, 2, '2022-01-03', '1000.00'),
(6, 4, 3, '2022-01-05', '300.00'),
(7, 7, 3, '2022-01-05', '800.00'),
(8, 9, 3, '2022-01-09', '150.00'),
(9, 6, 2, '2022-01-09', '250.00'),
(10, 3, 1, '2022-01-09', '300.00');

-- --------------------------------------------------------

--
-- Structure de la table `machine`
--

DROP TABLE IF EXISTS `machine`;
CREATE TABLE IF NOT EXISTS `machine` (
  `id_machine` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `numero_serie` varchar(10) NOT NULL,
  `nombre_colonne_max` int(11) NOT NULL,
  `nombre_colonne_inactive` int(11) DEFAULT NULL,
  `nombre_colonnes_active` int(11) DEFAULT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id_machine`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `machine`
--

INSERT INTO `machine` (`id_machine`, `nom`, `numero_serie`, `nombre_colonne_max`, `nombre_colonne_inactive`, `nombre_colonnes_active`, `id_utilisateur`) VALUES
(1, 'SPS 1', '20202001-1', 5, 2, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `responsable`
--

DROP TABLE IF EXISTS `responsable`;
CREATE TABLE IF NOT EXISTS `responsable` (
  `id_utilisateur` int(11) NOT NULL,
  `role_admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `responsable`
--

INSERT INTO `responsable` (`id_utilisateur`, `role_admin`) VALUES
(1, 1),
(7, 0),
(8, 1),
(9, 0);

-- --------------------------------------------------------

--
-- Structure de la table `solvant`
--

DROP TABLE IF EXISTS `solvant`;
CREATE TABLE IF NOT EXISTS `solvant` (
  `id_solvant` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `fabriquant` varchar(50) NOT NULL,
  `purete` decimal(5,2) NOT NULL,
  `id_container` int(11) NOT NULL,
  `id_colonne` int(11) NOT NULL,
  PRIMARY KEY (`id_solvant`),
  UNIQUE KEY `id_container` (`id_container`),
  UNIQUE KEY `id_colonne` (`id_colonne`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `solvant`
--

INSERT INTO `solvant` (`id_solvant`, `nom`, `fabriquant`, `purete`, `id_container`, `id_colonne`) VALUES
(1, 'Acetone', 'Carlo Erba', '98.00', 1, 1),
(2, 'Dichloromethane', 'Carlo Erba', '85.00', 2, 2),
(3, 'Ether', 'Sigma', '90.00', 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `equipe` varchar(50) NOT NULL,
  `date_creation` date NOT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `prenom`, `equipe`, `date_creation`) VALUES
(1, 'ELIOS', 'Jean', 'CICAL', '2022-01-03'),
(2, 'ETHAN', 'Nicolas', 'CIRCOS', '2022-01-03'),
(3, 'ELTA', 'Marie', 'CICAL', '2022-01-03'),
(4, 'MEMET', 'Eric', 'CIRRCE', '2022-01-03'),
(5, 'GERY', 'Nathan', 'LICI', '2022-01-03'),
(6, 'GERY', 'Nathanael', 'LICI', '2022-01-02'),
(7, 'AMIDA', 'Raja', 'LICI', '2022-01-03'),
(8, 'LEBRETON', 'Baptiste', 'MASOE', '2022-01-05'),
(9, 'KERMARREC', 'Bernard', 'MASOE', '2022-01-03'),
(10, 'PETIT', 'Marie', 'EXTERNE', '2022-01-03'),
(11, 'LEGRAND', 'Vanessa', 'EXTERNE', '2022-01-07');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `colonne`
--
ALTER TABLE `colonne`
  ADD CONSTRAINT `colonne_ibfk_1` FOREIGN KEY (`id_machine`) REFERENCES `machine` (`id_machine`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `container`
--
ALTER TABLE `container`
  ADD CONSTRAINT `container_ibfk_1` FOREIGN KEY (`id_machine`) REFERENCES `machine` (`id_machine`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `date_prelevement`
--
ALTER TABLE `date_prelevement`
  ADD CONSTRAINT `date_prelevement_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `date_prelevement_ibfk_2` FOREIGN KEY (`id_solvant`) REFERENCES `solvant` (`id_solvant`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `machine`
--
ALTER TABLE `machine`
  ADD CONSTRAINT `machine_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `responsable` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `responsable`
--
ALTER TABLE `responsable`
  ADD CONSTRAINT `responsable_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `solvant`
--
ALTER TABLE `solvant`
  ADD CONSTRAINT `solvant_ibfk_1` FOREIGN KEY (`id_container`) REFERENCES `container` (`id_container`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solvant_ibfk_2` FOREIGN KEY (`id_colonne`) REFERENCES `colonne` (`id_colonne`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
