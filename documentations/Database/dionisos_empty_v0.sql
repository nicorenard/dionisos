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

-
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
-- Structure de la table `responsable`
--

DROP TABLE IF EXISTS `responsable`;
CREATE TABLE IF NOT EXISTS `responsable` (
  `id_utilisateur` int(11) NOT NULL,
  `role_admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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
