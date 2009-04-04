-- MySQL dump 10.13  Distrib 5.1.33, for Win32 (ia32)
--
-- Host: localhost    Database: so_class
-- ------------------------------------------------------
-- Server version	5.1.33-community

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
-- Table structure for table `tblcentre`
--

DROP TABLE IF EXISTS `tblcentre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblcentre` (
  `idtblCentre` int(11) NOT NULL AUTO_INCREMENT,
  `strCentreID` varchar(45) NOT NULL,
  `strName` varchar(45) NOT NULL,
  `strBuilding` varchar(45) DEFAULT NULL,
  `strCity` varchar(45) DEFAULT NULL,
  `strStreet` varchar(45) DEFAULT NULL,
  `strDistrict` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtblCentre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcentre`
--

LOCK TABLES `tblcentre` WRITE;
/*!40000 ALTER TABLE `tblcentre` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblcentre` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trinserttblcentre after insert on tblcentre
for each row insert tblcentrelog
(idtblcentre
,dtTimeStamp
,strAction
,strCentreID
,strName
,strBuilding
,strCity
,strStreet
,strDistrict
)
values
(new.idtblcentre
,now()
,'Insert'
,new.strCentreID
,new.strName
,new.strBuilding
,new.strCity
,new.strStreet
,new.strDistrict
) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trupdatetblcentre after update on tblcentre
for each row insert tblcentrelog
(idtblcentre
,dtTimeStamp
,strAction
,strCentreID
,strName
,strBuilding
,strCity
,strStreet
,strDistrict
)
values
(new.idtblcentre
,now()
,'Update'
,new.strCentreID
,new.strName
,new.strBuilding
,new.strCity
,new.strStreet
,new.strDistrict
) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trdeletetblcentre after delete on tblcentre
for each row insert tblcentrelog
(idtblcentre
,dtTimeStamp
,strAction
,strCentreID
,strName
,strBuilding
,strCity
,strStreet
,strDistrict
)
values
(old.idtblcentre
,now()
,'Delete'
,old.strCentreID
,old.strName
,old.strBuilding
,old.strCity
,old.strStreet
,old.strDistrict
) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tblcentrelog`
--

DROP TABLE IF EXISTS `tblcentrelog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblcentrelog` (
  `idtblCentre` int(11) NOT NULL,
  `dtTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `strAction` varchar(45) DEFAULT NULL,
  `strCentreID` varchar(45) NOT NULL,
  `strName` varchar(45) NOT NULL,
  `strBuilding` varchar(45) DEFAULT NULL,
  `strCity` varchar(45) DEFAULT NULL,
  `strStreet` varchar(45) DEFAULT NULL,
  `strDistrict` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`dtTimeStamp`,`idtblCentre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcentrelog`
--

LOCK TABLES `tblcentrelog` WRITE;
/*!40000 ALTER TABLE `tblcentrelog` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblcentrelog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblfacilitator`
--

DROP TABLE IF EXISTS `tblfacilitator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblfacilitator` (
  `idtblFacilitator` int(11) NOT NULL AUTO_INCREMENT,
  `strLastName` varchar(45) NOT NULL,
  `strFirstName` varchar(45) NOT NULL,
  `strPassword` varchar(45) NOT NULL,
  `strBuilding` varchar(45) DEFAULT NULL,
  `strStreet` varchar(45) DEFAULT NULL,
  `strCity` varchar(45) DEFAULT NULL,
  `strDistrict` varchar(45) DEFAULT NULL,
  `strTelephone` varchar(45) DEFAULT NULL,
  `strMobile` varchar(45) DEFAULT NULL,
  `strPostCode` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtblFacilitator`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblfacilitator`
--

LOCK TABLES `tblfacilitator` WRITE;
/*!40000 ALTER TABLE `tblfacilitator` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblfacilitator` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trinserttblFacilitator after insert on tblFacilitator

for each row INSERT INTO `tblFacilitatorLog` (`idtblFacilitator`

, `dtTimeStamp`

, `strAction`

, `strLastName`

, `strFirstName`

, `strPassword`

, `strBuilding`

, `strStreet`

, `strCity`

, `strDistrict`

, `strTelephone`

, `strMobile`, strPostCode)

VALUES (new.`idtblFacilitator`

, now()

, 'Insert'

, new.`strLastName`

, new.`strFirstName`

, new.`strPassword`

, new.`strBuilding`

, new.`strStreet`

, new.`strCity`

, new.`strDistrict`

, new.`strTelephone`

, new.`strMobile`, new.strPostCode

) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trupdatetblFacilitator after update on tblFacilitator

for each row INSERT INTO `tblFacilitatorLog` (`idtblFacilitator`

, `dtTimeStamp`

, `strAction`

, `strLastName`

, `strFirstName`

, `strPassword`

, `strBuilding`

, `strStreet`

, `strCity`

, `strDistrict`

, `strTelephone`

, `strMobile`,strPostCode)

VALUES (new.`idtblFacilitator`

, now()

, 'Update'

, new.`strLastName`

, new.`strFirstName`

, new.`strPassword`

, new.`strBuilding`

, new.`strStreet`

, new.`strCity`

, new.`strDistrict`

, new.`strTelephone`

, new.`strMobile`, new.strPostCode

) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trdeletetblFacilitator after delete on tblFacilitator

for each row INSERT INTO `tblFacilitatorLog` (`idtblFacilitator`

, `dtTimeStamp`

, `strAction`

, `strLastName`

, `strFirstName`

, `strPassword`

, `strBuilding`

, `strStreet`

, `strCity`

, `strDistrict`

, `strTelephone`

, `strMobile`,strPostCode)

VALUES (old.`idtblFacilitator`

, now()

, 'Delete'

, old.`strLastName`

, old.`strFirstName`

, old.`strPassword`

, old.`strBuilding`

, old.`strStreet`

, old.`strCity`

, old.`strDistrict`

, old.`strTelephone`

, old.`strMobile`, old.strPostCode

) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tblfacilitatorlog`
--

DROP TABLE IF EXISTS `tblfacilitatorlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblfacilitatorlog` (
  `idtblFacilitator` int(11) NOT NULL,
  `dtTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `strAction` varchar(45) DEFAULT NULL,
  `strLastName` varchar(45) NOT NULL,
  `strFirstName` varchar(45) NOT NULL,
  `strPassword` varchar(45) NOT NULL,
  `strBuilding` varchar(45) DEFAULT NULL,
  `strStreet` varchar(45) DEFAULT NULL,
  `strCity` varchar(45) DEFAULT NULL,
  `strDistrict` varchar(45) DEFAULT NULL,
  `strTelephone` varchar(45) DEFAULT NULL,
  `strMobile` varchar(45) DEFAULT NULL,
  `strPostCode` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtblFacilitator`,`dtTimeStamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblfacilitatorlog`
--

LOCK TABLES `tblfacilitatorlog` WRITE;
/*!40000 ALTER TABLE `tblfacilitatorlog` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblfacilitatorlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbllesson`
--

DROP TABLE IF EXISTS `tbllesson`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbllesson` (
  `idtblLesson` int(11) NOT NULL AUTO_INCREMENT,
  `strTitle` varchar(45) NOT NULL,
  `dFee` decimal(10,0) NOT NULL,
  `strID` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtblLesson`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbllesson`
--

LOCK TABLES `tbllesson` WRITE;
/*!40000 ALTER TABLE `tbllesson` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbllesson` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trInserttbllesson after insert on tbllesson

for each row insert tbllessonlog

(idtbllesson

,dtTimeStamp

,strAction

,strTitle

,dFee
,strID)

values

(new.idtbllesson

,now()

,'Insert'

,new.strTitle

,new.dFee
,new.strID) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trUpdatetbllesson after update on tbllesson

for each row insert tbllessonlog

(idtbllesson

,dtTimeStamp

,strAction

,strTitle

,dFee,strID)

values

(new.idtbllesson

,now()

,'Update'

,new.strTitle

,new.dFee,new.strID) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trDeletetbllesson after delete on tbllesson

for each row insert tbllessonlog

(idtbllesson

,dtTimeStamp

,strAction

,strTitle

,dFee,strID)

values

(old.idtbllesson

,now()

,'Delete'

,old.strTitle

,old.dFee,old.strID) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tbllessonlog`
--

DROP TABLE IF EXISTS `tbllessonlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbllessonlog` (
  `idtblLesson` int(11) NOT NULL,
  `dtTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `strAction` varchar(45) DEFAULT NULL,
  `strTitle` varchar(45) NOT NULL,
  `dFee` decimal(10,0) NOT NULL,
  `strID` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtblLesson`,`dtTimeStamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbllessonlog`
--

LOCK TABLES `tbllessonlog` WRITE;
/*!40000 ALTER TABLE `tbllessonlog` DISABLE KEYS */;
INSERT INTO `tbllessonlog` VALUES (1,'2009-04-04 17:42:34','Insert','New lesson','100',NULL),(1,'2009-04-04 17:43:08','Update','Revised','100',NULL),(1,'2009-04-04 17:44:02','Delete','Revised','100',NULL);
/*!40000 ALTER TABLE `tbllessonlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbllessonstudent`
--

DROP TABLE IF EXISTS `tbllessonstudent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbllessonstudent` (
  `idtblLessonStudent` int(11) NOT NULL AUTO_INCREMENT,
  `dtLessonDate` date NOT NULL,
  `dFee` decimal(10,0) DEFAULT NULL,
  `dDiscount` decimal(10,0) DEFAULT NULL,
  `dPaid` decimal(10,0) DEFAULT NULL,
  `bPaymentConfirmed` tinyint(1) DEFAULT NULL,
  `tblLesson_idtblLesson` int(11) DEFAULT NULL,
  `tblFacilitator_idtblFacilitator` int(11) DEFAULT NULL,
  `tblStudent_idtblLessonStudent` int(11) DEFAULT NULL,
  `tblCentre_idtblCentre` int(11) DEFAULT NULL,
  PRIMARY KEY (`idtblLessonStudent`),
  KEY `fk_tblLessonStudent_tblLesson` (`tblLesson_idtblLesson`),
  KEY `fk_tblLessonStudent_tblFacilitator` (`tblFacilitator_idtblFacilitator`),
  KEY `fk_tblLessonStudent_tblStudent` (`tblStudent_idtblLessonStudent`),
  KEY `fk_tblLessonStudent_tblCentre` (`tblCentre_idtblCentre`),
  CONSTRAINT `fk_tblLessonStudent_tblCentre` FOREIGN KEY (`tblCentre_idtblCentre`) REFERENCES `tblcentre` (`idtblCentre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblLessonStudent_tblFacilitator` FOREIGN KEY (`tblFacilitator_idtblFacilitator`) REFERENCES `tblfacilitator` (`idtblFacilitator`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblLessonStudent_tblLesson` FOREIGN KEY (`tblLesson_idtblLesson`) REFERENCES `tbllesson` (`idtblLesson`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblLessonStudent_tblStudent` FOREIGN KEY (`tblStudent_idtblLessonStudent`) REFERENCES `tblstudent` (`idtblLessonStudent`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbllessonstudent`
--

LOCK TABLES `tbllessonstudent` WRITE;
/*!40000 ALTER TABLE `tbllessonstudent` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbllessonstudent` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trinserttblLessonStudent after insert on tblLessonStudent
for each row INSERT INTO `tblLessonStudentLog`
(`idtblLessonStudent`
, `dtTimeStamp`
, `strAction`
, `dtLessonDate`
, `dFee`
, `dDiscount`
, `dPaid`
, `bPaymentConfirmed`
, `tblLesson_idtblLesson`
, `tblFacilitator_idtblFacilitator`
, `tblStudent_idtblLessonStudent`
, `tblCentre_idtblCentre`)
VALUES (new.`idtblLessonStudent`
, now()
, 'Insert'
, new.`dtLessonDate`
, new.`dFee`
, new.`dDiscount`
, new.`dPaid`
, new.`bPaymentConfirmed`
, new.`tblLesson_idtblLesson`
, new.`tblFacilitator_idtblFacilitator`
, new.`tblStudent_idtblLessonStudent`
, new.`tblCentre_idtblCentre`

) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trupdatetblLessonStudent after update on tblLessonStudent
for each row INSERT INTO `tblLessonStudentLog`
(`idtblLessonStudent`
, `dtTimeStamp`
, `strAction`
, `dtLessonDate`
, `dFee`
, `dDiscount`
, `dPaid`
, `bPaymentConfirmed`
, `tblLesson_idtblLesson`
, `tblFacilitator_idtblFacilitator`
, `tblStudent_idtblLessonStudent`
, `tblCentre_idtblCentre`)
VALUES (new.`idtblLessonStudent`
, now()
, 'Update'
, new.`dtLessonDate`
, new.`dFee`
, new.`dDiscount`
, new.`dPaid`
, new.`bPaymentConfirmed`
, new.`tblLesson_idtblLesson`
, new.`tblFacilitator_idtblFacilitator`
, new.`tblStudent_idtblLessonStudent`
, new.`tblCentre_idtblCentre`

) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trdeletetblLessonStudent after delete on tblLessonStudent
for each row INSERT INTO `tblLessonStudentLog`
(`idtblLessonStudent`
, `dtTimeStamp`
, `strAction`
, `dtLessonDate`
, `dFee`
, `dDiscount`
, `dPaid`
, `bPaymentConfirmed`
, `tblLesson_idtblLesson`
, `tblFacilitator_idtblFacilitator`
, `tblStudent_idtblLessonStudent`
, `tblCentre_idtblCentre`)
VALUES (old.`idtblLessonStudent`
, now()
, 'Delete'
, old.`dtLessonDate`
, old.`dFee`
, old.`dDiscount`
, old.`dPaid`
, old.`bPaymentConfirmed`
, old.`tblLesson_idtblLesson`
, old.`tblFacilitator_idtblFacilitator`
, old.`tblStudent_idtblLessonStudent`
, old.`tblCentre_idtblCentre`

) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tbllessonstudentlog`
--

DROP TABLE IF EXISTS `tbllessonstudentlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbllessonstudentlog` (
  `idtblLessonStudent` int(11) NOT NULL,
  `dtTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `strAction` varchar(45) DEFAULT NULL,
  `dtLessonDate` date NOT NULL,
  `dFee` decimal(10,0) DEFAULT NULL,
  `dDiscount` decimal(10,0) DEFAULT NULL,
  `dPaid` decimal(10,0) DEFAULT NULL,
  `bPaymentConfirmed` tinyint(1) DEFAULT NULL,
  `tblLesson_idtblLesson` int(11) DEFAULT NULL,
  `tblFacilitator_idtblFacilitator` int(11) DEFAULT NULL,
  `tblStudent_idtblLessonStudent` int(11) DEFAULT NULL,
  `tblCentre_idtblCentre` int(11) DEFAULT NULL,
  PRIMARY KEY (`idtblLessonStudent`,`dtTimeStamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbllessonstudentlog`
--

LOCK TABLES `tbllessonstudentlog` WRITE;
/*!40000 ALTER TABLE `tbllessonstudentlog` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbllessonstudentlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblstudent`
--

DROP TABLE IF EXISTS `tblstudent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblstudent` (
  `idtblLessonStudent` int(11) NOT NULL AUTO_INCREMENT,
  `strStudentID` varchar(45) NOT NULL,
  `strPassword` varchar(45) NOT NULL,
  `strLastName` varchar(45) NOT NULL,
  `strFirstName` varchar(45) NOT NULL,
  `strBuilding` varchar(45) DEFAULT NULL,
  `strStreet` varchar(45) DEFAULT NULL,
  `strCity` varchar(45) DEFAULT NULL,
  `strDistrict` varchar(45) DEFAULT NULL,
  `strTelephone` varchar(45) DEFAULT NULL,
  `strMobile` varchar(45) DEFAULT NULL,
  `dtDOB` date DEFAULT NULL,
  `strPostCode` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtblLessonStudent`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblstudent`
--

LOCK TABLES `tblstudent` WRITE;
/*!40000 ALTER TABLE `tblstudent` DISABLE KEYS */;
INSERT INTO `tblstudent` VALUES (1,'myUsername','myPassword','myLastName','myFirstName','myBuilding','myStreet','myCity','myDistrict','myTelephone','myMobile',NULL,NULL);
/*!40000 ALTER TABLE `tblstudent` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trinserttblStudent after insert on tblStudent

for each row INSERT INTO `tblStudentLog`

(`idtblLessonStudent`

, `dtTimeStamp`

, `strAction`

, `strStudentID`

, `strPassword`

, `strLastName`

, `strFirstName`

, `strBuilding`

, `strStreet`

, `strCity`

, `strDistrict`

, `strTelephone`

, `strMobile`

, `dtDOB`, strPostCode)

VALUES (new.`idtblLessonStudent`

, now()

, 'Insert'

, new.`strStudentID`

, new.`strPassword`

, new.`strLastName`

, new.`strFirstName`

, new.`strBuilding`

, new.`strStreet`

, new.`strCity`

, new.`strDistrict`

, new.`strTelephone`

, new.`strMobile`

, new.`dtDOB`, new.strPostCode) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trupdatetblStudent after update on tblStudent

for each row INSERT INTO `tblStudentLog`

(`idtblLessonStudent`

, `dtTimeStamp`

, `strAction`

, `strStudentID`

, `strPassword`

, `strLastName`

, `strFirstName`

, `strBuilding`

, `strStreet`

, `strCity`

, `strDistrict`

, `strTelephone`

, `strMobile`

, `dtDOB`, strPostCode)

VALUES (new.`idtblLessonStudent`

, now()

, 'Update'

, new.`strStudentID`

, new.`strPassword`

, new.`strLastName`

, new.`strFirstName`

, new.`strBuilding`

, new.`strStreet`

, new.`strCity`

, new.`strDistrict`

, new.`strTelephone`

, new.`strMobile`

, new.`dtDOB`, new.strPostCode) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trdeletetblStudent after delete on tblStudent

for each row INSERT INTO `tblStudentLog`

(`idtblLessonStudent`

, `dtTimeStamp`

, `strAction`

, `strStudentID`

, `strPassword`

, `strLastName`

, `strFirstName`

, `strBuilding`

, `strStreet`

, `strCity`

, `strDistrict`

, `strTelephone`

, `strMobile`

, `dtDOB`, strPostCode)

VALUES (old.`idtblLessonStudent`

, now()

, 'Delete'

, old.`strStudentID`

, old.`strPassword`

, old.`strLastName`

, old.`strFirstName`

, old.`strBuilding`

, old.`strStreet`

, old.`strCity`

, old.`strDistrict`

, old.`strTelephone`

, old.`strMobile`

, old.`dtDOB`, old.strPostCode) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tblstudentlog`
--

DROP TABLE IF EXISTS `tblstudentlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblstudentlog` (
  `idtblLessonStudent` int(11) NOT NULL,
  `dtTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `strAction` varchar(45) DEFAULT NULL,
  `strStudentID` varchar(45) NOT NULL,
  `strPassword` varchar(45) NOT NULL,
  `strLastName` varchar(45) NOT NULL,
  `strFirstName` varchar(45) NOT NULL,
  `strBuilding` varchar(45) DEFAULT NULL,
  `strStreet` varchar(45) DEFAULT NULL,
  `strCity` varchar(45) DEFAULT NULL,
  `strDistrict` varchar(45) DEFAULT NULL,
  `strTelephone` varchar(45) DEFAULT NULL,
  `strMobile` varchar(45) DEFAULT NULL,
  `dtDOB` date DEFAULT NULL,
  `strPostCode` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtblLessonStudent`,`dtTimeStamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblstudentlog`
--

LOCK TABLES `tblstudentlog` WRITE;
/*!40000 ALTER TABLE `tblstudentlog` DISABLE KEYS */;
INSERT INTO `tblstudentlog` VALUES (1,'2009-04-04 21:30:49','Insert','myUsername','myPassword','myLastName','myFirstName','myBuilding','myStreet','myCity','myDistrict','myTelephone','myMobile',NULL,NULL);
/*!40000 ALTER TABLE `tblstudentlog` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-04-04 21:40:11
