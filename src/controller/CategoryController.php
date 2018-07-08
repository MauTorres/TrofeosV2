<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/CategoriaBusiness.php";


$categoryBusiness = new CategoriaBusiness();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteCategory':
			$category = new Categoria($_POST['id'], $_POST['descripcion']);
			$categoryBusiness->deleteCategory($category);
			break;
		case 'createOrUpdateCategory':
			$category = new Categoria($_POST['id'], $_POST['descripcion']);
			$categoryBusiness->createOrUpdateCategory($category);
			break;
		default:
			
			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getCategorysGrid':
			$category = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null)
				$category = new Categoria($_GET['filters']['id'], $_GET['filters']['descripcion']);
			$categoryBusiness->getCategorysGrid($category);
			break;
		default:
			
			break;
	}
}

?>