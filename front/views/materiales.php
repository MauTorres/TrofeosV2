<?php
require_once dirname(dirname(__DIR__))."/src/dao/MaterialDao.php";
require_once dirname(dirname(__DIR__))."/src/utils/Loger.php";

	$materialDao = new MaterialDao();
	$material = new CatalogElement("Maderas"); 
	$materialDao->saveMaterial($material);
	print_r($materialDao);

?>