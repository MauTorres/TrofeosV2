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
		default:
			
			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getUsersGrid':
			$usuarioBusiness->getUsersGrid(null);
			break;
		default:
			
			break;
	}
}

?>