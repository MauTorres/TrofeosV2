<?php

require_once dirname(__DIR__)."/business/TrofeoBusiness.php";
require_once dirname(__DIR__)."/utils/FileManager.php";

$trofeoBusiness = new TrofeoBusiness();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'createOrUpdateTrophy':
			$fotoPath = null;
			if(isset($_FILES) && isset($_FILES['foto'])){
				$fileManager = new FileManager($_FILES['foto']);
				$fileManager->saveImage();
				$fotoPath = STORE_PATH.$_FILES['foto']['name'];
			}
			$trofeo = new Trofeo($_POST['id'], $_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $fotoPath, $_POST['estatus']);
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
			foreach($_POST['currentTrophy']['elementos'] as $elemento){
				array_push($elementos, new Elemento($elemento['id'], null, null, null, null, null, null));
			}
			$trofeoBusiness->setElements($trofeo, $elementos);
			break;
		case 'deleteTrophy':
			$trofeo = new Trofeo($_POST['trofeo']['id'], null, null, null, null, 0);
			$trofeoBusiness->createOrUpdateTrophy($trofeo);
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