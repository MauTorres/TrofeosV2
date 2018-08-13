<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/VistasBusiness.php";
require_once dirname(__DIR__)."/business/SessionBusiness.php";

$vistasBusiness = new VistasBusiness();
$sessionBusiness = new SessionBusiness();
$sessionBusiness->checkSession();

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