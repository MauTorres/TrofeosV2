<?php

require_once dirname(__DIR__)."/business/TrofeoBusiness.php";
require_once dirname(__DIR__)."/utils/FileManager.php";

$trofeoBusiness = new TrofeoBusiness();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'createOrUpdateTrophy':
			Loger::log(print_r($_POST, 1), null);
			$fileManager = new FileManager($_FILES['foto']);
			$fileManager->saveImage();
			$trofeo = new Trofeo($_POST['id'], $_POST['nombre'], $_POST['descripcion'], $_POST['precio'], STORE_PATH.$_FILES['foto']['name'], $_POST['estatus']);
			Loger::log(print_r($trofeo, 1), null);
			$trofeoBusiness->createOrUpdateTrophy($trofeo);
			break;
		case 'setElement':
			$trofeo = new Trofeo($_POST['idTrofeo'], null, null, null, null, null);
			$elemento = new Elemento($_POST['idTrofeo'], null, null, null, null, null, null);
			$trofeoBusiness->setElement($trofeo, $elemento);
			break;
		case 'setElements':
			$trofeo = new Trofeo($_POST['currentTrophy']['id'], null, null, null, null, null);
			$elementos = array();
			//Loger::log(print_r($trofeo, 1), null);
			foreach($_POST['currentTrophy']['elementos'] as $elemento){
				array_push($elementos, new Elemento($elemento['id'], null, null, null, null, null, null));
			}
			$trofeoBusiness->setElements($trofeo, $elementos);
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
				$trofeo = new Trofeo(null, $_GET['filters']['nombre'], null, $_GET['filters']['precio'], null, null);
			$trofeoBusiness->getTrofeosGrid($trofeo);
			break;
		default:
			
			break;
	}
}

?>