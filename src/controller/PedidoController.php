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


function paramsToObject($params){
	$pedido = new Pedido();
	if(isset($params['id'])){
		$pedido->id = $params['id'];
	}
	$pedido->folio = $params['folio'];
	$pedido->fElaboracion = $params['fecha_elaboracion'];
	$pedido->fEntrega = $params['fecha_entrega'];
	$pedido->idCliente = $params['cliente'];
	$pedido->IdUsuario = $params['usuario'];
	$pedido->trophies = array();
	if(isset($params['trophies']) && !empty($params['trophies']))
		foreach ($params['trophies'] as $key => $val) {
			array_push($pedido->trophies, array(
				"id" => $val['catalog']['id'], "action" => $val['action']));
		}
	return $pedido;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	switch ($_POST['method']) {
		case 'deleteElement':
			$pedido = paramsToObject($_POST);
			$pedidoBusiness->deleteElement($pedido);
			break;
		case 'createOrUpdateElement':
			$pedido = paramsToObject($_POST);
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