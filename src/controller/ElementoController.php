<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/ElementoBusiness.php";


$elementoBusiness = new ElementoBusiness();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'login':
			$elemento = new Elemento(null, $_POST['usuario'], $_POST['passwd'], null);
			$elementoBusiness->login($elemento);
			break;
		case 'deleteUser':
			$elemento = new Elemento($_POST['id'], $_POST['usuario'], null, $_POST['email']);
			$elementoBusiness->deleteElement($elemento);
			break;
		case 'createOrUpdateUser':
			$elemento = new Elemento($_POST['id'], $_POST['usuario'], null, $_POST['email']);
			$elementoBusiness->createOrUpdateUser($elemento);
			break;
		default:
			
			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getElementsGrid':
			$Elemento = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null)
				$elemento = new Elemento($_GET['filters']['id'], $_GET['filters']['usuario'], null, $_GET['filters']['email']);
			$elementoBusiness->getElementsGrid($elemento);
			break;
		default:
			
			break;
	}
}

?>