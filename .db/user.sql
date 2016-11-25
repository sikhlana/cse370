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
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password_hash` binary(40) NOT NULL,
  `password_salt` binary(40) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `billing_street_1` varchar(100) NOT NULL DEFAULT '',
  `billing_street_2` varchar(100) NOT NULL DEFAULT '',
  `billing_zip` varchar(12) NOT NULL DEFAULT '',
  `billing_city` varchar(50) NOT NULL DEFAULT '',
  `billing_country` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'inbox@saifmahmud.name','b4c96ad9b16bea29c969ecdb9284473f5bf49c7a','RyGu-OUbiAIPN28SfKATXCYxsYA2g2tjFRRcwZFj',1,'Saif','Mahmud','336, TV Road','East Rampura','1219','Dhaka','BD'),(2,'aditalha@gmail.com','be19372b60e558ec6b7fdf1d928b4c6620dc88de','D0WmYjsxD3CZBJwqOFFdoyoQsnjiGlo2kHV2i6eo',0,'Talha','Ahmed','','','','',''),(3,'sexboi@gmail.com','634caa6cbddf4cccc2ea7e94ac5c87743c72bee4','cOylcsLhBMKjvWGZnhGrTWouA0y1GHUCkLbbvtjz',0,'sexxy','boii','','','','',''),(4,'sikhlana@gmail.com','8db33f4edf1219070efaceab3912272f5e0f5bf5','jUuS_BoqvEeKL2PdleElVvwnkWcT9FJdUZkLAEHZ',0,'Saif','Mahmud','','','','',''),(5,'saif@gfnlabs.com','06aa441b486eca7df87e06832f31d445c6f31539','AZxJjbGEagySBiNZmabz3ifhDmLdcs6YRkOBcqIR',0,'Sikhlana','Bhaya','','','','','');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-25 21:20:26
