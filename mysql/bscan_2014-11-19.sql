# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.20)
# Database: bscan
# Generation Time: 2014-11-19 16:55:24 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Chef
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Chef`;

CREATE TABLE `Chef` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_nom` varchar(30) DEFAULT NULL,
  `c_prenom` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Chef` WRITE;
/*!40000 ALTER TABLE `Chef` DISABLE KEYS */;

INSERT INTO `Chef` (`c_id`, `c_nom`, `c_prenom`)
VALUES
	(1,'Yasser','Samir');

/*!40000 ALTER TABLE `Chef` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Infos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Infos`;

CREATE TABLE `Infos` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_jour` date DEFAULT NULL,
  `heure_debut` datetime DEFAULT NULL,
  `heure_fin` datetime DEFAULT NULL,
  `u_id` int(4) DEFAULT NULL,
  `ouvrier_o_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`i_id`),
  KEY `FK_Infos_u_id` (`u_id`),
  KEY `FK_Infos_ouvrier_o_id` (`ouvrier_o_id`),
  CONSTRAINT `FK_Infos_ouvrier_o_id` FOREIGN KEY (`ouvrier_o_id`) REFERENCES `ouvrier` (`o_id`),
  CONSTRAINT `FK_Infos_u_id` FOREIGN KEY (`u_id`) REFERENCES `utilisateur` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table Ouvrier
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Ouvrier`;

CREATE TABLE `Ouvrier` (
  `o_id` int(11) NOT NULL AUTO_INCREMENT,
  `o_nom` varchar(30) DEFAULT NULL,
  `o_prenom` varchar(30) DEFAULT NULL,
  `qrcode` varchar(255) DEFAULT NULL,
  `c_id` int(11) NOT NULL,
  PRIMARY KEY (`o_id`),
  KEY `FK_Ouvrier_c_id` (`c_id`),
  CONSTRAINT `FK_Ouvrier_c_id` FOREIGN KEY (`c_id`) REFERENCES `chef` (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Ouvrier` WRITE;
/*!40000 ALTER TABLE `Ouvrier` DISABLE KEYS */;

INSERT INTO `Ouvrier` (`o_id`, `o_nom`, `o_prenom`, `qrcode`, `c_id`)
VALUES
	(1,'Ahmed','Ali','er454545',1),
	(3,'Cert','Anwar','3673937',1);

/*!40000 ALTER TABLE `Ouvrier` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Utilisateur
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Utilisateur`;

CREATE TABLE `Utilisateur` (
  `u_id` int(4) NOT NULL AUTO_INCREMENT,
  `u_nom` varchar(30) DEFAULT NULL,
  `u_prenom` varchar(30) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `u_password` varchar(60) DEFAULT NULL,
  `u_validation` int(11) DEFAULT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Utilisateur` WRITE;
/*!40000 ALTER TABLE `Utilisateur` DISABLE KEYS */;

INSERT INTO `Utilisateur` (`u_id`, `u_nom`, `u_prenom`, `username`, `u_password`, `u_validation`)
VALUES
	(1,'test','testing','test','000000',1);

/*!40000 ALTER TABLE `Utilisateur` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
