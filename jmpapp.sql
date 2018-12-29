-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: jmp
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.16.04.1

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
-- Table structure for table `jmp_approval`
--

DROP TABLE IF EXISTS `jmp_approval`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jmp_approval` (
  `ap_tr_id` int(10) NOT NULL,
  `ap_ad_name` varchar(50) NOT NULL,
  `ap_sent_time` datetime DEFAULT NULL,
  `ap_status` varchar(15) NOT NULL,
  `ap_insert_time` datetime NOT NULL,
  `ap_approval_time` datetime DEFAULT NULL,
  `ap_comments` text,
  PRIMARY KEY (`ap_tr_id`,`ap_ad_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jmp_approval`
--

LOCK TABLES `jmp_approval` WRITE;
/*!40000 ALTER TABLE `jmp_approval` DISABLE KEYS */;
INSERT INTO `jmp_approval` VALUES (1,'vgiron','2018-11-16 20:33:48','APPROVED','2018-11-16 20:33:48','2018-11-16 20:36:09','APPROVED\nProceed\n<b>vgiron</b> - vgiron@gmail.com\n2018-11-16 20:36:09\n'),(2,'mjoel','2018-11-18 15:07:59','APPROVED','2018-11-18 08:03:07','2018-11-18 15:29:06','APPROVED\n<b>mjoel</b> - mjoel@vodacom.co.tz\n2018-11-18 15:29:06\n'),(3,'mjoel','2018-11-18 16:41:30','APPROVED','2018-11-18 16:41:30','2018-11-18 16:56:49','APPROVED\nProceed\n<b>mjoel</b> - mjoel@vodacom.co.tz\n2018-11-18 16:56:49\n'),(4,'mjoel','2018-11-18 20:11:39','APPROVED','2018-11-18 20:11:39','2018-11-18 20:12:44','APPROVED\nTest\n<b>mjoel</b> - mjoel@vodacom.co.tz\n2018-11-18 20:12:44\n'),(5,'alupembe','2018-11-30 14:11:04','PENDING','2018-11-30 14:11:04',NULL,NULL),(7,'gvenanty','2018-12-08 18:22:29','PENDING','2018-12-08 18:22:29',NULL,NULL),(8,'kalufyaa','2018-12-13 18:39:57','PENDING','2018-12-13 18:39:57',NULL,NULL),(9,'gvenanty','2018-12-14 19:38:53','PENDING','2018-12-14 19:38:53',NULL,NULL);
/*!40000 ALTER TABLE `jmp_approval` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jmp_approval_officials`
--

DROP TABLE IF EXISTS `jmp_approval_officials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jmp_approval_officials` (
  `ao_ad_name` varchar(100) NOT NULL,
  `ao_phone_number` varchar(15) NOT NULL,
  `ao_email` varchar(100) NOT NULL,
  `ao_full_name` varchar(100) NOT NULL,
  `ao_created_on` datetime NOT NULL,
  `ao_title` varchar(250) NOT NULL,
  `ao_department` varchar(250) NOT NULL,
  PRIMARY KEY (`ao_ad_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jmp_approval_officials`
--

LOCK TABLES `jmp_approval_officials` WRITE;
/*!40000 ALTER TABLE `jmp_approval_officials` DISABLE KEYS */;
INSERT INTO `jmp_approval_officials` VALUES ('akbaralia','0754710194','akbaralia@vodacom.co.tz','Ahmed Akabarali','2018-11-29 12:03:44','Acting HOD: Lake Zone','CBU'),('alupembe','0754711144','alupembe@vodacom.co.tz',' Andrew Lupembe','2018-11-29 12:03:44','HOD: Network Operations','CBU'),('amulonga','754711655','amulonga@vodacom.co.tz',' Alec Mulonga','2018-11-29 12:03:44','Director: Network','Network'),('bstephen','0754711163','bstephen@vodacom.co.tz',' Brigita Stephen','2018-11-29 12:03:44','EHOD:Northern Zone','CBU'),('chambuag','0754711469','chambuag@vodacom.co.tz',' Grace Chambua','2018-11-29 12:03:44','EHOD: Central Zone','CBU'),('desmarquestc','754711402','desmarquestc@vodacom.co.tz',' Charles Desmarquest','2018-11-29 12:03:44','HOD: SCM','Finance'),('dmkama','0754710058','dmkama@vodacom.co.tz','Domician Mkama','2018-11-29 12:03:44','EHOD: Lake Zone','CBU'),('fedriani','754711644','fedriani@vodacom.co.t','Fedriani Luis','2018-11-29 12:03:44','Director: IT&Billing','IT & Billing'),('gmagonyozi','754710104','gmagonyozi@vodacom.co.tz',' George Magonyozi','2018-11-29 12:03:44','HOD: Network Engineering','Network'),('gvenanty','0754711233','gvenanty@vodacom.co.tz','George Venanty','2018-11-29 12:03:44','HOD: Coastal Zone','CBU'),('hisham.hendi','0754711092','hisham.hendi@vodacom.co.tz','Hisham Hendi','2018-11-29 12:03:44','Managing Director','MD Executive'),('hkisiwani','0754711192','hkisiwani@vodacom.co.tz','Heladius Kisiwani ','2018-11-29 12:03:44','HOD: Central Zzone','CBU'),('hlwakatare','754711252','hlwakatare@vodacom.co.tz','Harriet Lwakatare ','2018-11-29 12:03:44','Director: Customer Service','Customer Service'),('jacques.marais','746712266','jacques.marais@vodacom.co.tz',' Jacques Marais','2018-11-29 12:03:44','Finance Director','Finance'),('kalufyaa','0754712388','kalufyaa@vodacom.co.tz','Ayubu Kalufya','2018-11-29 12:03:44','HOD: Lake Zone','CBU'),('karen.lwakatare','754710151','karen.lwakatare@vodacom.co.tz',' Karen Lwakatare','2018-11-29 12:03:44','HOD: HSE','Human Resources'),('lkanijo','754711061','lkanijo@vodacom.co.tz','Louis Kanijo','2018-11-29 12:03:44','HOD: Corporate Security','Finance'),('lugatag','0754710050','lugatag@vodacom.co.tz','George Lugata','2018-11-29 12:03:44','HOD: Coastal Zone','CBU'),('macfadyne.minja','0754711174','macfadyne.minja@vodacom.co.tz',' Macfadyne Minja','2018-11-29 12:03:44','EHOD: Southern Zone','CBU'),('mbujaga','754710352','mbujaga@vodacom.co.tz','Michael Bujaga','2018-11-29 12:03:44','Manager: Transport Layer','Network'),('mjoel','754710761','mjoel@vodacom.co.tz',' Matiko Joel','2018-11-29 12:03:44','Manager: Fleet&Facilities','Human Resources'),('mworia','754710661','mworia@vodacom.co.tz',' Rosalynn Mworia','2018-11-29 12:03:44','Director: Corporate Affairs','Corporate Affairs'),('nkamando','754710297','nkamando@vodacom.co.tz',' Nguvu Kamando','2018-11-29 12:03:44','HOD: Netowrk Performance','Network'),('nungwie','0754711213','nungwie@vodacom.co.tz','Ezekiel Nungwi','2018-11-29 12:03:44','HOD: Southern Zone','CBU'),('pedigandon','0754710918','pedigandon@vodacom.co.tz','Nathaneal Pedigando','2018-11-29 12:03:44','Senior Sales Manager: NZ','CBU'),('riwal','0754711367','riwal@vodacom.co.tz','Linda Riwa','2018-12-05 00:00:00','Acting CBU Director','CBU'),('rmwangesi','754711587','rmwangesi@vodacom.co.tz',' Richard Mwangesi','2018-11-29 12:03:44','Manager: IP/PaCo','Network'),('skajembe','0754711003','skajembe@vodacom.co.tz','Kajembe Safia A.','2018-11-29 12:03:44','HOD: CBU Budget Operations','CBU'),('slugendo','754710257','slugendo@vodacom.co.tz','Simon Lugendo ','2018-11-29 12:03:44','Manager: Radio Planning','Network'),('smchau','0754710517','smchau@vodacom.co.tz',' Straton Mchau','2018-11-29 12:03:44','Senior Sales Manager: NZ','CBU'),('vivienne.penessis','754711276','vivienne.penessis@vodacom.co.tz','Vivienne Penessis','2018-11-29 12:03:44','Human Resources Director','Human Resources'),('vmhina','754710044','vmhina@vodacom.co.tz',' Victor Mhina','2018-11-29 12:03:44','Manager: CSOC','Network');
/*!40000 ALTER TABLE `jmp_approval_officials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jmp_attachment`
--

DROP TABLE IF EXISTS `jmp_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jmp_attachment` (
  `att_id` int(10) NOT NULL AUTO_INCREMENT,
  `att_type` varchar(20) NOT NULL,
  `att_name` varchar(255) NOT NULL,
  `att_ref` varchar(255) DEFAULT NULL,
  `att_timestamp` datetime NOT NULL,
  `att_status` tinyint(1) NOT NULL DEFAULT '0',
  `att_og_name` varchar(255) NOT NULL,
  `att_ad_name` varchar(50) NOT NULL,
  PRIMARY KEY (`att_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jmp_attachment`
--

LOCK TABLES `jmp_attachment` WRITE;
/*!40000 ALTER TABLE `jmp_attachment` DISABLE KEYS */;
INSERT INTO `jmp_attachment` VALUES (3,'DRIVER_LICENSE','d40ddb8a6da50c5d4c6f8d97178633ef.jpg','jon','2018-10-24 12:07:34',0,'test','jon'),(4,'DRIVER_LICENSE','c503511a353f5a42b21c01299cbf857c.jpeg','vgiron','2018-10-24 15:02:57',1,'test','vgiron'),(5,'TRIP_REQUEST','b6dda94f593c28970f16e2fecd81927a.jpg','1','2018-11-16 20:32:57',1,'test','evody'),(6,'MEDICAL_FITNESS','23e2d373f5092328ac6867afe6b79ea2.jpg','cayo','2018-11-18 07:54:39',1,'test','cayo'),(7,'DRIVER_LICENSE','ebce3e46e9407c606f7bbb8a8eb3b7b6.jpg','cayo','2018-11-18 07:55:16',1,'test','cayo'),(8,'TRIP_REQUEST','7b9b74fe54e9c66e2df7e624db191db4.jpg','2','2018-11-18 08:02:19',1,'test','cayo'),(9,'TRIP_REQUEST','66a5a6f09fcf3b93980ed004add7a591.jpg','2','2018-11-18 08:02:37',1,'test','cayo'),(11,'MEDICAL_FITNESS','c489221382aac512645e4c16a34f8c62.pdf','mjoel','2018-11-18 15:27:59',1,'test','mjoel'),(12,'DRIVER_LICENSE','a25d16dc355fcac79a149a561fccaaf5.jpeg','mjoel','2018-11-18 15:28:19',1,'test','mjoel'),(13,'TRIP_REQUEST','3c3e7906f6ae88b1da4007d9dd36253a.pdf','3','2018-11-18 16:41:11',1,'test','cayo'),(14,'TRIP_REQUEST','c748154f8fef4e211d97d852ee2dbff1.pdf','4','2018-11-18 20:11:17',1,'test','cayo'),(15,'MEDICAL_FITNESS','219c1988bb6a2c7d6d2bcd79fcd689d2.pdf','marab','2018-11-30 13:28:38',1,'test','marab'),(16,'DRIVER_LICENSE','4750c5bd38541a4306643a4565ec269e.pdf','marab','2018-11-30 13:29:06',1,'test','marab'),(17,'TRIP_REQUEST','ad06ddb43a6c3f898a0bf5a43a3387d3.pdf','5','2018-11-30 14:08:19',1,'test','marab'),(21,'DRIVER_LICENSE','8a44ca51f77a62d9cccc5e2d8a6c3bd3.jpg','bmusabila','2018-12-01 07:55:50',1,'test','bmusabila'),(23,'MEDICAL_FITNESS','362f6e2d46bf9813625b41ec3be69e65.jpg','bstephen','2018-12-05 11:38:49',1,'test','bstephen'),(24,'DRIVER_LICENSE','93e041be48e038cc656df5d7fe9b3001.jpg','bstephen','2018-12-05 11:45:25',1,'test','bstephen'),(25,'DRIVER_LICENSE','86d45dab9b7eba8a486b381a46fddd40.jpg','nyandag01','2018-12-05 15:25:04',1,'test','nyandag01'),(26,'MEDICAL_FITNESS','84ef8df1a31b61b69d8a3192e2fbcad3.jpg','nyandag01','2018-12-05 15:26:22',1,'test','nyandag01'),(27,'TRIP_REQUEST','f26c25b4bedc76dbc66fd3a66cc1b878.jpg','6','2018-12-05 15:37:08',1,'test','nyandag01'),(28,'MEDICAL_FITNESS','ea9a7be0c6af3416503a98de65217764.jpg','nungwie','2018-12-06 14:19:02',0,'test','nungwie'),(29,'DRIVER_LICENSE','840ff07845baba6512f25a6769f24011.jpg','esagenge','2018-12-06 14:31:03',1,'test','esagenge'),(30,'DRIVER_LICENSE','76ce6b27e2908fcafb8d96e20389c732.jpg','cminungu','2018-12-08 18:02:53',1,'test','cminungu'),(31,'TRIP_REQUEST','56dc050f76b36ea765c5b009dd7a492e.jpg','7','2018-12-08 18:04:43',1,'test','cminungu'),(32,'DRIVER_LICENSE','32ff5b9b223d84fe6eddbf3b9b641b5c.jpg','urassao','2018-12-10 20:29:05',1,'test','urassao'),(33,'DRIVER_LICENSE','c6e8e32d94a1018c13a1d5e6f5343ce3.jpg','mchanila','2018-12-13 17:30:51',1,'test','mchanila'),(34,'MEDICAL_FITNESS','e006d0ca234f5e67c52bbe7d7c582e17.jpg','mchanila','2018-12-13 17:32:06',1,'test','mchanila'),(35,'TRIP_REQUEST','27a36954c863dfe873fcd522a0072990.jpg','8','2018-12-13 18:36:41',1,'test','mchanila'),(37,'TRIP_REQUEST','1895ffa8286b37d716edd2054b383fc2.jpg','9','2018-12-14 14:32:55',1,'test','cminungu'),(38,'DRIVER_LICENSE','229d8c2d529b5d8a6a697733332ed363.jpg','lingaf','2018-12-17 20:07:58',1,'test','lingaf'),(39,'DRIVER_LICENSE','e7d73f4684cb29e819d1bbc8bea7a332.jpg','kombeb','2018-12-17 22:34:48',1,'test','kombeb'),(40,'MEDICAL_FITNESS','ab70195f10ba7b87ed29b32720224098.jpg','kombeb','2018-12-17 22:36:08',1,'test','kombeb');
/*!40000 ALTER TABLE `jmp_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jmp_department`
--

DROP TABLE IF EXISTS `jmp_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jmp_department` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) NOT NULL,
  `dept_hod_ad_name` varchar(100) NOT NULL,
  `dept_hod_full_name` varchar(100) NOT NULL,
  `dept_hod_phone` varchar(15) NOT NULL,
  `dept_hod_email` varchar(100) NOT NULL,
  `dept_status` varchar(20) NOT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jmp_department`
--

LOCK TABLES `jmp_department` WRITE;
/*!40000 ALTER TABLE `jmp_department` DISABLE KEYS */;
INSERT INTO `jmp_department` VALUES (1,'IT & BILLING','itbillhod','Itand Bill','255700000001','it@hod.tz','ACTIVE'),(2,'NETWORK','networkhod','Network Hod','255700000002','net@hod.tz','ACTIVE'),(3,'CBU','cbuhod','Cbu Hod','255700000003','cbu@hod.tz','ACTIVE'),(4,'CORPORATE AFFAIRS','corporatehod','Corborate Affairs','255700000004','corp@hod.tz','ACTIVE'),(5,'FINANCE','financehod','Finance Hod','255700000005','fin@hod.tz','ACTIVE'),(6,'HUMAN RESOURCES','humanhod','Human Resources','255700000006','hr@hod.tz','ACTIVE'),(7,'MD EXECUTIVE','mdhod','Md Executive','255700000007','md@hod.tz','ACTIVE'),(8,'CUSTOMER SERVICE','customersv','Customer Service','255700000033','cs@hod.tz','ACTIVE');
/*!40000 ALTER TABLE `jmp_department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jmp_drivers_profile`
--

DROP TABLE IF EXISTS `jmp_drivers_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jmp_drivers_profile` (
  `dp_ad_name` varchar(100) NOT NULL,
  `dp_full_name` varchar(100) NOT NULL,
  `dp_phone_number` varchar(15) NOT NULL,
  `dp_email` varchar(100) NOT NULL,
  `dp_dept_id` int(10) NOT NULL,
  `dp_section_id` int(10) NOT NULL,
  `dp_license_number` varchar(255) NOT NULL,
  `dp_license_expiry` date NOT NULL,
  `dp_created_time` datetime NOT NULL,
  `dp_updated_time` datetime NOT NULL,
  `dp_status` varchar(15) NOT NULL,
  `dp_medical_by_osha` varchar(5) NOT NULL,
  `dp_medical_date` date DEFAULT NULL,
  `dp_ao_ad_name` varchar(50) NOT NULL,
  PRIMARY KEY (`dp_ad_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jmp_drivers_profile`
--

LOCK TABLES `jmp_drivers_profile` WRITE;
/*!40000 ALTER TABLE `jmp_drivers_profile` DISABLE KEYS */;
INSERT INTO `jmp_drivers_profile` VALUES ('bmusabila','Baraka Kusaya Musabila','255754711065','bmusabila@vodacom.co.tz',3,4,'4003318918','2019-02-06','2018-12-01 07:58:01','2018-12-01 07:58:01','PENDING','NO',NULL,'nungwie'),('bstephen','Brigita Stephen','255754711163','bstephen@vodacom.co.tz',3,6,'4000040193','2020-04-09','2018-12-05 11:46:05','2018-12-05 11:46:05','PENDING','YES','2018-08-05','hisham.hendi'),('cayo','Cayo T','255754710929','torgenes@gmail.com',6,13,'414141414141','2020-11-18','2018-11-18 07:55:18','2018-11-25 06:30:25','PENDING','YES','2018-11-18','mjoel'),('cminungu','Charles selestine minungu','255754711212','cminungu@vodacom.co.tz',3,5,'4000464073','2021-02-18','2018-12-08 18:03:08','2018-12-08 18:03:08','PENDING','NO',NULL,'gvenanty'),('esagenge','Emanuel Sagenge','255754711606','esagenge@vodacom.co.tz',3,4,'4000175727','2020-06-06','2018-12-06 14:31:06','2018-12-06 14:31:06','PENDING','NO',NULL,'nungwie'),('evody','Evody Kibiki','255576531482','evody@noxyt.com',2,2,'401010888','2020-09-21','2018-09-21 11:34:21','2018-10-22 15:09:22','APPROVED','YES','2018-10-21','vgiron'),('Gerald','Gerald Sanga','255764112233','Gerald@noxyt.com',2,2,'400012365','2020-10-15','2018-10-15 09:49:15','2018-10-15 09:49:15','PENDING','',NULL,''),('gerry','Gerald sanga','255075543217','sanga@g.com',2,2,'40000057','2020-10-23','2018-10-23 04:56:23','2018-10-23 05:18:23','PENDING','YES','2018-10-16','vgiron'),('issa','Izzo Bussiness','255755100205','issa@noxyt.com',1,1,'400001234','2020-08-10','2018-10-08 09:39:08','2018-10-08 09:39:08','PENDING','',NULL,''),('james','James Tupatupazz','255755406677','james@noxyt.com',2,2,'400007777','2021-12-21','2018-09-21 09:19:21','2018-09-21 11:33:21','PENDING','',NULL,''),('John','John doe','255764125451','john@vodacom.co.tz',2,2,'400084512','2020-10-19','2018-10-15 10:24:15','2018-10-15 10:24:15','PENDING','',NULL,''),('kombeb','Bernard Kombe','255754710491','kombeb@vodacom.co.tz',3,3,'4000794931','2021-07-16','2018-12-17 22:36:17','2018-12-17 22:36:17','PENDING','YES','2017-12-13','hkisiwani'),('lingaf','Fadhil Linga','255754711285','lingaf@vodacom.co.tz',3,6,'4003968221','2019-10-10','2018-12-17 20:08:17','2018-12-17 20:08:17','PENDING','NO',NULL,'smchau'),('marab','Benedict Ng\'adi Mara','255754710130','marab@vodacom.co.tz',2,15,'4002379989','2020-08-03','2018-11-30 13:31:30','2018-11-30 13:31:30','PENDING','YES','2018-02-02','alupembe'),('mchanila','MOHAMED CHANILA','255754711188','mchanila@vodacom.co.tz',3,5,'4000275548','2020-10-26','2018-12-13 17:32:13','2018-12-13 17:32:13','PENDING','YES','2018-08-13','kalufyaa'),('mike','Mike Sanga','255764192010','michel.sanga@noxyt.com',1,1,'4000061781','2022-10-24','2018-10-24 07:00:24','2018-10-24 07:00:24','APPROVED','YES','2018-10-20','vgiron'),('nyandag01','George Malimi Nyanda','255754710500','nyandag01@vodacom.co.tz',3,2,'4002461749','2020-09-15','2018-12-05 15:26:05','2018-12-05 15:26:05','PENDING','YES','2017-08-05','kalufyaa'),('sanga','Michel Sanga','255764192010','michel.sanga@noxyt.com',1,1,'40001234','2019-03-30','2018-09-11 00:00:00','2018-09-11 00:00:00','PENDING','',NULL,''),('urassao','Ombeni urassa','255754711293','urassao@vodacom.co.tz',3,6,'4003957265','2019-10-27','2018-12-10 20:29:10','2018-12-10 20:29:10','PENDING','NO',NULL,'smchau'),('vgiron','Val Giron','255764102010','vgiron@vodacom.co.tz',2,2,'1234','2020-10-24','2018-10-24 15:02:24','2018-10-24 15:02:24','PENDING','NO',NULL,'vgiron');
/*!40000 ALTER TABLE `jmp_drivers_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jmp_email`
--

DROP TABLE IF EXISTS `jmp_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jmp_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_to` text NOT NULL,
  `cc` text,
  `_from` text NOT NULL,
  `subject` text NOT NULL,
  `email` text NOT NULL,
  `attachments` text,
  `_status` varchar(50) NOT NULL DEFAULT 'RECORDED',
  `record_date` datetime NOT NULL,
  `type` varchar(150) NOT NULL DEFAULT 'NOTIFICATION',
  `jo_id` varchar(150) DEFAULT NULL,
  `sent_date` datetime DEFAULT NULL,
  `last_update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `proc_st` varchar(150) DEFAULT NULL,
  `proc_status_nt` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jmp_email`
--

LOCK TABLES `jmp_email` WRITE;
/*!40000 ALTER TABLE `jmp_email` DISABLE KEYS */;
/*!40000 ALTER TABLE `jmp_email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jmp_firebase_tokens`
--

DROP TABLE IF EXISTS `jmp_firebase_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jmp_firebase_tokens` (
  `ft_id` int(20) NOT NULL AUTO_INCREMENT,
  `ft_user_id` varchar(255) NOT NULL,
  `ft_token` text NOT NULL,
  `ft_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ft_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jmp_firebase_tokens`
--

LOCK TABLES `jmp_firebase_tokens` WRITE;
/*!40000 ALTER TABLE `jmp_firebase_tokens` DISABLE KEYS */;
INSERT INTO `jmp_firebase_tokens` VALUES (13,'vgiron','cYFdi09p5Uk:APA91bFQ_f3iVhaZ8am6QSXEA3cMWzkcQouMElcwAlZ9OrrxTr7QaM7zSv0b_RK8TxXJVWsmNL56NxZ1hxNgxfz6n2zA0MxWIk9qHKace-e2jTqTq1W6y9FQAZWDKbrP2jX9fHdDMjFI','2018-11-16 11:48:12'),(20,'mjoel','drOuey5QwYY:APA91bGLtDMMUf-GgTNBSNHRta-RuBYFVtXoR15P-IyaIkuh0wyYkDHqnjsQcy9xTUu58ivYuOPXa3rqWo8G_DaG5yCPB4dRyK_m-6kEMTZpN4xltSWnOraU5md5RDU0mOq18lskoNt8','2018-11-18 13:56:01'),(21,'cayo','fELYZIs8YN0:APA91bFM23wULYTSVkmNmWNpdBWBVIPWzsuqE5khgKCtpGhcF-zi3VQFwr1RAxM08qKuwxUnuR58S6A2WCEsxMQL27tQ98YFatW43EKIqOlJi-9CmBIyC0LlX9GS4y-kwl82lJM50Bu7','2018-11-18 16:52:55'),(22,'mjoel','dvWn2F8PZ3s:APA91bGYB74ak3CKOs-lOiNhkAVEWQva3NRrjALX3AZ-cbhY5b9o8rQ_r7CMt8z70Ek9L0bcDEESgr2wcVtJjcnWjSV3haJtwbxbl9uoSOkWsftcvc1_9xvIuOtx0NuQByb0s7U47yVu','2018-11-18 17:08:59'),(23,'mjoel','e4ioLZ6-KXk:APA91bEGWOt9QfqoU2s8NjYXfUiLv4_Rc-viUux2U5EDJvAwPhCRY1OqbXz_m_PxFHDzHb1ReE4U8IWhdZQLVD3c4BxqQAyU9Cs-4z3etka71DDmxk1Rg-gt1YqKoO01oChELhDe-BP2','2018-11-19 08:24:37'),(24,'mawalai@vodacom.co.tz','cW9XPTsfNUw:APA91bF9K3bRTZMMplnUP96qM4djxQdVWqET_ltssuWJQeS4pxljNzDSR3hcwhWLkIFKKgsAk3bFkQkIq54s03--FiYwkNZSdYCmlTLYZS_0_q2AfUu5A17H5-HqfyK51OAK-Y7KsErT','2018-11-22 13:29:37'),(25,'marab','efD7psfUv38:APA91bHuJGLa2HnUlcuj31X88IO9pRw50iqhl8ByM0so_S65Cc703rNm71lbK-xbO_ZAJKWzPfEHHAzFM4qoP1iHRIqlkFcfV8OtcGv0BywJPIvs1a58yKDsexMYRCUtfVec--hNiMdA','2018-11-22 13:31:37'),(26,'jikate@vodacom.co.tz','dEhFwp_On0k:APA91bGy34Y1lYx7-hPSUbodogVbLU3EvOmUeahg-kFX9KDTQVQUtxsGNsp6eoMsfAY-fGun_-67k82z8SnJrDL7H-uiswkjmd61Agshtp_poqC__VAY5hVZOuhlxN7ee6zh4KdVUWTd','2018-11-22 13:33:11'),(27,'esagenge@vodacom.co.tz','fenapZdKNF4:APA91bFB9KQkcD-ihM8CsG6NEvMNtKFr7SylhcR8K5JPuUP5wE84Fj0yKNRhsP9caPJAHjMzunf37WoZT5l6od7Z-uvggV04lxcB2FNRsw4l37oRfzLJhHdzfe-l_q52wVJdAIaW97P9','2018-11-22 13:35:31'),(29,'amris','cJp3YxumfiE:APA91bGCe72335gHCStPLmUfudUmKM94LP0dQo9FTD0nZQQaRQuiFYcV5o0p4QCgy05SdSStdl-B0itSkYJuNy_7TyTXKjJGAqEf725KDQEO6sn8NeeKGrn2THqIVZA4rxnxNnj8CtvZ','2018-11-22 14:28:53'),(30,'kilumangao','egooxd6hO0I:APA91bEu6niFrKjHOSPc3Mz6LOpXiwsMWd-3B8AwpzEFEreeuMNQbhduQ9GlhV_Q1pcV3skkC8TXZJRFrMNZzAV-r__Ppjpfr7xD_HfMpvlwJ66TH8wfyx-cJ1c_uZUQnkXXdKZckqRz','2018-11-22 14:49:43'),(31,'amariki','defYC45Ihuc:APA91bG3cCKH6NhFLMY-cfcavyBpupGntBjxLSOUTaotkd-a35tM9Ju52TNARbNhyL2ENCupYMclYFGcbQWbYxXKVYcn5VpLDa6tHOAqAWO7eBpWh3iptTYSu7gaQYwtKvpHNLS7Sr_S','2018-11-22 15:14:14'),(33,'mmurugwa','d-V_WxOS2s8:APA91bG736pJewpRRwXhvn9kJQad1htffnskWynUtHnMfOTMpAE2RlrCiboaJclmFHxZV2vHfkrBlNAh9Rz81KgTa9C4Z6GHb_btGAwpRux-_eNR7yXvFHat0kIjfwfS3-Ga75ssp1tB','2018-11-22 15:25:30'),(34,'bmusabila','c8e8kK2Wy3Q:APA91bHAM_7TamAZbZyYtWRAVCCtp7Mo8fPOkULlu6r5qsBrId87-shHTBbWWFBjl32hlZbfa6ttC0ZC-KZyJqulIYs8jl1jBeo6L2kZ4YRHNwPiOg49HOEbsqQ-017SxFWLgk8vi-AT','2018-11-22 15:31:33'),(35,'kalufyaa@vodacom.co.tz','fN6xjCrhyf4:APA91bFrZNAbX639g8yhmuH5LA8Fv3Xt1KkpteHO5VZOWpW84Ra3pauGDx5ioWrZAceSfqccgdkaQEwpAqPwyWnoGJdr1eRahc8oYsb5e9CAmggOonhR6HR35rj9HWsHQ1XWDW4CsXWM','2018-11-22 18:26:29'),(36,'amwenisongole','d2Z1pUYrjAU:APA91bHAiw1htiPEBJPOz00yIUYWTzP88IsPDMf_yV2GYIi84ycPYLqyehwuv36mNQGawJnRuqnNG8Sr5N37IIn6fcEBmTUZKZPBos6nRU4-N7H3GDJ2MNjZOQmUUz5n_OMC5NRuClBl','2018-11-22 18:40:19'),(37,'nyandag01','eRrVzlpYOuE:APA91bF6B_YZGoiEoNmoYim3XoWPFdrw3JMNJJpKmk3Fqw7Zh1A6w5vG36Vpiy4ONCbvk1DV8fQPJ8SQct5M5SyfA_05-xxK3g0HVamTXFEBl-Gt9890jPlnb3opKyrgpOGke2uVxgJF','2018-11-22 19:18:16'),(39,'urassao','coX_3d_fcB0:APA91bFhJr0pS3n1EIuwzRnP-rTvZDOBI-RizE5A3qTgtlJfWrURUmsTZRpE8K0ypqz0zIC6Gjfz1JKKrP40lzwTVnNogTGY3juDuYoythQOSH9w0v17oWpphOecSxFyG_HqbJH7CJ_P','2018-11-23 04:56:03'),(40,'lugatag@vodacom.co.tz','fHY1Sv_aS0s:APA91bH_wx5mEI4xiDk48A9UHpLO9JIZbcQejlU-6SmzgPTdTKIBl0H5-DnKQ-xz2jfxQMU4mIDjHUCcu9ZJK80cpTJPEQeJtrh5W9x8Ol6brDVvwQl9hteUJzwG0KBFSQvowfb3C4Rl','2018-11-23 06:32:28'),(41,'ymngagi','eagK_enon_g:APA91bGHwR76ZZWJXmEBHS8KEV3ZO1mtX9Hn2YwT0c7-FsvciDESM8q3WbX3WnrPi6odqOHA2Z0BNz9yC-iQJv6DnkVywTlhHhsDct9L4PRMY1-yjoqLePgHVDX65eaencNhJph6TdiY','2018-11-23 08:16:48'),(42,'cminungu','cjnE4-_eASQ:APA91bFmWu1wQ3LGaJXArz-ud9x-rVDL5eoR9lRq03KJpp3vAdtOERZLVTJXZPPUsaldp-5MfM66fMz2yv4OUgozSV_8flLuiXRLKH3lhfbnIqSLOvk-Eea37iPyyFpDSOUH82T_-JhW','2018-11-23 08:53:55'),(43,'mjoel','cUT0giIirh4:APA91bH7Twem7ABuhitgNIQpXYTdOpoJb0AQlzZ4yEQ5-ZikDw2lCdxY3jAodxL8McSzr6RHTjOpxD-WaF9oFFc4pGMJodPSZiqU57kfjPNBJ5pkhGtlHOWBBbkxc3I1AeYQ7w_NTryz','2018-11-23 09:14:09'),(45,'gmtesha','ercFuce_Z3s:APA91bF66gmDnTSzQbV6iSXPPbg_W5SmLOoAYbqVugIbHmM84dpZJ37rW6j4trkF65BAz8UD6e61asK5WJIeCdokUaFehif4z6DKa1fRvSzfekT37urDW1QAhXqu_bYUOJQlWQIgugNd','2018-11-23 16:48:46'),(46,'kombeb','eN9HEO8xOzI:APA91bETcqf8DaSh3Yl6XIUxZM5-mU5BKp5g-OJB29dhXOidEcbWe5caU5HUTMeBt87GyL8mDv70Pyn9ktjC9tJu3LlQgDa7urLNIWoTZh5Q1rrlwD9tBf6se8Z4l0ezVareXd3oYkAR','2018-11-23 22:10:08'),(47,'lkatamba','c-iwZSneLng:APA91bGBKf7bx1dXlvhOP_WIQGW3X3O4b4HkmBla38XMjY--fIE2JINIyDMP-tJCniMA0dOVCWArHX1jmMKX3cOj1co_aDotrXLj-BqqzGuFV_FhEnxQPMwtfB9jAL0j86fE8mSFuPsY','2018-11-24 12:31:45'),(48,'cayo','eJfVcQtr0gg:APA91bFvNLTpP_dGsYZSzdh_BiS6nzCmG-y9iVZbvl4bogaVh67f-N25oa4W1dpEfj_fUdlaHZqLo34ROYw5mZHqMDzChCyrIXU-kS22Let2lAZeg46RcN01oAcYEqfiKp00ecB97L5A','2018-11-24 15:12:43'),(50,'fkamazima','e8EKVR3kMdo:APA91bErulxJGwujCOtuSRqEggOtXDlNZKAyWuPh5GV7L4t9V0xC9Batvjq0N0OLbHOEDkKKJ08s88kPfjbM6gsBflKT0KcloBaRPGZtaVmMVI6zLa_vB8qh8FoAJjErgKQKr_cbyoNn','2018-11-27 16:58:50'),(51,'mchanila','c5lS9UvXcFs:APA91bHBF9pwtJVIO_YuUrLSPnZ8quD3BxYAOKGfYkyJ1elh1T2TBaUMvPEW6WxBc6XEV-HyHGVmCq1V1epVM6-zKY_GE1tiHLFHpgPuAFYr2EVTjaRqIx-cOl-SezjUJ1Oh6xiziCi9','2018-11-28 04:35:21'),(52,'rmbogoma@vodacom.co.tz','f0oPYjbKOx0:APA91bHVo9Ply6-AbD1Vny2b0kDJ1vzSisX8QHC2EMDOtZBDm-R850GYa8RQ2sjUMNPE-SALNDmFXBT5hUuN9dhFKIZunWRxtl7Ol_W3eVoAwP5vhCMK8nfkLF1YruVPb9WN-xil56oz','2018-11-28 13:11:36'),(53,'abillae','ePvmglircsQ:APA91bGjbpqQnk0LinN40VVcRZuhVaBdxK8M1k5r4XhjHawgBk4Vq2WbL553yAx4xZ1eUuPyBmw2vlGIKq_TMnMy4ywKpP8u90R69uyXdngxyB71TrdHFwPT47kHYCMvJLr2EhzqLxtR','2018-11-29 08:12:55'),(54,'theonast','d6DnMVjv6lI:APA91bFXO477-9ALqP1mcVDGPLvUV5kx7W-pL547gzxIXgNShm4yUWHx3BOA04SdGZScibVxDLY5eHVzo3YsKWVSQSp0p07Fun1hlYCLT0a3Zfu6x6nDuY5x-44ny6VKxZdC2VZBgreI','2018-11-29 18:53:53'),(55,'kajerib@vodacom.co.tz','d_w47rotvfo:APA91bGjQiRMZKl7vNZaqZoUVHXOFE16q1L9-hKybzq8PopIoD4yUfqRXBSVc-7eQPNAmJ2sIBDHXDF_JUgT4M5P-k1SfClvzQ3m4kmqPDRnpuKbMEgLqdlRtuJ4n5uM5-r5c6Tg9wqQ','2018-12-03 11:34:34'),(56,'bstephen','fHTqzRSLbc8:APA91bEuI_PGaLxu-HnE5dZYSoxcn9IfPb36zzk9_3jRCWClqTLLQerrC4PdzhXZ2LiS9lhXc-RD1MXb8-JAjd3fbuUnRhSxt3UvVcis6m-iG7omGjiH3DpEaKzGjW8QDbRb0pFB8g--','2018-12-04 04:55:11'),(57,'smchau','efA9fDgA4Mk:APA91bHMLNcv2F3aWICIc7ddhp-6kT0a2D0H6Ofx9PBOmbNSGt3v_I2nvWfUTwlWQtk2p0ZT0CNG-coGdADblGex0iL_uDSGiM3P0FvbIIqudkeBlYpAzckhzuQk0-coLJl_3v601uzJ','2018-12-04 09:19:13'),(60,'nungwie','fY0h6wX_NXM:APA91bEpfCxNAwtEgeKtRkZ-3sKyx8lP6iAvXRvkA-PC3tWUpPfzGOLlDl6VLgvVeOzQmZXDyaqNw1QFrdgnFH67A_vwu3NBeA9EOm1B55DxeN_rVLcDQru6FiQkHfX0DW28tma-jL4l','2018-12-06 11:10:42'),(61,'mwinyihatibum@vodacom.co.tz','df3b3cq0bI4:APA91bEDiv-yUc5TX6fKes-2XCUV42RuyQZxNKQ2aLWLDhAOjL8VSEfDU06jg0Ch3bW39b86j7_NVVnpwyCicths-N3DZhLbsekUcD3QnnwyS763zZuj0woCAmhv-bHGCaFelwVwSEwZ','2018-12-06 11:34:41'),(62,'esagenge','c8FRMASDbHg:APA91bFRp6wCzrH9frcapqvKUpAulvLgCuQO7J_0ndjIjhgJnf-R_KHNVZQ48U_qOl0U4Hbn9tyNjDSV0FPVU1f2V2xZzuhIJABmyFufC8YZtHlOHtj7Q98UFEJbP8P0JeTbNjIAzkWt','2018-12-09 06:11:07'),(63,'urassao','ceLpaHc-NNQ:APA91bH7ICBOGiwSI5DqR-mDnvuTc54rG4A6s-mW6pkF4E1Gyjy7se2vqTVFJX50Y_J5i1oYkgTaZBWvjo0dp6dXyezeWcVRHfau-gfjoIQ3iDqo5o-H1gKIKYRKY80pU0D4GzF1T6ss','2018-12-10 16:44:32'),(64,'atemu@vodacom.co.tz','fO1vhxU2Sx8:APA91bFn3joIgPuKkjCSCS8n0vKMFaSCq5A1fUCAOjuRVrLE3QTBhYWszoNuVxpYO3ziLqFWQbkD8FpjYBK_4HQe1ghxVK9EcI-NEkkbSq19FAYsCYAYVazVCOn1th6x6dQnQNXAEWS_','2018-12-11 08:09:21'),(66,'amris','eYwHLO8Iin8:APA91bF3wSySTP59c8RS7B9gbsibN3kVFd2x70phHPPo31RqKbG7FgXnD72cNqD87sUmkA6LGFFpNLfgimPJDbW5Tqfw5xM_EWjMX3gNTUO3IwjqpbO9R_uHFw7OtsQPMRU-CSJhzXJo','2018-12-13 16:41:00'),(67,'sademba','d9oRp9UxfoM:APA91bEqEK4RsYyeHgDIc-TWVxUs-8wF4CrYGMvWj-JQJ9DHZEe8hvFDwADefcWwbBkbxqwBiCi3HAVAG7ZrjWqtbCTrZ_I58PRxKqt-2U5YhH7_W5QGHmw5fea1U50JIsPrZhI_PC8p','2018-12-14 06:45:56'),(68,'pchinyama','eyzqnnkkyEc:APA91bHTHW3dbVw3pwlEsLYH_CYVuiSE6-zRZSQgc2UBCXrgKa8WQXN3Ada4lppuy84CPqaUOcoVFheS8FBISaDZPNRWkBPwHzKb_mh-ESh38vgE5Efx_IPHPIQ41MH4l_7h2YgnxefV','2018-12-16 14:13:21'),(69,'lingaf','czZKZ45WvGg:APA91bHp20NheeJ5yJlQ5vVpiC7oBzvePY45346jlxUrItuIOrqonJQw9WZ4LC8CvXjjR_GeAbOT2CZkIqOH0aIJoQ2mTnY2FSVvANjj_ETnlz9W_YeXewxIzROXc19WaBz4X6a2Soei','2018-12-17 17:03:25');
/*!40000 ALTER TABLE `jmp_firebase_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jmp_section`
--

DROP TABLE IF EXISTS `jmp_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jmp_section` (
  `sec_id` int(10) NOT NULL AUTO_INCREMENT,
  `sec_name` varchar(100) NOT NULL,
  `sec_dept_id` int(10) NOT NULL,
  `sec_tl_full_name` varchar(100) NOT NULL,
  `sec_tl_ad_name` varchar(100) NOT NULL,
  `sec_tl_phone_number` varchar(15) NOT NULL,
  `sec_tl_email` varchar(100) NOT NULL,
  PRIMARY KEY (`sec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jmp_section`
--

LOCK TABLES `jmp_section` WRITE;
/*!40000 ALTER TABLE `jmp_section` DISABLE KEYS */;
INSERT INTO `jmp_section` VALUES (1,'MD EXECUTIVE',7,'Md Executive','manmd','255700000010','manmd@man.tz'),(2,'BUDGET OPERATIONS',3,'Budget Operations','budgetop','255700000011','manbo@man.tz'),(3,'CENTRAL ZONE',3,'Central Zone','centralzn','255700000012','mancz@man.tz'),(4,'SOUTHERN ZONE',3,'Southern Zone','southernzn','255700000013','mansz@man.tz'),(5,'COASTAL ZONE',3,'Central Zone','centralzn','2557000014','mancz@man.tz'),(6,'NORTHERN ZONE',3,'Nothern Zone','nothernzn','255700000015','mannz@man.tz'),(7,'CORPORATE AFFAIRS',4,'Corporate Affairs','corporatea','255700000016','manca@man.tz'),(8,'CORPORATE SECURITY',5,'Corporate Security','corporates','2557000017','mancs@man.tz'),(9,'SCM',5,'Scm','scm','255700000018','mansc@man.tz'),(10,'FINANCE',5,'Finance','finance','255700000019','manfn@man.tz'),(11,'HUMAN RESOURCES',6,'Human Resources','humanr','255700000020','manhr@man.tz'),(12,'HSE',6,'Hse','hse','255700000021','manhs@man.tz'),(13,'FLEET & FACILITIES',6,'Fleet Facilities','fleetf','255700000022','manff@man.tz'),(14,'IT & BILLING',1,'IT Billing','itb','255700000023','manib@man.tz'),(15,'NETWORK',2,'Network','network','255700000025','mannt@man.tz'),(16,'NETWORK ENGINEERING',2,'Network Engineering','neteng','255700000026','manne@man.tz'),(17,'TRANSPORT LAYER',2,'Transport Layer','transportl','255700000027','mantl@man.tz'),(18,'RADIO PLANNING',2,'Radio Planning','radionpl','255700000028','manrp@man.tz'),(19,'NETWORK PERFORMANCE',2,'Network Performance','netpf','255700000029','mannp@man.tz'),(20,'CSOC',2,'Csoc','csoc','255700000030','mancs@man.tz'),(21,'IP/PACO',2,'Ip Paco','ippaco','255700000031','manip@man.tz'),(22,'CUSTOMER SERVICE',8,'Customer Service','customers','255700000034','mancs@man.tz');
/*!40000 ALTER TABLE `jmp_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jmp_settings`
--

DROP TABLE IF EXISTS `jmp_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jmp_settings` (
  `st_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_name` varchar(120) NOT NULL,
  `st_value` text NOT NULL,
  `st_label` varchar(150) NOT NULL,
  `st_comment` text NOT NULL,
  `st_type` tinyint(1) NOT NULL,
  PRIMARY KEY (`st_id`),
  UNIQUE KEY `st_name` (`st_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jmp_settings`
--

LOCK TABLES `jmp_settings` WRITE;
/*!40000 ALTER TABLE `jmp_settings` DISABLE KEYS */;
INSERT INTO `jmp_settings` VALUES (1,'CURRENT_APP_VERSION_ANDROID','0.0.3','Published App Version','The version of the app that is published in mobile stores (iOS/Android)',0),(2,'CURRENT_APP_VERSION_IOS','0.0.1','Published App Version','The version of the app that is published in mobile stores (iOS/Android)',0);
/*!40000 ALTER TABLE `jmp_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jmp_sms`
--

DROP TABLE IF EXISTS `jmp_sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jmp_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(120) NOT NULL,
  `_from` varchar(120) NOT NULL DEFAULT '123',
  `sms_text` text NOT NULL,
  `_status` varchar(120) NOT NULL DEFAULT 'RECORDED',
  `record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `proc_st` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jmp_sms`
--

LOCK TABLES `jmp_sms` WRITE;
/*!40000 ALTER TABLE `jmp_sms` DISABLE KEYS */;
/*!40000 ALTER TABLE `jmp_sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jmp_trip_request`
--

DROP TABLE IF EXISTS `jmp_trip_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jmp_trip_request` (
  `tr_id` int(10) NOT NULL AUTO_INCREMENT,
  `tr_ad_name` varchar(50) NOT NULL,
  `tr_journey_purpose` text NOT NULL,
  `tr_vehicle_reg_no` varchar(50) NOT NULL,
  `tr_medical_by_osha` enum('YES','NO') NOT NULL,
  `tr_reason_finish_after_17` text,
  `tr_work_finish_time` enum('YES','NO') NOT NULL,
  `tr_vehicle_type` varchar(50) NOT NULL,
  `tr_difense_driver_training` enum('YES','NO') NOT NULL,
  `tr_for_by_for_training` enum('YES','NO') NOT NULL,
  `tr_suitable_license` enum('YES','NO') NOT NULL,
  `tr_fit_for_use` enum('YES','NO') NOT NULL,
  `tr_dispatch_time` datetime NOT NULL,
  `tr_arraival_time` datetime NOT NULL,
  `tr_departure_location` varchar(255) NOT NULL,
  `tr_destination_location` varchar(255) NOT NULL,
  `tr_stop_locations` text NOT NULL,
  `tr_distance` int(10) NOT NULL,
  `tr_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tr_status` enum('NEW','PENDING','INPROGRESS','APPROVED','DISAPPROVED','') NOT NULL,
  PRIMARY KEY (`tr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jmp_trip_request`
--

LOCK TABLES `jmp_trip_request` WRITE;
/*!40000 ALTER TABLE `jmp_trip_request` DISABLE KEYS */;
INSERT INTO `jmp_trip_request` VALUES (1,'evody','Meeting','TA321','YES','','NO','FORTUNER','YES','YES','YES','YES','2018-11-17 09:37:00','2018-11-17 20:33:00','Dar','Dom','',200,'2018-11-16 17:33:26','APPROVED'),(2,'cayo','Site visit','T127CTS','YES','','NO','HILUX','YES','YES','YES','YES','2018-11-20 08:01:00','2018-11-21 08:01:00','Dar es salaam','Kigoma','Dodoma',200,'2018-11-18 05:02:41','APPROVED'),(3,'cayo','Agm meeting with share holders','54TTA','YES','','NO','HILUX','YES','YES','YES','YES','2018-11-20 09:40:00','2018-11-20 16:40:00','Dar','Dom','Moro',200,'2018-11-18 13:41:14','APPROVED'),(4,'cayo','Htt site visit','T123','YES','','NO','HILUX','YES','YES','YES','YES','2018-11-19 10:10:00','2018-11-19 21:10:00','Dar','Dom','',200,'2018-11-18 17:11:22','APPROVED'),(5,'marab','Travelling to Geita for attending joint meeting with RAS Geita and Landlord for Kafita Ucsaf','T 972 DJS','YES','','NO','HILUX','YES','YES','YES','YES','2018-12-04 08:00:00','2018-12-04 11:00:00','Mwanza','Mwanza','Busisi for ferry jam',250,'2018-11-30 11:08:31','PENDING'),(6,'nyandag01','Trade visit','T394DHE','YES','Will finish after 17h00 as sunset in my market is at 19h00','YES','HILUX','YES','YES','YES','YES','2018-12-05 15:28:00','2018-12-06 00:28:00','Kayanga','Karagwe','Visiting M- Pesa agents',160,'2018-12-05 12:37:13','NEW'),(7,'cminungu','Driving to Dar','T432DJD','NO','','NO','HILUX','YES','YES','YES','YES','2018-12-09 18:08:00','2018-12-09 18:20:00','Mtwara','Dar es salaam','',600,'2018-12-08 15:22:04','PENDING'),(8,'mchanila','Business','T151DKF','YES','1700','YES','HILUX','YES','YES','YES','YES','2018-12-14 18:00:00','2018-12-14 21:35:00','Tabora','Kahama','Kahama',460,'2018-12-13 15:38:49','PENDING'),(9,'cminungu','Retuning to Mtwara from Dar es salaam','T432DJD','NO','','NO','HILUX','YES','YES','YES','YES','2018-12-15 08:30:00','2018-12-15 21:30:00','Dar es salaam','Mtwara town','',600,'2018-12-14 11:33:08','PENDING');
/*!40000 ALTER TABLE `jmp_trip_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jmp_user_sessions`
--

DROP TABLE IF EXISTS `jmp_user_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jmp_user_sessions` (
  `us_ad_name` varchar(50) NOT NULL,
  `us_token` varchar(40) NOT NULL,
  `us_timestamp` datetime NOT NULL,
  PRIMARY KEY (`us_ad_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jmp_user_sessions`
--

LOCK TABLES `jmp_user_sessions` WRITE;
/*!40000 ALTER TABLE `jmp_user_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `jmp_user_sessions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-19 10:36:10
