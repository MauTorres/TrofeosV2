<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/MeasureBusiness.php";
//require_once dirname(__DIR__)."\business\ElementoBusiness.php"; //Windows
require_once dirname(__DIR__)."/business/SessionBusiness.php";
require_once dirname(__DIR__)."/utils/Loger.php";


$measureBusiness = new MeasureBusiness();
$sessionBusiness = new SessionBusiness();
$sessionBusiness->checkSession();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteElement':
			$measure = new Measure($_POST['id'], null);
			$measureBusiness->deleteMeasure($measure);
			break;
		case 'createOrUpdateElement':
			$measure = new Measure($_POST['id'], $_POST['descripcion']);
			$measureBusiness->createOrUpdateMeasure($measure);
			break;
		default:
			
			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getElementsGrid':
			$measure = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null)
				$measure = new Measure($_GET['filters']['id'], $_GET['filters']['descripcion']);
			$measureBusiness->getElementsGrid($measure);
			break;
		case 'getMedidasElementos':
			$measure = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null){
				$measure = new Measure($_GET['filters']);
			}
			$measureBusiness->getMedidaElemento($measure);
			break;
		case 'getMedidasElemento':
			$elemento = new Elemento($_GET['element']);
			$measureBusiness->getMedidasElemento($elemento);
			break;
		default:
			break;
	}
}

?>