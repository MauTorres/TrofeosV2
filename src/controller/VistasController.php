<?php
/**
* 
*/
session_start();
require_once dirname(__DIR__)."/business/VistasBusiness.php";

$vistasBusiness = new VistasBusiness();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getVistasAll':
			$vistasBusiness->getVistasAll();
			break;
		default:
			
			break;
	}
}
?>