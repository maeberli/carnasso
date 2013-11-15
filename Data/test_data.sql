LOCK TABLES `CarnivalYear` WRITE;
/*!40000 ALTER TABLE `CarnivalYear` DISABLE KEYS */;
INSERT INTO `CarnivalYear` VALUES (1,'Flyer2011.jpg','background2011.jpg',2011);
INSERT INTO `CarnivalYear` VALUES (2,'Flyer2012.jpg','background2012.jpg',2012);
INSERT INTO `CarnivalYear` VALUES (3,'Flyer2013.jpg','background2013.jpg',2013);
INSERT INTO `CarnivalYear` VALUES (4,'Flyer2014.jpg','background2014.jpg',2014);
/*!40000 ALTER TABLE `CarnivalYear` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `Event` WRITE;
/*!40000 ALTER TABLE `Event` DISABLE KEYS */;
INSERT INTO `Event` VALUES (1,'Kinderfasnacht','Die Kinderfasnacht bietet...','2013-01-31','Pausenplatz Schulhause Schützenmatt',2);
INSERT INTO `Event` VALUES (2,'Maskenball','Der winderbare Maskenball.','2013-01-31','Gemeindesaal Schützenmatt, Hirzel',2);
INSERT INTO `Event` VALUES (3,'Ü30','Die Party für alle über 30 jährigen.','2013-01-30','Gemeindesaal Schützenmatt, Hirzel',2);
INSERT INTO `Event` VALUES (4,'Seniorenfasnacht','Der gemütliche Kaffee- und Kuchen-Nachmittag für die Senioren.','2013-01-29','Gemeindesaal Schützenmatt, Hirzel',2);
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
