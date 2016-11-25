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
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice` (
  `invoice_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `total` double NOT NULL,
  `discount` double NOT NULL,
  `invoice_date` int(10) unsigned NOT NULL,
  `payment_date` int(10) unsigned NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `invoice_status` varchar(20) NOT NULL,
  PRIMARY KEY (`invoice_id`) USING BTREE,
  UNIQUE KEY `order_id` (`order_id`) USING BTREE,
  KEY `FK_invoice_user` (`user_id`),
  CONSTRAINT `FK_invoice_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_invoice_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
INSERT INTO `invoice` VALUES (1,12,1,1200,0,1479743809,1479743809,'manual','paid'),(2,15,1,800,0,1479745366,1479745366,'manual','paid'),(3,17,1,2400,0,1479749927,1479749927,'manual','paid'),(4,27,1,800,0,1479798267,1479798267,'manual','paid'),(5,29,1,1200,0,1479798363,1479798363,'manual','paid'),(6,31,1,800,0,1479799106,1479799106,'manual','paid'),(7,32,4,800,0,1479802732,1479802732,'manual','paid'),(8,33,1,1200,0,1480071915,1480071915,'manual','paid'),(9,41,5,800,0,1480081780,1480081780,'manual','paid'),(10,42,1,2400,0,1480085416,1480085416,'manual','paid');
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-25 21:19:26
