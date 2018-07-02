<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/ColorBusiness.php";


$colorBusiness = new ColorBusiness();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteColor':
			$color = new Color($_POST['id'], $_POST['descripcion']);
			$colorBusiness->deleteColor($color);
			break;
		case 'createOrUpdateColor':
			$color = new Color($_POST['id'], $_POST['descripcion']);
			$colorBusiness->createOrUpdateColor($color);
			break;
		default:
			
			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getColorsGrid':
			$color = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null)
				$color = new Color($_GET['filters']['id'], $_GET['filters']['descripcion']);
			$colorBusiness->getColorGrid($color);
			break;
		default:
			
			break;
	}
}

?>