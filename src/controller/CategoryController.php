<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/CategoriaBusiness.php";
require_once dirname(__DIR__)."/utils/Loger.php";


$categoryBusiness = new CategoriaBusiness();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteElement':
			$category = new Categoria($_POST['id'], null);
			$categoryBusiness->deleteCategory($category);
			break;
		case 'createOrUpdateElement':
			$category = new Categoria($_POST['id'], $_POST['descripcion']);
			$categoryBusiness->createOrUpdateCategory($category);
			break;
		default:
			
			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getElementsGrid':
			$category = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null)
				$category = new Categoria($_GET['filters']['id'], $_GET['filters']['descripcion']);
			$categoryBusiness->getCategoriesGrid($category);
			break;
		default:
			
			break;
	}
}

?>