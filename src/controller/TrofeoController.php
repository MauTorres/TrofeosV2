<?php

require_once dirname(__DIR__)."/business/TrofeoBusiness.php";


$trofeoBusiness = new TrofeoBusiness();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteUser':
			$usuario = new Usuario($_POST['id'], $_POST['usuario'], null, $_POST['email']);
			$trofeoBusiness->deleteUser($usuario);
			break;
		case 'createOrUpdateUser':
			$usuario = new Usuario($_POST['id'], $_POST['usuario'], null, $_POST['email']);
			$trofeoBusiness->createOrUpdateUser($usuario);
			break;
		default:
			
			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getTrofeosGrid':
			$trofeo = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null)
				$trofeo = new Trofeo(null, $_GET['filters']['nombre'], null, $_GET['filters']['precio'], null);
			$trofeoBusiness->getTrofeosGrid($trofeo);
			break;
		default:
			
			break;
	}
}

?>