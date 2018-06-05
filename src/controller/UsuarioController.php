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
			print_r($usuarioBusiness->login($usuario));
			break;
		
		default:
			
			break;
	}
}

?>