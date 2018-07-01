<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/ElementoBusiness.php";


$elementoBusiness = new ElementoBusiness();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteElement':
			$elemento = new Elemento($_POST['id'], $_POST['nombre'], $_POST['descripcion'], $_POST['precio'], null, null, null);
			$elementoBusiness->deleteElement($elemento);
			break;
		case 'createOrUpdateElement':
			$elemento = new Elemento($_POST['id'], $_POST['nombre'], $_POST['descripcion'], $_POST['precio'], null, null, null);
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
			if(isset($_GET['filters']) && $_GET['filters'] != null)
				$elemento = new Elemento($_GET['filters']['id'], $_GET['filters']['nombre'], $_GET['filters']['descripcion'], $_GET['filters']['precio'], $_GET['filters']['color'], $_GET['filters']['deporte'], $_GET['filters']['material']);
			$elementoBusiness->getElementsGrid($elemento);
			break;
		default:
			
			break;
	}
}

?>