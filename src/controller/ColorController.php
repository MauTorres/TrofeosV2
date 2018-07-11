<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/ColorBusiness.php";
require_once dirname(__DIR__)."/utils/Loger.php";


$colorBusiness = new ColorBusiness();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteElement':
			$color = new Color($_POST['id'], $_POST['descripcion']);
			$colorBusiness->deleteColor($color);
			break;
		case 'createOrUpdateElement':
			$color = new Color($_POST['id'], $_POST['descripcion']);
			$colorBusiness->createOrUpdateColor($color);
			break;
		default:
			
			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getElementsGrid':
			$color = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null)
				$color = new Color($_GET['filters']['id'], $_GET['filters']['descripcion']);
			$colorBusiness->getColorsGrid($color);
			break;
		default:
			
			break;
	}
}

?>