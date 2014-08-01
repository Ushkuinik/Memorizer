CREATE DATABASE  IF NOT EXISTS `memorizer` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `memorizer`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: memorizer
-- ------------------------------------------------------
-- Server version	5.6.19-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `word`
--

DROP TABLE IF EXISTS `word`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `word` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(45) NOT NULL,
  `structure` varchar(45) DEFAULT NULL,
  `id_language` int(11) DEFAULT NULL,
  `id_part_of_speech` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `id_part_of_speech_idx` (`id_part_of_speech`),
  KEY `id_language_idx` (`id_language`),
  CONSTRAINT `id_part_of_speech` FOREIGN KEY (`id_part_of_speech`) REFERENCES `part_of_speech` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `word`
--

LOCK TABLES `word` WRITE;
/*!40000 ALTER TABLE `word` DISABLE KEYS */;
INSERT INTO `word` VALUES (1,'автомобиль','автомоб[и!]ль',1,1),(2,'car','car',2,1),(3,'車','くるま',3,1),(9,'замок','з[а!]мок',1,1),(10,'замок','зам[о!]к',1,1),(11,'lock','lock',2,1),(12,'hasp','hasp',2,1),(13,'吹奏楽団','すいそうがくだん',3,1),(14,'castle','castle',2,1),(15,'духовой оркестр','духов[о!]й орк[е!]стр',1,4);
/*!40000 ALTER TABLE `word` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-08-01 17:09:52
