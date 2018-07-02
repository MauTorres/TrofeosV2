<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/DeporteBusiness.php";


$sportBusiness = new DeporteBusiness();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteSport':
			$sport = new Deporte($_POST['id'], $_POST['descripcion']);
			$sportBusiness->deleteSport($sport);
			break;
		case 'createOrUpdateSport':
			$sport = new Deporte($_POST['id'], $_POST['descripcion']);
			$sportBusiness->createOrUpdateSport($sport);
			break;
		default:
			
			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getSportsGrid':
			$sport = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null)
				$sport = new Deporte($_GET['filters']['id'], $_GET['filters']['descripcion']);
			$sportBusiness->getSportsGrid($sport);
			break;
		default:
			
			break;
	}
}

?>