<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/UsuarioBusiness.php";


$usuarioBusiness = new UsuarioBusiness();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'login':
			$usuario = new Usuario(null, $_POST['usuario'], $_POST['passwd'], null);
			$usuarioBusiness->login($usuario);
			break;
		case 'deleteUser':
			$usuario = new Usuario($_POST['id'], $_POST['usuario'], null, $_POST['email']);
			$usuarioBusiness->deleteUser($usuario);
			break;
		case 'createOrUpdateUser':
			$usuario = new Usuario($_POST['id'], $_POST['usuario'], null, $_POST['email']);
			$usuarioBusiness->createOrUpdateUser($usuario);
			break;
		case 'endSession':
			$usuarioBusiness->endSession();
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