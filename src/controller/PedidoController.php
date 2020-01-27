<?php
/**
* 
*/
require_once dirname(__DIR__)."/business/PedidoBusiness.php";
require_once dirname(__DIR__)."/business/SessionBusiness.php";
require_once dirname(__DIR__)."/utils/Loger.php";


$pedidoBusiness = new pedidoBusiness();
$sessionBusiness = new SessionBusiness();
$sessionBusiness->checkSession();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteElement':
			$pedido = new Pedido($_POST);
			$pedidoBusiness->deleteElement($pedido);
			break;
		case 'createOrUpdateElement':
			$pedido = new Pedido();
			$pedido->folio = $_POST['Folio'];
			$pedido->fElaboracion = $_POST['fElaboracion'];
			$pedido->fEntrega = $_POST['fEntrega'];
			$pedido->idCliente = $_POST['idCliente'];
			$pedido->IdUsuario = $_POST['IdUsuario'];
			$pedido->trophies = array();
			foreach ($_POST['trophies'] as $trophy => $val) {
				array_push($pedido->trophies, $val['catalog']['id']);
			}
			$pedidoBusiness->createOrUpdateElement($pedido);
			break;
		case 'setMeasure':
			$pedido = new Pedido($_POST);
			$medida = new Measure($_POST);
			$pedidoBusiness->setMeasure($pedido, $medida);
			break;
		case 'setMeasures':
			$pedido = new Pedido($_POST['elementoUpdate']);
			$medidas = array();
			foreach($_POST['elementoUpdate']['medidas'] as $medida){
				array_push($medidas, new Measure($medida["id"], $medida["descripcion"]));
			}
			$pedidoBusiness->setMeasures($pedido, $medidas);
			break;
		case 'deleteMedidaElemento':
			$pedido = new Pedido($_POST['elemento']);
			$medida = new Measure($_POST['medida']);
			$pedidoBusiness->deleteMedidaElemento($pedido, $medida);
			break;
		default:

			break;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	switch ($_GET['method']) {
		case 'getOrdersGrid':
			$pedido = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null){
				$pedido = new Pedido($_GET['filters']);
			}
			$pedidoBusiness->getElementsGrid($pedido);
			break;
		case 'getElementosTrofeos':
			$pedido = null;
			if(isset($_GET['filters']) && $_GET['filters'] != null){
				$pedido = new Pedido($_GET['filters']);
			}
			$pedidoBusiness->getElementosTrofeos($pedido);
			break;
		default:
			break;
	}
}

?>