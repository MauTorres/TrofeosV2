<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/ClienteBusiness.php";
require_once dirname(__DIR__)."/business/SessionBusiness.php";

$ClienteBusiness = new ClienteBusiness();
$sessionBusiness = new SessionBusiness();
$sessionBusiness->checkSession();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteUser':
			$Cliente = new Cliente($_POST['id'], $_POST['nombre'], $_POST['direccion'], $_POST['vendedorInt']);
			$ClienteBusiness->deleteUser($Cliente);
			break;
		case 'createOrUpdateUser':
			$Cliente = new Cliente($_POST['id'], $_POST['nombre'], $_POST['direccion'], $_POST['vendedorInt']);
			$ClienteBusiness->createOrUpdateUser($Cliente);
			break;
		default:
			
			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getUsersGrid':
			$Cliente = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null)
				$Cliente = new Cliente($_GET['filters']['id'], $_GET['filters']['nombre'], $_GET['filters']['direccion'], $_GET['filters']['vendedorInt']);
			$ClienteBusiness->getUsersGrid($Cliente);
			break;
		default:
			
			break;
	}
}

?>