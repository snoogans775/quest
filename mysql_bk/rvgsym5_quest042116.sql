-- MySQL dump 10.13  Distrib 5.6.28, for Linux (x86_64)
--
-- Host: localhost    Database: rvgsym5_quest
-- ------------------------------------------------------
-- Server version	5.6.28-log

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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `username` varchar(30) DEFAULT NULL,
  `hashed_password` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` (`username`, `hashed_password`) VALUES ('quest_admin','$2y$10$OThmNGNlZDcyMjA0YzlmZOseFO2nwkTvA');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `challenges`
--

DROP TABLE IF EXISTS `challenges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `challenges` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `challenges`
--

LOCK TABLES `challenges` WRITE;
/*!40000 ALTER TABLE `challenges` DISABLE KEYS */;
/*!40000 ALTER TABLE `challenges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `completion_commits`
--

DROP TABLE IF EXISTS `completion_commits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `completion_commits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `comments` varchar(500) NOT NULL,
  `links` varchar(200) NOT NULL,
  `source_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `completion_commits`
--

LOCK TABLES `completion_commits` WRITE;
/*!40000 ALTER TABLE `completion_commits` DISABLE KEYS */;
INSERT INTO `completion_commits` (`id`, `user_id`, `comments`, `links`, `source_user_id`) VALUES (1,20,'I beat tha gaem','',40);
/*!40000 ALTER TABLE `completion_commits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currently_playing`
--

DROP TABLE IF EXISTS `currently_playing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currently_playing` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `challenge` varchar(40) NOT NULL,
  PRIMARY KEY (`user_id`,`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currently_playing`
--

LOCK TABLES `currently_playing` WRITE;
/*!40000 ALTER TABLE `currently_playing` DISABLE KEYS */;
INSERT INTO `currently_playing` (`user_id`, `game_id`, `challenge`) VALUES (20,48,''),(20,52,''),(20,55,''),(20,61,''),(20,74,''),(20,78,''),(20,84,''),(20,86,''),(42,49,''),(44,1,''),(44,42,'');
/*!40000 ALTER TABLE `currently_playing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL,
  `platform` varchar(20) NOT NULL,
  `developer` varchar(20) NOT NULL,
  PRIMARY KEY (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` (`game_id`, `title`, `platform`, `developer`) VALUES (1,'Chrono Trigger','SNES','Squaresoft'),(2,'Light Crusader','Sega Genesis','Treasure'),(3,'Ikaruga','Sega Dreamcast','Treasure'),(41,'Splatoon','Nintendo WiiU',''),(42,'Shadow of The Colossus','Sony Playstation 2',''),(43,'Legend of Zelda: Wind Waker','Nintendo Gamecube',''),(44,'Phantasy Star II','Sega Genesis',''),(45,'Shin Megami Tensei: Nocturne','Sony Playstation 2',''),(46,'Phantasy Star IV','Sega Genesis',''),(47,'Shandalar','PC',''),(48,'Odell Down Under','MAC Classic (Mac OS)',''),(49,'The Walking Dead','PC',''),(50,'Pikmin 2','Nintendo Wii',''),(51,'Botanicula','PC',''),(52,'Machinarium','PC',''),(53,'Plants vs. Zombies','Tablet(Android)',''),(54,'Katamari Damacy','Sony Playstation 2',''),(55,'Riviera the Promised Land','Nintendo Gameboy Adv',''),(56,'Railroad Tycoon 2','PC',''),(57,'Freeciv','PC',''),(59,'Battle for Wesnoth','PC',''),(60,'Where we Remain','PC',''),(61,'Kerbal Space Program','PC',''),(62,'Convoy','PC',''),(63,'Nethack','PC',''),(64,'UFO Alien Invasion','PC',''),(74,'Metal Gear Rising: Revengeance ','XBOX 360',''),(75,'Final Fantasy X','Sony Playstation 2',''),(76,'Metal Gear Solid 2: Sons of Liberty ','Sony Playstation 2',''),(77,'Metal Gear Solid 3: Snake Eater','Sony Playstation 2',''),(78,'Broken Age','PC',''),(79,'Final Fantasy II (IV)','Super Nintendo',''),(80,'Earthbound','Super Nintendo',''),(81,'Mother 3','Nintendo Gameboy Adv',''),(82,'Animal Crossing','Nintendo Gamecube',''),(83,'The Legend of Zelda Twilight Princess','Nintendo Gamecube',''),(84,'Undertale','PC',''),(85,'Pokemon Soul Silver/Heart Gold','Nintendo DS',''),(86,'Ori and the Blind Forest','PC',''),(87,'Ace Combat 5','Sony Playstation 2',''),(88,'Ratchet and Clank','Sony Playstation 2',''),(89,'Spyro the Dragon','Sony Playstation',''),(90,'Armored Core: For Answer','XBOX 360',''),(91,'MLB \'09 the Show','Sony Playstation 2','');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games_tags`
--

DROP TABLE IF EXISTS `games_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games_tags` (
  `game_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games_tags`
--

LOCK TABLES `games_tags` WRITE;
/*!40000 ALTER TABLE `games_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `games_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `platforms`
--

DROP TABLE IF EXISTS `platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `platforms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `platforms`
--

LOCK TABLES `platforms` WRITE;
/*!40000 ALTER TABLE `platforms` DISABLE KEYS */;
INSERT INTO `platforms` (`id`, `name`) VALUES (1,'Nintendo Wii'),(3,'Nintendo Gamecube'),(4,'Nintendo 64'),(5,'Super Nintendo'),(6,'NES'),(7,'Famicom'),(8,'Super Famicom'),(9,'Sega Master System'),(10,'Sega Genesis'),(11,'Sega 32X'),(12,'Sega CD'),(13,'Sega Saturn'),(14,'Sega Dreamcast'),(15,'Sony Playstation'),(16,'Sony Playstation 2'),(17,'Sony Playstation 3'),(18,'Sony Playstation 4'),(19,'XBOX'),(20,'XBOX 360'),(21,'XBOX One'),(22,'Sony PSP'),(23,'Sony PS Vita'),(24,'Nintendo Gameboy'),(25,'Nintendo Gameboy Advance'),(26,'Nintendo DS'),(27,'Nintendo 3DS'),(28,'Neo Geo MVS'),(29,'Neo Geo Pocket Color'),(30,'MAC Classic (Mac OS)'),(31,'DOS'),(32,'PC'),(33,'Commodore 64'),(34,'Atari 2600'),(35,'Atari Jaguar'),(36,'Atari Lynx'),(37,'Turbo-Grafx 16'),(38,'PC Engine'),(39,'Nintendo WiiU'),(40,'Tablet(Android)');
/*!40000 ALTER TABLE `platforms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(20) NOT NULL,
  `position` mediumint(9) NOT NULL,
  `visible` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` (`id`, `menu_name`, `position`, `visible`) VALUES (1,'home',1,1),(3,'faq',3,1),(4,'contests',4,1),(5,'forum',4,1);
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` (`id`, `name`) VALUES (1,'beautiful'),(2,'puzzle'),(3,'immersive'),(4,'colorful'),(5,'challenging');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `hashed_password` varchar(80) NOT NULL,
  `points` int(11) NOT NULL,
  `date_joined` date NOT NULL,
  `email` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `hashed_password`, `points`, `date_joined`, `email`) VALUES (20,'kevin','$2y$10$ZDEyN2I0MGUwNDA5MTNlZOIaj.GV4msGD5eoTcuEb.kbweC.CUzcO',400,'2016-04-13','kevin@rvgsymphony.com'),(39,'BubsyFan1','$2y$10$NGUyMzA5NDY3NjZmMWRiZ.42HAL9yRymhuLvtvbDJz9hwWZYpPQdi',400,'2016-04-15',''),(40,'Dwf775','$2y$10$NDgyOGQ0ZjQ5MzUwYTg3Yefr3JHAcRUUxE9NDkNFIm4XX3LotCWAS',400,'2016-04-17','dwf775@gmail.com'),(41,'è ','$2y$10$Y2UzNjljOTQ1OTZmYTIwNuscrcutM1IOAS2k85tmwQRIg7LptU3Km',400,'2016-04-18',''),(42,'amusselm','$2y$10$MmVkNzUyYjdkYjhkMzBkMegOIIV9B.Zg63w/7grxD3rrst9I2sqjK',400,'2016-04-19',''),(43,' S073 Snake','$2y$10$NzZiN2QwYTU3YTc4YmM0NOdHGWUGeJxPC1Xx2xgzo9NrmUSPfpkDm',400,'2016-04-19',''),(44,'S073 Joseph','$2y$10$N2YxM2JhMjRmYjZkYjkyMuczllZbPf3Bqhgwl8YT22yP0EwIZSMJK',400,'2016-04-19','Dublecoco73@gmail.com'),(45,'Jazoko','$2y$10$ODg0MjcyMDJiM2Q0YWIzZOIa4NClO/.1cZJOMmxVFdIz/y7dAcC5S',400,'2016-04-19',''),(46,'ElizSchuler','$2y$10$N2FjZWRjOWEwNGZjZmYyYeIzOh/CB7N6JQNlV0GdsJ8qpsuEql4UG',400,'2016-04-20','fanfootedgecko@Yahoo.com'),(47,'Strayedphantom','$2y$10$NmMyYTIyM2Y2YWU3Nzk5M.3Ho0iJj2yveXTYlhoxiBbz4cl2q.hKq',400,'2016-04-20','cfsemail1000@gmail.com');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_games`
--

DROP TABLE IF EXISTS `users_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_games` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `challenge` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_games`
--

LOCK TABLES `users_games` WRITE;
/*!40000 ALTER TABLE `users_games` DISABLE KEYS */;
INSERT INTO `users_games` (`user_id`, `game_id`, `challenge`) VALUES (20,1,'Beat New Game+'),(20,41,'Reach Level 20'),(20,42,''),(28,43,''),(39,44,''),(39,45,''),(39,44,''),(39,46,''),(39,47,''),(39,48,'Finish a Tournament'),(40,49,''),(40,50,''),(40,49,''),(40,51,''),(40,52,''),(40,53,''),(20,54,''),(39,55,''),(42,56,'Complete the main campaign '),(42,57,'Win a game against the AI '),(42,56,'Complete the main campaign'),(42,59,'Complete Delfador\'s Memiors'),(42,60,'Get at least 2 endings'),(42,61,'Plant a flag on the Mun'),(42,62,''),(42,63,''),(42,64,''),(44,74,''),(44,75,''),(44,76,''),(44,77,''),(45,78,''),(46,79,''),(46,80,''),(46,81,''),(46,82,'Pay off your house completely'),(46,83,'Acceptable on Wii and Wii U also'),(46,84,'Beat True Pacifist Ending'),(46,85,'Collect all 16 badges and beat the leagu'),(46,86,''),(47,87,''),(47,88,''),(47,89,''),(47,90,'Aquire MOONLIGHT'),(39,91,'Talk to me. ');
/*!40000 ALTER TABLE `users_games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'rvgsym5_quest'
--

--
-- Dumping routines for database 'rvgsym5_quest'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-21 20:37:53
