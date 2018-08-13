<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/ElementoBusiness.php";
require_once dirname(__DIR__)."/business/SessionBusiness.php";
require_once dirname(__DIR__)."/utils/Loger.php";


$elementoBusiness = new ElementoBusiness();
$sessionBusiness = new SessionBusiness();
$sessionBusiness->checkSession();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteElement':
			$elemento = new Elemento($_POST);
			$elementoBusiness->deleteElement($elemento);
			break;
		case 'createOrUpdateElement':
			$elemento = new Elemento($_POST);
			$elementoBusiness->createOrUpdateElement($elemento);
			break;
		default:
			
			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getElementsGrid':
			$elemento = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null){
				$elemento = new Elemento($_GET['filters']);
			}
			$elementoBusiness->getElementsGrid($elemento);
			break;
		case 'getElementosTrofeos':
			$elemento = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null){
				$elemento = new Elemento($_GET['filters']);
			}
			$elementoBusiness->getElementosTrofeos($elemento);
			break;
		case 'getElementosTrofeo':
			$trofeo = new Trofeo($_GET['trophy']);
			$elementoBusiness->getElementosTrofeo($trofeo);
			break;
		default:
			break;
	}
}

?>