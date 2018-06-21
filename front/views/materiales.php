<?php
require_once dirname(dirname(__DIR__))."/src/dao/ElementoDao.php";
	$materialDao = new MaterialDao();
	$material = new Material(null, "Madera", "madera azul de cedro", 250, 1, null, 1); 
	$materialDao->saveMaterial($material);
?>