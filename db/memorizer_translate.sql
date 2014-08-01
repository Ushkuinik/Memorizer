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
-- Table structure for table `translate`
--

DROP TABLE IF EXISTS `translate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_word_from` int(10) unsigned DEFAULT NULL,
  `id_word_to` int(10) unsigned DEFAULT NULL,
  `weight` tinyint(4) DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `id_word_from_idx` (`id_word_from`),
  KEY `id_word_to_idx` (`id_word_to`),
  CONSTRAINT `id_word_from` FOREIGN KEY (`id_word_from`) REFERENCES `word` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_word_to` FOREIGN KEY (`id_word_to`) REFERENCES `word` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translate`
--

LOCK TABLES `translate` WRITE;
/*!40000 ALTER TABLE `translate` DISABLE KEYS */;
INSERT INTO `translate` VALUES (1,1,2,100),(2,2,1,100),(3,1,3,100),(4,3,1,100),(5,2,3,100),(6,3,2,100),(7,9,14,100),(8,14,9,100),(9,13,15,100),(10,15,13,100),(11,10,11,100),(12,10,12,100),(13,11,10,100),(14,12,10,100);
/*!40000 ALTER TABLE `translate` ENABLE KEYS */;
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
