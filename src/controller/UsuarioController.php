<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/UsuarioBusiness.php";
require_once dirname(__DIR__)."/business/SessionBusiness.php";

$usuarioBusiness = new UsuarioBusiness();
$sessionBusiness = new SessionBusiness();
$sessionBusiness->checkSession();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteUser':
			$usuario = new Usuario($_POST['id'], $_POST['usuario'], null, $_POST['email']);
			$usuarioBusiness->deleteUser($usuario);
			break;
		case 'createOrUpdateUser':
			$usuario = new Usuario($_POST['id'], $_POST['usuario'], $_POST['passwd'], $_POST['email']);
			$usuarioBusiness->createOrUpdateUser($usuario);
			break;
		default:
			
			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getUsersGrid':
			$usuario = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null)
				$usuario = new Usuario($_GET['filters']['id'], $_GET['filters']['usuario'], null, $_GET['filters']['email']);
			$usuarioBusiness->getUsersGrid($usuario);
			break;
		default:
			
			break;
	}
}

?>