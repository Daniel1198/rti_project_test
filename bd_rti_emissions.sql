-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 28 fév. 2022 à 14:43
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bd_rti_emissions`
--

-- --------------------------------------------------------

--
-- Structure de la table `emissions`
--

DROP TABLE IF EXISTS `emissions`;
CREATE TABLE IF NOT EXISTS `emissions` (
  `idEmi` int(11) NOT NULL,
  `libEmi` varchar(15) DEFAULT NULL,
  `prEm` varchar(70) DEFAULT NULL,
  `reaEmi` varchar(70) DEFAULT NULL,
  `thEmi` varchar(50) DEFAULT NULL,
  `durEmi` varchar(11) DEFAULT NULL,
  `datRdEmi` varchar(50) DEFAULT NULL,
  `difEmi` varchar(50) DEFAULT NULL,
  `datEmi` date NOT NULL,
  PRIMARY KEY (`idEmi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `inviter`
--

DROP TABLE IF EXISTS `inviter`;
CREATE TABLE IF NOT EXISTS `inviter` (
  `idEmi` int(11) NOT NULL,
  `idInv` int(11) NOT NULL,
  PRIMARY KEY (`idEmi`,`idInv`),
  KEY `idInv` (`idInv`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `invites`
--

DROP TABLE IF EXISTS `invites`;
CREATE TABLE IF NOT EXISTS `invites` (
  `idInv` int(11) NOT NULL,
  `nomInv` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idInv`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
