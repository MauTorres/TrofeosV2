<?php

require_once dirname(__DIR__)."/business/TrofeoBusiness.php";
require_once dirname(__DIR__)."/business/SessionBusiness.php";
require_once dirname(__DIR__)."/utils/FileManager.php";

$trofeoBusiness = new TrofeoBusiness();
$sessionBusiness = new SessionBusiness();
$sessionBusiness->checkSession();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'createOrUpdateTrophy':
			$fotoPath = null;
			if(isset($_FILES) && isset($_FILES['foto'])){
				$fileManager = new FileManager($_FILES['foto']);
				$fileManager->saveImage();
				$fotoPath = STORE_PATH.$_FILES['foto']['name'];
			}
			$_POST['foto'] = $fotoPath;
			$trofeo = new Trofeo($_POST);
			$trofeoBusiness->createOrUpdateTrophy($trofeo);
			break;
		case 'setElement':
			$trofeo = new Trofeo($_POST);
			$elemento = new Elemento($_POST);
			$trofeoBusiness->setElement($trofeo, $elemento);
			break;
		case 'setElements':
			$trofeo = new Trofeo($_POST['trofeoUpdate']);
			$elementos = array();
			foreach($_POST['trofeoUpdate']['elementos'] as $elemento){
				array_push($elementos, new Elemento($elemento));
			}
			$trofeoBusiness->setElements($trofeo, $elementos);
			break;
		case 'deleteTrophy':
			$trofeo = new Trofeo($_POST['trofeo']);
			$trofeoBusiness->createOrUpdateTrophy($trofeo);
			break;
		case 'deleteTrofeoElemento':
			$trofeo = new Trofeo($_POST['trofeo']);
			$elemento = new Elemento($_POST['elemento']);
			$trofeoBusiness->deleteElementoTrofeo($trofeo, $elemento);
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
				$trofeo = new Trofeo($_GET['filters']);
			$trofeoBusiness->getTrofeosGrid($trofeo);
			break;
		default:

			break;
	}
}

?>