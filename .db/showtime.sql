-- MySQL dump 10.16  Distrib 10.1.9-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: projects_cse370
-- ------------------------------------------------------
-- Server version	10.1.9-MariaDB

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
-- Table structure for table `showtime`
--

DROP TABLE IF EXISTS `showtime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `showtime` (
  `showtime_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `showtime_date` int(10) unsigned NOT NULL,
  `movie_id` int(10) unsigned NOT NULL,
  `hall_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`showtime_id`) USING BTREE,
  UNIQUE KEY `showtime_hall` (`showtime_date`,`hall_id`),
  KEY `FK_showtime_movie` (`movie_id`),
  KEY `FK_showtime_hall` (`hall_id`),
  CONSTRAINT `FK_showtime_hall` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`hall_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_showtime_movie` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`movie_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `showtime`
--

LOCK TABLES `showtime` WRITE;
/*!40000 ALTER TABLE `showtime` DISABLE KEYS */;
INSERT INTO `showtime` VALUES (2,1479034800,2,8),(3,1479186000,2,8),(4,1479218400,3,8),(5,1479358800,4,1),(6,1479207600,6,1),(7,1479445200,7,1),(10,1479196800,8,8),(11,1480395600,7,8),(12,1480417200,2,1),(13,1480428000,2,8),(14,1480395600,2,1),(15,1480330800,2,1),(16,1480050000,6,1),(17,1480417200,6,8),(18,1479974400,4,1),(19,1480168800,3,1),(20,1480233600,6,1),(21,1480060800,6,1),(22,1479909600,6,1),(23,1480482000,8,1);
/*!40000 ALTER TABLE `showtime` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-25 21:20:11
