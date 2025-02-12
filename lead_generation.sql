-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: lead_generation
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `lead_images`
--

DROP TABLE IF EXISTS `lead_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lead_images` (
  `image_id` int NOT NULL AUTO_INCREMENT,
  `lead_id` int DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`image_id`),
  KEY `lead_id` (`lead_id`),
  CONSTRAINT `lead_images_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`lead_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lead_images`
--

LOCK TABLES `lead_images` WRITE;
/*!40000 ALTER TABLE `lead_images` DISABLE KEYS */;
INSERT INTO `lead_images` VALUES (16,1,'default.jpg'),(17,1,'default.jpg'),(18,2,'default.jpg'),(19,2,'default.jpg'),(20,3,'default.jpg'),(21,3,'default.jpg'),(22,4,'default.jpg'),(23,5,'default.jpg'),(24,6,'default.jpg'),(25,6,'default.jpg'),(26,7,'default.jpg'),(27,8,'default.jpg'),(28,9,'default.jpg'),(29,10,'default.jpg'),(30,10,'default.jpg');
/*!40000 ALTER TABLE `lead_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leads` (
  `lead_id` int NOT NULL AUTO_INCREMENT,
  `lead_number` varchar(50) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `project_name` varchar(100) DEFAULT NULL,
  `flat_details` text,
  `property_cost` decimal(10,2) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `loan_amount` decimal(10,2) DEFAULT NULL,
  `rate_of_interest` decimal(5,2) DEFAULT NULL,
  `tenor` int DEFAULT NULL,
  `emi` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`lead_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leads`
--

LOCK TABLES `leads` WRITE;
/*!40000 ALTER TABLE `leads` DISABLE KEYS */;
INSERT INTO `leads` VALUES (1,'LEAD0001','John Doe','1234567890','Sunrise Apartments','2 BHK, Floor 5, 1200 sq.ft.',4500000.00,'California','Los Angeles',3000000.00,5.75,240,19000.00,'2025-02-11 06:43:32'),(2,'LEAD0002','Jane Smith','0987654321','Oceanview Heights','3 BHK, Floor 8, 1500 sq.ft.',6000000.00,'Florida','Miami',4000000.00,6.50,300,25000.00,'2025-02-11 06:43:32'),(3,'LEAD0003','Alice Johnson','1122334455','Greenfield Gardens','1 BHK, Floor 2, 800 sq.ft.',3000000.00,'Texas','Houston',2000000.00,4.85,180,15000.00,'2025-02-11 06:43:32'),(4,'LEAD0004','Bob Williams','6677889900','City Towers','Studio, Floor 3, 600 sq.ft.',2500000.00,'New York','New York City',1800000.00,5.50,150,12000.00,'2025-02-11 06:43:32'),(5,'LEAD0005','Michael Brown','5566778899','Skyline Residences','4 BHK, Floor 15, 2000 sq.ft.',8000000.00,'California','San Francisco',5000000.00,7.00,300,35000.00,'2025-02-11 06:43:32'),(6,'LEAD0006','Emily Davis','4433221100','Crystal Lake Villas','2 BHK, Floor 10, 1100 sq.ft.',4500000.00,'Nevada','Las Vegas',2800000.00,5.25,240,21000.00,'2025-02-11 06:43:32'),(7,'LEAD0007','David Martinez','3322119988','Maple Grove Homes','3 BHK, Floor 4, 1400 sq.ft.',5500000.00,'Illinois','Chicago',3500000.00,5.95,240,23000.00,'2025-02-11 06:43:32'),(8,'LEAD0008','Sophia Moore','7766554433','Blue Ridge Estates','1 BHK, Floor 6, 850 sq.ft.',3500000.00,'Colorado','Denver',2500000.00,6.10,180,17000.00,'2025-02-11 06:43:32'),(9,'LEAD0009','William Taylor','9988776655','Sunset Towers','2 BHK, Floor 12, 1300 sq.ft.',5000000.00,'California','San Diego',3300000.00,5.90,240,22000.00,'2025-02-11 06:43:32'),(10,'LEAD0010','Olivia Anderson','2233445566','Willow Springs','3 BHK, Floor 5, 1400 sq.ft.',5500000.00,'Georgia','Atlanta',3400000.00,6.25,180,20000.00,'2025-02-11 06:43:32');
/*!40000 ALTER TABLE `leads` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-12 10:08:05
