-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: kampus
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `mahasiswa`
--

DROP TABLE IF EXISTS `mahasiswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nim` varchar(15) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `prodi` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nim` (`nim`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mahasiswa`
--

LOCK TABLES `mahasiswa` WRITE;
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;
INSERT INTO `mahasiswa` VALUES (1,'21060123140160','Banar Pambudi','Teknik Elektro','2025-09-15 05:41:38','2025-09-15 05:41:38');
INSERT INTO `mahasiswa` VALUES (2,'21060123140205','M. Farhan Noufal Abiyyu','Teknik Elektro','2025-09-15 05:42:47','2025-09-15 05:42:47');
INSERT INTO `mahasiswa` VALUES (3,'21060123140121','Ivan Admaja Kuncoro','Teknik Elektro','2025-09-15 05:43:12','2025-09-15 05:43:12');
INSERT INTO `mahasiswa` VALUES (4,'21060123110050','Muhammad Zain Zaidan','Teknik Elektro','2025-09-15 05:44:06','2025-09-15 05:44:06');
INSERT INTO `mahasiswa` VALUES (5,'21060123140192','Jetro Hans Musdyanto','Teknik Elektro','2025-09-15 05:47:50','2025-09-15 05:47:50');
INSERT INTO `mahasiswa` VALUES (6,'21060123140147','Muhammad Farhan Suri','Teknik Elektro','2025-09-15 05:48:12','2025-09-15 05:48:12');
INSERT INTO `mahasiswa` VALUES (7,'21060123140159','Abdul Abid Amrullah','Teknik Elektro','2025-09-15 05:48:26','2025-09-15 05:48:26');
INSERT INTO `mahasiswa` VALUES (8,'21060123140127','Muhammad Royyan','Teknik Elektro','2025-09-15 05:48:47','2025-09-15 05:48:47');
INSERT INTO `mahasiswa` VALUES (9,'21060123140178','Alfath Akbar Yudianto','Teknik Elektro','2025-09-15 05:49:34','2025-09-15 05:49:34');
INSERT INTO `mahasiswa` VALUES (10,'21030122130090','Munna Lissa\'adah','Teknik Kimia','2025-09-15 05:54:58','2025-09-15 06:16:15');
INSERT INTO `mahasiswa` VALUES (11,'23010124130138','Fahmi Irfan Taufiqy','Teknik Mesin','2025-09-15 06:17:02','2025-09-15 06:17:02');
INSERT INTO `mahasiswa` VALUES (12,'24060124120031','Misbachul Munir','Teknik Komputer','2025-09-15 06:18:03','2025-09-15 06:18:03');
/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-15 13:31:44
