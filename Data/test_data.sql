LOCK TABLES `CarnivalYear` WRITE;
/*!40000 ALTER TABLE `CarnivalYear` DISABLE KEYS */;
INSERT INTO `CarnivalYear` VALUES (1,2011,'background2011.jpg','Flyer2011.jpg');
INSERT INTO `CarnivalYear` VALUES (2,2012,'background2012.jpg','Flyer2012.jpg');
INSERT INTO `CarnivalYear` VALUES (3,2013,'background2013.jpg','Flyer2013.jpg');
INSERT INTO `CarnivalYear` VALUES (4,2014,'background2014.jpg','Flyer2014.jpg');
/*!40000 ALTER TABLE `CarnivalYear` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `Event` WRITE;
/*!40000 ALTER TABLE `Event` DISABLE KEYS */;
INSERT INTO `Event` VALUES (1,'Kinderfasnacht','Die Kinderfasnacht bietet...','2013-01-31','12:30','16:00','Pausenplatz Schulhause Schützenmatt',2);
INSERT INTO `Event` VALUES (2,'Maskenball','Der winderbare Maskenball.','2013-01-31','16:30','18:00','Gemeindesaal Schützenmatt, Hirzel',2);
INSERT INTO `Event` VALUES (3,'Ü30','Die Party für alle über 30 jährigen.','2013-01-30','20:30','03:30','Gemeindesaal Schützenmatt, Hirzel',2);
INSERT INTO `Event` VALUES (4,'Seniorenfasnacht','Der gemütliche Kaffee- und Kuchen-Nachmittag für die Senioren.','2013-01-29','20:30','03:30','Gemeindesaal Schützenmatt, Hirzel',2);
/*!40000 ALTER TABLE `Event` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `Member` WRITE;
/*!40000 ALTER TABLE `Member` DISABLE KEYS */;
INSERT INTO `Member` VALUES (1,'Marco','Aeberli','imagePathPhotoAeberli.jpg');
INSERT INTO `Member` VALUES (2,'Christoph','Girsperger','imagePathPhotoGirspergerC.jpg');
INSERT INTO `Member` VALUES (3,'Gabi','Girsperger','imagePathPhotoGirspergerG.jpg');
INSERT INTO `Member` VALUES (4,'Martin','Winkler','imagePathPhotoWinkler.jpg');
/*!40000 ALTER TABLE `Member` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `Organisator` WRITE;
/*!40000 ALTER TABLE `Organisator` DISABLE KEYS */;
INSERT INTO `Organisator` VALUES (1,1,'Hallung',2);
INSERT INTO `Organisator` VALUES (2,4,'Chef',2);
INSERT INTO `Organisator` VALUES (3,2,'Bar, Gastronomie',2);
INSERT INTO `Organisator` VALUES (4,3,'MFA',2);
/*!40000 ALTER TABLE `Organisator` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `StaticPageInfo` WRITE;
/*!40000 ALTER TABLE `StaticPageInfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `StaticPageInfo` ENABLE KEYS */;
UNLOCK TABLES;
