use trofeoslobo;

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (21,'Copa',1),(22,'Figura',1),(23,'Futbol',1),(24,'Basket',1),(25,'Baseball',1),(26,'Cine',1),(27,'Teatro',1),(28,'Tennis',1),(29,'Columna',1),(30,'Piezas de Madera',1);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `colores`
--

LOCK TABLES `colores` WRITE;
/*!40000 ALTER TABLE `colores` DISABLE KEYS */;
INSERT INTO `colores` VALUES (18,'Cafe Chocolate',1),(19,'Negro',1),(20,'Blanco',1),(21,'Nogal',1),(22,'Verde Marmoleado',1),(23,'Gris Nuevo',1),(24,'Roja',1),(25,'Azul',1),(26,'Cafe Caoba',1),(27,'Oro',1),(28,'Plata',1),(29,'Cobre',1),(30,'Oro Metalico',1),(31,'Turin',1),(33,'Blanco perlado',1);
/*!40000 ALTER TABLE `colores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `materiales`
--

LOCK TABLES `materiales` WRITE;
/*!40000 ALTER TABLE `materiales` DISABLE KEYS */;
INSERT INTO `materiales` VALUES (19,'Madera',1),(24,'Resina',1),(25,'Vidrio',1),(26,'Metal',1),(27,'Aluminio',1),(28,'Plastico',1);
/*!40000 ALTER TABLE `materiales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `elementos`
--

LOCK TABLES `elementos` WRITE;
/*!40000 ALTER TABLE `elementos` DISABLE KEYS */;
INSERT INTO `elementos` VALUES (88,'Copa Globo Alumino','Copa Globo Aluminio',200,28,1,19,1),(89,'Figura','Figura Metalica',200,29,2,24,1),(91,'Copa Aro Alumino','Copa Metalica',100,28,3,26,1),(92,'Columna Gringa','Columna de Aluminio moldeado',50,30,2,27,1),(119,'Figura 3D','Figura de Resina',NULL,27,1,24,1),(120,'Madera','Base de madera de 15cm x 8cm',NULL,18,3,19,1),(121,'Madera','Base de madera de 28 cm',NULL,18,2,19,1);
/*!40000 ALTER TABLE `elementos` ENABLE KEYS */;
UNLOCK TABLES;



--
-- Dumping data for table `tiposMedidas`
--

LOCK TABLES `tiposMedidas` WRITE;
/*!40000 ALTER TABLE `tiposMedidas` DISABLE KEYS */;
INSERT INTO `tiposMedidas` VALUES (5,'15 cm x 8 cm',1),(6,'28 cm x 12 cm',1);
/*!40000 ALTER TABLE `tiposMedidas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `trofeos`
--

LOCK TABLES `trofeos` WRITE;
/*!40000 ALTER TABLE `trofeos` DISABLE KEYS */;
INSERT INTO `trofeos` VALUES (7,'TT-01','trofeo tradicional',200,'/img/TT1.jpg',1),(8,'TT-02','trofeo tradicional',150,'/img/TT1.png',1),(10,'Mini Oscar','oscar',250,'/img/Oscar.png',1),(11,'Vince-Lombardi','Trofeo de Futbol Americano',450,'/img/Vince-Lombardi.png',1),(12,'TT-31','trofeo tradicional',180,'/img/TT31.png',1),(13,'TT-25A','Figura 3D con base para cualquier deporte',130,'/img/TT25.png',1);
/*!40000 ALTER TABLE `trofeos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Mau','Mautor','mail@mail.com',1),(4,'tonatiu',NULL,'yahuitl.trejo@gmail.com',1),(8,'Rafa','rafa','raf@hotmail.com',1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `vistas`
--

LOCK TABLES `vistas` WRITE;
/*!40000 ALTER TABLE `vistas` DISABLE KEYS */;
INSERT INTO `vistas` VALUES (1,'main',1,_binary '\0',NULL),(2,'usuarios',1,_binary '\0',NULL),(3,'trofeos',1,_binary '\0',NULL),(4,'elementos',1,_binary '\0',NULL),(5,'catalogos',1,_binary '','{\"submenus\":[\"colores\", \"categorias\", \"materiales\", \"medidas\"]}');
/*!40000 ALTER TABLE `vistas` ENABLE KEYS */;
UNLOCK TABLES;
