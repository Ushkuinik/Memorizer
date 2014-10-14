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
-- Table structure for table `brief`
--

DROP TABLE IF EXISTS `brief`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brief` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word_id` int(10) unsigned DEFAULT NULL,
  `brief` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `id_word_idx` (`word_id`),
  CONSTRAINT `id_word` FOREIGN KEY (`word_id`) REFERENCES `word` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brief`
--

LOCK TABLES `brief` WRITE;
/*!40000 ALTER TABLE `brief` DISABLE KEYS */;
INSERT INTO `brief` VALUES (1,1,'транспортное средство'),(2,2,'a vehicle'),(3,9,'оборонительное сооружение'),(4,10,'запорное устройство'),(5,11,'a security mechanism'),(6,14,'a fortification construction'),(12,49,'устройство для отпирания замка'),(13,50,'родник'),(15,80,'Четвертая планета Солнечной системы'),(16,81,'Восьмая планета Солнечной системы'),(17,78,'Первая планета Солнечной системы'),(18,84,'Вторая планета Солнечной системы'),(19,94,'Третья планета Соленчной системы'),(20,86,'Пятая планета Солнечной системы'),(21,87,'Шестая планета Соленчной системы'),(22,89,'Седьмая планета солнечной системы'),(23,91,'карликовая планета Солнечной системы'),(24,102,'спутник Земли'),(26,141,'галактика Млечный Путь'),(27,342,'The galaxy that contains our Solar System'),(28,349,'литературнное произведение'),(29,477,'осмотр произведений искусства');
/*!40000 ALTER TABLE `brief` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-14  9:02:02
