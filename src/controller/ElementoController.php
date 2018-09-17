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
			Loger::log(print_r($_POST, 1), null);
			$elemento = new Elemento($_POST);
			$elementoBusiness->createOrUpdateElement($elemento);
			break;
		case 'setMeasure':
			$elemento = new Elemento($_POST);
			$medida = new Measure($_POST);
			$elementoBusiness->setMeasure($elemento, $medida);
			break;
		case 'setMeasures':
			$elemento = new Elemento($_POST['elementoUpdate']);
			$elementos = array();
			foreach($_POST['elementoUpdate']['medidas'] as $medida){
				array_push($medidas, new Measure($medida));
			}
			$elementoBusiness->setMeasures($elemento, $medidas);
			break;
		case 'deleteMedidaElemento':
			$elemento = new Elemento($_POST['elemento']);
			$medida = new Measure($_POST['medida']);
			$elementoBusiness->deleteMedidaElemento($elemento, $medida);
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