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
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket` (
  `ticket_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `showtime_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `seat_number` varchar(10) NOT NULL,
  `ticket_price` double NOT NULL,
  `ticket_grade` enum('regular','premium') NOT NULL,
  PRIMARY KEY (`ticket_id`) USING BTREE,
  UNIQUE KEY `showtime_id_seat_number` (`showtime_id`,`seat_number`),
  KEY `FK_ticket_order` (`order_id`),
  CONSTRAINT `FK_ticket_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_ticket_showtime` FOREIGN KEY (`showtime_id`) REFERENCES `showtime` (`showtime_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket`
--

LOCK TABLES `ticket` WRITE;
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
INSERT INTO `ticket` VALUES (41,14,12,'A-9',400,'regular'),(42,14,12,'A-10',400,'regular'),(43,14,12,'A-11',400,'regular'),(55,14,15,'A-14',400,'regular'),(56,14,15,'A-15',400,'regular'),(58,16,17,'A-6',400,'regular'),(59,16,17,'A-7',400,'regular'),(60,16,17,'A-8',400,'regular'),(61,16,17,'A-9',400,'regular'),(62,16,17,'A-10',400,'regular'),(63,16,17,'A-11',400,'regular'),(86,14,27,'B-4',400,'regular'),(87,14,27,'B-5',400,'regular'),(89,13,29,'D-8',400,'regular'),(90,13,29,'D-9',400,'regular'),(92,13,29,'D-10',400,'regular'),(96,18,31,'A-12',400,'regular'),(97,18,31,'A-13',400,'regular'),(98,12,32,'A-6',400,'regular'),(99,12,32,'A-7',400,'regular'),(101,15,33,'A-9',600,'premium'),(102,15,33,'A-10',600,'premium'),(117,13,41,'D-13',400,'regular'),(118,13,41,'D-14',400,'regular'),(119,17,42,'A-11',400,'regular'),(120,17,42,'A-12',400,'regular'),(121,17,42,'A-13',400,'regular'),(122,17,42,'A-14',400,'regular'),(123,17,42,'A-15',400,'regular'),(124,17,42,'A-16',400,'regular');
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-25 21:20:21
