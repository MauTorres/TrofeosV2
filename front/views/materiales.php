<?php
require_once dirname(dirname(__DIR__))."/src/dao/ElementoDao.php";
	$elementoDao = new ElementoDao();
	$elemento = new Elemento(null, "Madera", "madera azul de cedro", 250, 1, null, 1); 
	$elementoDao->saveElement($elemento);
?>