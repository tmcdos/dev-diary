# HeidiSQL Dump 
#
# --------------------------------------------------------
# Database:             blog
# Server version:       5.5.28-debug
# Server OS:            Linux
# Target-Compatibility: Same as source server (MySQL 5.5.28-debug)
# max_allowed_packet:   25165824
# HeidiSQL version:     3.2 Revision: 1129
# --------------------------------------------------------

/*!40100 SET CHARACTER SET cp1251*/;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0*/;


CREATE TABLE `lister` (
  `ID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `CREATED` datetime NOT NULL,
  `DATUM` date NOT NULL,
  `TIP` tinyint(3) unsigned NOT NULL,
  `BODY` text NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `CREATED` (`CREATED`,`TIP`),
  KEY `DATUM` (`DATUM`),
  FULLTEXT KEY `BODY` (`BODY`)
) ENGINE=MyISAM /*!40100  DEFAULT CHARSET=cp1251*/;

#
# Table structure for table 'type_event'
#

CREATE TABLE `type_event` (
  `ID` tinyint(3) unsigned NOT NULL,
  `TYPE_EVENT` varchar(50) NOT NULL,
  `COLOR` varchar(6) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM /*!40100 DEFAULT CHARSET=cp1251*/;



#
# Dumping data for table 'type_event'
#

LOCK TABLES `type_event` WRITE;
/*!40000 ALTER TABLE `type_event` DISABLE KEYS*/;
INSERT INTO `type_event` (`ID`, `TYPE_EVENT`, `COLOR`) VALUES
	(1,'Bugs','FF5328'),
	(2,'Programming','5F96F4'),
	(3,'Administration - external','E1A4F4'),
	(4,'Administration - office','FFA0AA'),
	(5,'Administration - other','E5BF8E'),
	(6,'Shell scripts','AD9FA2'),
	(7,'Bureaucracy','FFC5AD'),
	(8,'Favours','85BF87'),
	(10,'Training','E5D934'),
	(9,'Others','7DBAC4');
/*!40000 ALTER TABLE `type_event` ENABLE KEYS*/;
UNLOCK TABLES;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS*/;
