<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/MaterialBusiness.php";
require_once dirname(__DIR__)."/utils/Loger.php";


$materialBusiness = new MaterialBusiness();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteElement':
			$material = new Material($_POST['id'], $_POST['descripcion']);
			$materialBusiness->deleteMaterial($material);
			break;
		case 'createOrUpdateElement':
			$material = new Material($_POST['id'], $_POST['descripcion']);
			$materialBusiness->createOrUpdateMaterial($material);
			break;
		default:
			
			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getElementsGrid':
			$material = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null)
				$material = new Material($_GET['filters']['id'], $_GET['filters']['descripcion']);
			$materialBusiness->getMaterialsGrid($material);
			break;
		default:
			
			break;
	}
}

?>