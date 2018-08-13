<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/ElementoBusiness.php";
require_once dirname(__DIR__)."/utils/Loger.php";


$elementoBusiness = new ElementoBusiness();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteElement':
			$elemento = new Elemento($_POST['id'], $_POST['nombre'], null, null, null, null, null);
			$elementoBusiness->deleteElement($elemento);
			break;
		case 'createOrUpdateElement':
			$elemento = new Elemento($_POST['id'], $_POST['nombre'], $_POST['descripcion'], null, $_POST['color'], $_POST['categoria'], $_POST['material']);
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
				$elemento = new Elemento($_GET['filters']['id'], $_GET['filters']['nombre'], null, null,$_GET['filters']['color'], $_GET['filters']['categoria'], $_GET['filters']['material']);
			}
			$elementoBusiness->getElementsGrid($elemento);
			break;
		case 'getElementosTrofeos':
			$elemento = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null){
				$elemento = new Elemento($_GET['filters']['id'], $_GET['filters']['nombre'], null, null, $_GET['filters']['color'], $_GET['filters']['categoria'], $_GET['filters']['material']);
			}
			$elementoBusiness->getElementosTrofeos($elemento);
			break;
		case 'getElementosTrofeo':
			//Loger::log(print_r($_GET, 1), null);
			$trofeo = new Trofeo($_GET['trophy']);
			$elementoBusiness->getElementosTrofeo($trofeo);
			break;
		default:
			break;
	}
}

?>