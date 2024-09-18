-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: affichage
-- ------------------------------------------------------
-- Server version	8.0.37-cluster

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Informations`
--

DROP TABLE IF EXISTS `Informations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Informations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `infos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `duration_seconds` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Informations`
--

LOCK TABLES `Informations` WRITE;
/*!40000 ALTER TABLE `Informations` DISABLE KEYS */;
/*!40000 ALTER TABLE `Informations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Permissions`
--

DROP TABLE IF EXISTS `Permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `page` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Permissions`
--

LOCK TABLES `Permissions` WRITE;
/*!40000 ALTER TABLE `Permissions` DISABLE KEYS */;
INSERT INTO `Permissions` VALUES (1,'list.php',NULL),(2,'configMenu.php',NULL),(3,'groupe.php',NULL);
/*!40000 ALTER TABLE `Permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Roles`
--

DROP TABLE IF EXISTS `Roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Roles`
--

LOCK TABLES `Roles` WRITE;
/*!40000 ALTER TABLE `Roles` DISABLE KEYS */;
INSERT INTO `Roles` VALUES (1,'modérateur limité','responsable des hôtes spécifiques'),(2,'modérateur','Utilisateur principal qui peut gérer plusieurs sites et hôtes'),(3,'administrateur','Administrateur du site');
/*!40000 ALTER TABLE `Roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Roles_Permissions`
--

DROP TABLE IF EXISTS `Roles_Permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Roles_Permissions` (
  `id_role` int NOT NULL,
  `id_permission` int NOT NULL,
  PRIMARY KEY (`id_role`,`id_permission`),
  KEY `id_permission` (`id_permission`),
  CONSTRAINT `Roles_Permissions_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `Roles` (`id`),
  CONSTRAINT `Roles_Permissions_ibfk_2` FOREIGN KEY (`id_permission`) REFERENCES `Permissions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Roles_Permissions`
--

LOCK TABLES `Roles_Permissions` WRITE;
/*!40000 ALTER TABLE `Roles_Permissions` DISABLE KEYS */;
INSERT INTO `Roles_Permissions` VALUES (3,1),(2,2),(3,2),(2,3),(3,3);
/*!40000 ALTER TABLE `Roles_Permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Utilisateurs`
--

DROP TABLE IF EXISTS `Utilisateurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` varchar(50) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_derniere_connexion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom_utilisateur` (`nom_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Utilisateurs`
--

LOCK TABLES `Utilisateurs` WRITE;
/*!40000 ALTER TABLE `Utilisateurs` DISABLE KEYS */;
INSERT INTO `Utilisateurs` VALUES (2,'asophie','$2y$10$EDBdu6e5wlRdkH3dv/8mXuT3Bi7XyYT2XkeY9jwMIwZRlN7h59vKO','asophie@p.com','2024-04-05 11:56:16','2024-05-06 09:27:27'),(3,'asaudubray','$2y$10$bfCSs2exHpsakFFavdvxtOhItEXZN2qP3S3UqrQFEO1KLTcbO1TXm','contact@lpjw.fr','2024-05-06 09:29:45','2024-09-17 07:44:47'),(4,'bdiop','$2y$10$dSMnoUcYa1xteexqCHHcDuZJNaMhn3OtA.uHXeKl/dnnryT.Ricge','techinfo@lpjw.fr','2024-08-28 08:08:04','2024-09-18 07:34:47');
/*!40000 ALTER TABLE `Utilisateurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Utilisateurs_Roles`
--

DROP TABLE IF EXISTS `Utilisateurs_Roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Utilisateurs_Roles` (
  `id_utilisateur` int NOT NULL,
  `id_role` int NOT NULL,
  PRIMARY KEY (`id_utilisateur`,`id_role`),
  KEY `id_role` (`id_role`),
  CONSTRAINT `Utilisateurs_Roles_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `Utilisateurs` (`id`),
  CONSTRAINT `Utilisateurs_Roles_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `Roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Utilisateurs_Roles`
--

LOCK TABLES `Utilisateurs_Roles` WRITE;
/*!40000 ALTER TABLE `Utilisateurs_Roles` DISABLE KEYS */;
INSERT INTO `Utilisateurs_Roles` VALUES (3,2),(4,3);
/*!40000 ALTER TABLE `Utilisateurs_Roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `absence`
--

DROP TABLE IF EXISTS `absence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `absence` (
  `id_absence` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prenom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `motif` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `debut_absence` date DEFAULT NULL,
  `fin_absence` date DEFAULT NULL,
  `commentaire` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_absence`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `absence`
--

LOCK TABLES `absence` WRITE;
/*!40000 ALTER TABLE `absence` DISABLE KEYS */;
INSERT INTO `absence` VALUES (1,'DAUVE','Marie','Maladie','2024-05-06','2024-05-06',''),(2,'SERAFINO','Giovanni','Maladie','2024-05-06','2024-05-06',''),(3,'RISSOULI','Evelyne','Maladie','2024-05-06','2024-05-12',''),(4,'BODINEAU','Christine','Maladie','2024-05-06','2024-05-12',''),(5,'PAU CRUARD','Marie-France','Maladie','2024-05-06','2024-05-17',''),(6,'BILBAUT','Corinne','Maladie','2024-05-06','2024-06-28',''),(9,'GODET','Philippe','Maladie','2024-05-13','2024-05-13',''),(10,'BODINEAU','Christine','Maladie','2024-05-13','2024-05-31',''),(11,'LANGLET','Lory','Maladie','2024-05-15','2024-05-15',''),(12,'LANGLET','Lory','Maladie','2024-05-14','2024-05-22',''),(13,'DELOUCHE','Amandine','Maladie','2024-05-17','2024-05-17',''),(14,'BESSON','Nathalie','Maladie','2024-05-17','2024-05-17',''),(15,'PAU CRUARD','Marie-France','Maladie','2024-05-17','2024-11-05',''),(16,'BESSON','Nathalie','Maladie','2024-05-22','2024-05-31',''),(17,'MOALIC','Maria','Maladie','2024-05-23','2024-05-23',''),(18,'LANGLET','Lory','Maladie','2024-05-23','2024-05-24',''),(21,'TANGUY','Patrick','Maladie','2024-05-29','2024-05-29',''),(20,'DOUET','Stéphanie','Maladie','2024-05-27','2024-05-27',''),(22,'FORTIN','Anne','Maladie','2024-05-29','2024-05-29',''),(23,'FORTIN ','Sophie','Maladie','2024-05-30','2024-05-30',''),(24,'DAUVE','Marie','Maladie','2024-05-30','2024-05-30',''),(25,'TANGUY','Patrick','Maladie','2024-05-30','2024-05-30',''),(26,'FERNANDEZ','Laura','Enfant malade','2024-05-31','2024-05-31',''),(27,'GRAINDORGE','Catherine','Maladie','2024-06-03','2024-06-04',''),(28,'CESBRON ','Corinne','Maladie','2024-06-05','2024-06-05',''),(29,'BROCHU','Delphine','Maladie','2024-08-30','2024-09-29',''),(30,'ARCELIN','Sophie','Maladie','2024-08-28','2024-10-18',''),(31,'DAUVE','Marie','Maladie','2024-09-02','2024-09-12',''),(32,'JEANNEAU','Benoit','Enfant malade','2024-09-06','2024-09-06',''),(33,'DAUVE','Marie','Maladie','2024-09-02','2024-09-22',''),(34,'PAWLIK CAPUS','Bernardyna','Maladie','2024-09-16','2024-09-16',''),(37,'BRUNES','Ludivine','Maladie','2024-09-16','2024-09-17',''),(36,'MARTIN ','Pascal','Maladie','2024-09-16','2024-09-16',''),(38,'MARTIN','Pascal','Maladie','2024-09-16','2024-09-20','');
/*!40000 ALTER TABLE `absence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acces_internet`
--

DROP TABLE IF EXISTS `acces_internet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acces_internet` (
  `SITE` varchar(20) DEFAULT NULL,
  `ETAT` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acces_internet`
--

LOCK TABLES `acces_internet` WRITE;
/*!40000 ALTER TABLE `acces_internet` DISABLE KEYS */;
INSERT INTO `acces_internet` VALUES ('LYCEE',1),('CAMPUS',1);
/*!40000 ALTER TABLE `acces_internet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agenda`
--

DROP TABLE IF EXISTS `agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agenda` (
  `id` int NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `agendaType` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda`
--

LOCK TABLES `agenda` WRITE;
/*!40000 ALTER TABLE `agenda` DISABLE KEYS */;
INSERT INTO `agenda` VALUES (2,'https://outlook.office365.com/owa/calendar/5a55001c8c8e4e3289503e89d90cd276@lpjw.fr/038ca2a4d7dd49468ce5603042a881516392841034771113203/calendar.ics','Outlook');
/*!40000 ALTER TABLE `agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conf_raspberry`
--

DROP TABLE IF EXISTS `conf_raspberry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `conf_raspberry` (
  `id` int NOT NULL AUTO_INCREMENT,
  `raspberry_count` int DEFAULT NULL,
  `group_count` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conf_raspberry`
--

LOCK TABLES `conf_raspberry` WRITE;
/*!40000 ALTER TABLE `conf_raspberry` DISABLE KEYS */;
INSERT INTO `conf_raspberry` VALUES (1,5,2);
/*!40000 ALTER TABLE `conf_raspberry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuration`
--

DROP TABLE IF EXISTS `configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuration` (
  `Conf_id` int NOT NULL AUTO_INCREMENT,
  `Conf_date` datetime DEFAULT NULL,
  `Conf_sites` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`Conf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuration`
--

LOCK TABLES `configuration` WRITE;
/*!40000 ALTER TABLE `configuration` DISABLE KEYS */;
INSERT INTO `configuration` VALUES (1,'2022-10-20 00:00:00','http://10.49.11.146/vuetache.php'),(2,'2022-10-23 00:00:00','dfghjkl'),(4,'2022-10-21 00:00:00','dfghjklpojhgfjhg oiuytgfd'),(5,'2022-10-21 00:00:00','http://lpjw.fr'),(6,'2022-10-23 00:00:00','http://lpjw.fr http://lpjw.fr'),(7,'2022-10-21 00:00:00','http://moncode.fr'),(8,'2022-10-21 00:00:00','http://lpjw.fr'),(9,'2022-10-21 00:00:00','http://lpjw.fr'),(17,'2022-10-21 00:00:00','http://moncode.fr'),(18,'2022-10-21 00:00:00','http://lpjw.fr'),(19,'2022-10-25 00:00:00','dfghjkl'),(20,'2022-10-11 00:00:00','http://lpjw.fr'),(21,'2022-09-28 00:00:00','http://moncode.fr'),(22,'2022-10-12 00:00:00','http://lpjw.fr http://lpjw.fr'),(23,'2022-10-26 00:00:00','http://moncode.fr'),(24,'2022-10-01 00:00:00','dfghjklpojhgfjhg oiuytgfd'),(25,'2022-10-19 00:00:00','http://moncode.fr'),(26,'2022-10-04 00:00:00',''),(27,'2022-10-06 00:00:00',''),(28,'2022-09-30 00:00:00',''),(29,'2022-09-30 00:00:00','http://lpjw.fr'),(30,'2022-10-08 00:00:00','dfghjkl'),(31,'2022-10-02 00:00:00','dfghjkl'),(32,'2022-09-27 00:00:00','http://moncode.fr'),(33,'2022-09-27 00:00:00','http://moncode.fr'),(34,'2027-10-22 00:00:00','http://moncode.fr'),(35,'2027-10-22 00:00:00','http://moncode.fr'),(36,'2027-10-22 00:00:00','http://lpjw.fr'),(37,NULL,'http://moncode.fr'),(38,NULL,'http://moncode.fr'),(39,'2027-10-22 00:00:00','http://lpjw.fr'),(40,'2027-10-22 00:00:00','dfghjkl'),(41,'2022-10-27 00:00:00','dfghjkl'),(42,NULL,'http://lpjw.fr'),(43,NULL,'http://moncode.fr'),(44,NULL,'http://lpjw.fr'),(45,NULL,'http://lpjw.fr'),(46,NULL,'dfghjkl'),(47,NULL,'http://moncode.fr'),(48,NULL,'http://moncode.fr'),(49,NULL,'http://moncode.fr'),(50,NULL,'http://lpjw.fr'),(51,NULL,'http://lpjw.fr'),(52,NULL,'http://moncode.fr'),(53,NULL,'http://lpjw.fr'),(54,NULL,'http://lpjw.fr http://lpjw.fr'),(55,NULL,'http://moncode.fr'),(56,NULL,'http://lpjw.fr'),(57,NULL,'http://moncode.fr'),(58,NULL,'http://lpjw.fr http://lpjw.fr'),(59,NULL,'dfghjkl'),(60,NULL,'http://lpjw.fr'),(61,NULL,'dfghjkl'),(62,NULL,'http://moncode.fr'),(63,'2022-11-17 00:00:00','http://lpjw.fr'),(64,'2022-11-17 00:00:00','http://moncode.fr'),(65,'2022-11-17 00:00:00','dfghjkl'),(66,'2022-11-17 00:00:00','http://moncode.fr'),(67,'2022-11-17 00:00:00','http://lpjw.fr http://lpjw.fr'),(68,'2022-11-17 00:00:00','http://moncode.fr'),(69,'2022-11-18 00:00:00','http://lpjw.fr'),(70,'2022-11-18 00:00:00','dfghjkl'),(71,'2022-11-18 00:00:00','http://moncode.fr'),(72,'2022-11-18 00:00:00','http://lpjw.fr http://lpjw.fr'),(73,'2022-11-18 00:00:00','http://lpjw.fr'),(74,'2022-11-18 00:00:00','http://lpjw.fr'),(75,'2022-11-29 00:00:00','http://moncode.fr'),(76,'2022-11-30 00:00:00','http://lpjw.fr'),(77,'2022-11-30 00:00:00','dfghjkl'),(78,'2022-11-30 00:00:00','http://lpjw.fr'),(79,'2022-11-30 00:00:00','http://moncode.fr'),(80,'2022-11-30 00:00:00','http://lpjw.fr'),(81,'2022-11-30 00:00:00','dfghjkl'),(82,'2022-11-30 00:00:00','http://lpjw.fr'),(83,'2022-11-30 00:00:00','dfghjkl'),(84,'2022-11-30 00:00:00','http://lpjw.fr'),(85,'2022-11-30 00:00:00','http://moncode.fr'),(86,'2022-12-01 00:00:00','http://lpjw.fr'),(87,'2022-12-01 00:00:00','http://moncode.fr'),(88,'2022-12-01 00:00:00','http://lpjw.fr http://lpjw.fr'),(89,'2022-12-02 00:00:00','http://moncode.fr'),(90,'2022-12-02 00:00:00','http://lpjw.fr'),(91,'2022-12-02 00:00:00','http://moncode.fr'),(92,'2022-12-02 00:00:00','http://lpjw.fr'),(93,'2022-12-05 00:00:00','http://lpjw.fr http://lpjw.fr'),(94,'2022-12-05 00:00:00','dfghjkl'),(95,'2022-12-05 00:00:00','dfghjkl'),(96,'2022-12-05 00:00:00','http://lpjw.fr http://lpjw.fr'),(97,'2022-12-06 00:00:00','http://moncode.fr'),(98,'2022-12-08 00:00:00','http://lpjw.fr'),(99,'2022-12-08 00:00:00','http://lpjw.fr http://lpjw.fr'),(100,'2022-12-08 00:00:00','http://moncode.fr'),(101,'2023-08-31 00:00:00','http://lpjw.fr'),(102,'2023-09-06 00:00:00','http://moncode.fr'),(103,'2023-09-27 00:00:00','http://lpjw.fr'),(104,'2023-09-27 00:00:00','http://192.168.250.1/ https://lpjw.fr/ecrans/menu.jpg'),(105,'2023-09-27 00:00:00','http://192.168.250.1/ https://lpjw.fr/ecrans/menu.jpg http://172.17.5.202/Vue_Taches.php'),(106,'2023-10-06 00:00:00',' http://192.168.250.1/ https://lpjw.fr/ecrans/menu.jpg http://172.17.5.202/Vue_Taches.php'),(107,'2023-10-09 00:00:00','https://lyceejosephwresinski.fr/ http://192.168.250.1/ http://lpjw.fr/ecrans/menu.jpg http://lpjw.fr/ecrans/menupeda.jpg'),(108,'2023-10-20 00:00:00','https://lyceejosephwresinski.fr/ http://192.168.250.1/ http://lpjw.fr/ecrans/menu.jpg http://lpjw.fr/ecrans/menupeda.jpg'),(109,'2023-10-20 00:00:00','https://www.youtube.com/'),(110,'2023-10-20 00:00:00','https://lyceejosephwresinski.fr/ http://192.168.250.1/ http://lpjw.fr/ecrans/menu.jpg http://lpjw.fr/ecrans/menupeda.jpg'),(111,'2023-11-06 00:00:00','https://lyceejosephwresinski.fr/ http://192.168.250.1/ http://lpjw.fr/ecrans/menu.jpg http://lpjw.fr/ecrans/menupeda.jpg'),(112,'2023-11-07 00:00:00','https://lyceejosephwresinski.fr/ http://192.168.250.1/ http://lpjw.fr/ecrans/menu.jpg http://lpjw.fr/ecrans/menupeda.jpg'),(113,'2023-11-07 00:00:00','https://lyceejosephwresinski.fr/ http://192.168.250.1/ http://lpjw.fr/ecrans/menu.jpg http://lpjw.fr/ecrans/menupeda.jpg'),(114,'2023-11-07 00:00:00','http://172.17.5.202/configuration.php https://www.it-connect.fr/ http://lpjw.fr http://192.168.250.1'),(115,'2023-11-07 00:00:00','http://172.17.5.202/configuration.php https://www.it-connect.fr/ http://lpjw.fr http://192.168.250.1'),(116,'2023-11-08 00:00:00','http://172.17.5.202/configuration.php https://www.it-connect.fr/ http://lpjw.fr'),(117,'2023-11-08 00:00:00','http://172.17.5.202/configuration.php https://www.it-connect.fr/ http://lpjw.fr'),(118,'2023-11-08 00:00:00','http://172.17.5.202/Videos/LpjwVideo.mp4 http://172.17.5.202/configuration.php https://www.it-connect.fr/ http://lpjw.fr'),(119,'2023-11-08 00:00:00','http://172.17.5.202/Videos/LpjwVideo.mp4 http://172.17.5.202/configuration.php https://www.it-connect.fr/ http://lpjw.fr'),(120,'2023-11-09 00:00:00','https://www.youtube.com/watch?v=2XLwl-DQ1AE&t=2s http://172.17.5.202/configuration.php'),(121,'2023-11-09 00:00:00','https://www.youtube.com/watch?v=2XLwl-DQ1AE&t=2s http://172.17.5.202/configuration.php'),(122,'2023-11-09 00:00:00','https://threatmap.fortiguard.com/ https://lpjw.fr/ecrans/menu.jpg http://172.17.5.202/groupe.php'),(123,'2023-11-09 00:00:00','https://threatmap.fortiguard.com/ https://lpjw.fr/ecrans/menu.jpg http://172.17.5.202/groupe.php'),(124,'2023-11-09 00:00:00','https://threatmap.fortiguard.com/ https://lpjw.fr/ecrans/menu.jpg http://172.17.5.202/groupe.php'),(125,'2023-11-09 00:00:00','https://threatmap.fortiguard.com/ https://lpjw.fr/ecrans/menu.jpg http://172.17.5.202/groupe.php'),(126,'2023-11-10 00:00:00','http://172.17.5.202/groupe.php https://threatmap.fortiguard.com/ https://lpjw.fr/ecrans/menu.jpg '),(127,'2023-11-10 00:00:00','http://172.17.5.202/groupe.php https://threatmap.fortiguard.com/ https://lpjw.fr/ecrans/menu.jpg '),(128,'2023-11-13 00:00:00','http://172.17.5.202/groupe.php https://threatmap.fortiguard.com/ https://lpjw.fr/ecrans/menu.jpg'),(129,'2023-11-13 00:00:00','http://172.17.5.202/groupe.php https://threatmap.fortiguard.com/ https://lpjw.fr/ecrans/menu.jpg'),(130,'2023-11-14 00:00:00','http://172.17.5.202/groupe.php https://threatmap.fortiguard.com/ https://lpjw.fr/ecrans/menu.jpg'),(131,'2023-11-14 00:00:00','http://172.17.5.202/groupe.php https://threatmap.fortiguard.com/ https://lpjw.fr/ecrans/menu.jpg'),(132,'2023-11-15 00:00:00','https://threatmap.fortiguard.com https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr/ecrans/menupeda.jpg'),(133,'2023-11-15 00:00:00','https://threatmap.fortiguard.com https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr/ecrans/menupeda.jpg'),(134,'2023-11-15 00:00:00','https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr'),(135,'2023-11-15 00:00:00','https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr'),(136,'2023-11-17 00:00:00','http://172.17.5.202/barInfo.html https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr '),(137,'2023-11-17 00:00:00','http://172.17.5.202/barInfo.html https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr '),(138,'2023-11-17 00:00:00','https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr'),(139,'2023-11-17 00:00:00','https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr'),(140,'2023-11-23 00:00:00','https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr /home/pi/barInfo.html'),(141,'2023-11-23 00:00:00','https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr /home/pi/barInfo.html'),(142,'2023-12-08 00:00:00','https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr /home/pi/barInfo.html'),(143,'2023-12-08 00:00:00','https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr /home/pi/barInfo.html'),(144,'2023-12-08 00:00:00','https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr'),(145,'2023-12-08 00:00:00','https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr'),(146,'2023-12-08 00:00:00','https://affichage.lpjw.local/meteo.php https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr'),(147,'2023-12-08 00:00:00','https://affichage.lpjw.local/meteo.php https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr'),(148,'2023-12-11 00:00:00','https://affichage.lpjw.local/meteotest.php https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr'),(149,'2023-12-11 00:00:00','https://www.pleinchamp.com/meteo/36-heures/49100-angers https://affichage.lpjw.local/meteotest.php https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr'),(150,'2023-12-11 00:00:00','https://affichage.lpjw.local/meteotest.php https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr'),(151,'2024-02-07 00:00:00','http://affichage.lpjw.local/meteotest.php https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr https://affichage.lpjw.local/display_absences.php.php'),(152,'2024-02-07 00:00:00','http://172.17.5.202/meteotest.php https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr http://172.17.5.202/display_absences.php.php'),(153,'2024-02-07 00:00:00','http://172.17.5.202/meteotest.php https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr http://172.17.5.202/display_absences.php.php'),(154,'2024-02-07 00:00:00','https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr'),(155,'2024-02-08 00:00:00','http://affichage.lpjw.local/meteotest.php https://lpjw.fr/ecrans/menu.jpg https://lpjw.fr https://affichage.lpjw.local/display_absences.php.php'),(156,'2024-02-08 00:00:00','https://affichage.lpjw.local/meteotest.php http://lpjw.fr/ecrans/menu.jpg http://lpjw.fr https://affichage.lpjw.local/display_absences.php'),(157,'2024-02-09 00:00:00','https://affichage.lpjw.local/meteotest.php http://lpjw.fr/ecrans/menu.jpg http://lpjw.fr https://affichage.lpjw.local/display_absences.php'),(158,'2024-02-15 00:00:00','https://affichage.lpjw.local/menu.jpg https://affichage.lpjw.local/meteotest.php http://lpjw.fr/ecrans/menu.jpg http://lpjw.fr https://affichage.lpjw.local/display_absences.php'),(159,'2024-02-19 00:00:00','https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg https://affichage.lpjw.local/meteotest.php http://lpjw.fr/ecrans/menu.jpg http://lpjw.fr https://affichage.lpjw.local/display_absences.php'),(160,'2024-02-20 00:00:00','https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg  https://affichage.lpjw.local/display_absences.php'),(161,'2024-02-20 00:00:00','https://affichage.lpjw.local/display_info.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg https://affichage.lpjw.local/display_absences.php'),(162,'2024-02-21 00:00:00','https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/display_info.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg'),(163,'2024-03-20 00:00:00',' https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg'),(164,'2024-03-25 00:00:00','https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg https://affichage.lpjw.local/imageNoel.jpg'),(165,'2024-03-25 00:00:00','https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg https://news.google.com/home?hl=fr&gl=FR&ceid=FR:fr'),(166,'2024-03-25 00:00:00','https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg https://www.facebook.com/lyceeJW/'),(167,'2024-03-25 00:00:00','https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg'),(168,'2024-03-28 00:00:00','https://lyceejosephwresinski.fr/ https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg'),(169,'2024-03-28 00:00:00','https://www.instagram.com/lycee_wresinski/?hl=fr https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg'),(170,'2024-03-28 00:00:00','https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg'),(171,'2024-03-28 00:00:00','https://www.facebook.com/lyceeJW/ https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg'),(172,'2024-03-28 00:00:00','https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg'),(173,'2024-03-29 09:53:30','https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg'),(174,'2024-04-04 11:35:50','https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg'),(175,'2024-04-24 09:36:10','https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menupeda.jpg https://affichage.lpjw.local/menu.jpg'),(176,'2024-09-02 09:40:36','https://affichage.lpjw.local/bienvenue.jpg https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menu.jpg'),(177,'2024-09-16 08:44:48','https://affichage.lpjw.local/display_absences.php https://affichage.lpjw.local/menu.jpg');
/*!40000 ALTER TABLE `configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupes`
--

DROP TABLE IF EXISTS `groupes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groupes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `membres` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupes`
--

LOCK TABLES `groupes` WRITE;
/*!40000 ALTER TABLE `groupes` DISABLE KEYS */;
INSERT INTO `groupes` VALUES (1,'Atelier','ghjgfdsfffs','1'),(2,'SalleProfForum','Hôtes présents dans la salle des profs du bâtiment administratif','1'),(3,'SalleProfAtrium','Hôtes présents dans la salle des profs du bâtiment Atrium','1'),(7,'Salle des Profs','Salles des profs Atrium & Forum','2');
/*!40000 ALTER TABLE `groupes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pis`
--

DROP TABLE IF EXISTS `pis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `video_acceptance` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pis`
--

LOCK TABLES `pis` WRITE;
/*!40000 ALTER TABLE `pis` DISABLE KEYS */;
INSERT INTO `pis` VALUES (1,'Raspberry_Forum_SI','192.168.250.24','pi','22351414',1),(2,'TVSdpAtrium','192.168.250.117','pi','22351414',1),(3,'TVSdpForum','192.168.250.118','pi','22351414',1),(8,'TVSdpForum','192.168.250.119','pi','22351414',1),(9,'TVSdpAtrium','192.168.250.120','pi','22351414',1);
/*!40000 ALTER TABLE `pis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pis_groups`
--

DROP TABLE IF EXISTS `pis_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pis_groups` (
  `pi_id` int NOT NULL,
  `group_id` int NOT NULL,
  PRIMARY KEY (`pi_id`,`group_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `pis_groups_ibfk_1` FOREIGN KEY (`pi_id`) REFERENCES `pis` (`id`),
  CONSTRAINT `pis_groups_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groupes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pis_groups`
--

LOCK TABLES `pis_groups` WRITE;
/*!40000 ALTER TABLE `pis_groups` DISABLE KEYS */;
INSERT INTO `pis_groups` VALUES (1,1),(3,2),(2,3),(2,7),(3,7);
/*!40000 ALTER TABLE `pis_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `raspberries`
--

DROP TABLE IF EXISTS `raspberries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `raspberries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `group_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `raspberries`
--

LOCK TABLES `raspberries` WRITE;
/*!40000 ALTER TABLE `raspberries` DISABLE KEYS */;
INSERT INTO `raspberries` VALUES (1,'Ecran salle des profs forum','1.1.1.1','1'),(2,'Ecran salle des profs atrium','1.2.3.5','1'),(3,'non nommÃ©','',''),(4,'non nommÃ©','',''),(33,'','',''),(34,'','',''),(35,'','','');
/*!40000 ALTER TABLE `raspberries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `raspberry_videos`
--

DROP TABLE IF EXISTS `raspberry_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `raspberry_videos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `video_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `raspberry_videos`
--

LOCK TABLES `raspberry_videos` WRITE;
/*!40000 ALTER TABLE `raspberry_videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `raspberry_videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `todolist`
--

DROP TABLE IF EXISTS `todolist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `todolist` (
  `TDL_id` int NOT NULL AUTO_INCREMENT,
  `TDL_Name_Tache` varchar(120) NOT NULL,
  `TDL_Priority` enum('Haute','Basse','Moyenne','') NOT NULL,
  `TDL_Date_Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TDL_Date_Achieve` datetime DEFAULT NULL,
  `TDL_Date_Jalon` datetime DEFAULT NULL,
  `TDL_Tache_Achieve` varchar(120) NOT NULL DEFAULT 'NON',
  PRIMARY KEY (`TDL_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `todolist`
--

LOCK TABLES `todolist` WRITE;
/*!40000 ALTER TABLE `todolist` DISABLE KEYS */;
INSERT INTO `todolist` VALUES (16,'Déployer FPROFW10PC09 en montrant à Malo','Moyenne','2021-12-08 13:28:27',NULL,'2021-12-17 00:00:00','NON'),(17,'Préparer les PC portables pour les prises de RDV aux PO','Haute','2021-12-09 08:24:06',NULL,'2021-12-10 00:00:00','OUI'),(18,'Deployer Salle D001 et D002 avec Ciel','Moyenne','2021-12-09 12:53:51',NULL,'2022-01-14 00:00:00','NON'),(19,'Aide Passage code de la route SdR 2&3 13h30','Haute','2021-12-09 13:42:32',NULL,'2021-12-15 00:00:00','NON'),(20,'test','Haute','2022-03-01 11:11:15',NULL,'2022-03-02 00:00:00','NON'),(21,'test 2 ','Haute','2022-03-01 11:12:14',NULL,'2022-02-28 00:00:00','NON'),(22,'test 3','Haute','2022-03-01 11:12:53',NULL,'2022-01-01 00:00:00','NON'),(23,'Préparer les PC portable pour les prise de RDV aux PO','Haute','2022-03-02 08:45:09',NULL,'2022-03-12 00:00:00','NON'),(24,'Porte ouverte 3 pc portable','Haute','2022-03-10 09:08:05',NULL,'2022-03-12 00:00:00','NON'),(25,'Rdv avec Anthony','Haute','2022-03-10 09:08:40',NULL,'2022-03-10 00:00:00','NON'),(26,'Mettre en place disjoncteur connecter pour les lumières','Basse','2022-03-10 09:09:37',NULL,'2022-03-31 00:00:00','NON'),(27,'Rdv avec Mr DEGROLARD','Haute','2022-03-10 09:10:02',NULL,'2022-04-06 00:00:00','NON'),(28,'Formation NOEFIL','Haute','2022-03-10 09:10:23',NULL,'2022-03-18 00:00:00','NON'),(29,'Améliorer L\'affichage dynamique','Haute','2022-10-17 11:39:22',NULL,'2022-10-28 00:00:00','NON'),(30,'reussir ','Basse','2022-10-18 10:44:21',NULL,'2022-10-18 00:00:00','NON'),(31,'','Basse','2022-10-19 09:58:13',NULL,'2022-10-10 00:00:00','NON'),(32,'','Haute','2022-10-19 09:59:23',NULL,'2022-10-10 00:00:00','NON'),(33,'','Moyenne','2022-10-19 10:02:03',NULL,'2022-10-14 00:00:00','NON'),(34,'','Moyenne','2022-10-19 10:03:43',NULL,'2022-10-18 00:00:00','NON'),(35,'','Moyenne','2022-10-19 10:18:06',NULL,'2022-10-07 00:00:00','NON'),(36,'programmationPhp','Moyenne','2022-11-15 09:47:32',NULL,'2022-11-16 00:00:00','NON'),(37,'reussir ','Haute','2022-11-15 15:47:39',NULL,'2022-11-15 00:00:00','NON');
/*!40000 ALTER TABLE `todolist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `video_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-18 16:35:17
