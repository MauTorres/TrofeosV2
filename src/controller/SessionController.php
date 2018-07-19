<?php
require_once dirname(__DIR__)."/business/SessionBusiness.php";
$sessionBusiness = new SessionBusiness();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getSession':
			$sessionBusiness->getSession();
			break;
		default:
			# code...
			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'login':
			$usuario = new Usuario(null, $_POST['usuario'], $_POST['passwd'], null);
			$sessionBusiness->login($usuario);
			break;
		case 'endSession':
			$sessionBusiness->endSession();
			break;
		default:
			# code...
			break;
	}	
}
?>