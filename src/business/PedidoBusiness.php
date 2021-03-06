<?php
/**
* 
*/
require_once __DIR__."/Business.php";
require_once dirname(__DIR__)."/dao/PedidoDao.php";
require_once dirname(__DIR__)."/dao/PedidoTrofeosDao.php";

class PedidoBusiness extends Business
{
	private $pedidoDAO;
	private $responce;

	function __construct()
	{
		parent::__construct();
		$this->pedidoDAO = new PedidoDao();
	}

	public function saveElement($pedido){
		$dao = new PedidoTrofeosDao();
		
		$this->pedidoDAO->beginTransaction();
		$id = $this->pedidoDAO->saveElement($pedido);
		if($id){
			$pedido->id = $id;
			$dao->createRelationship($pedido);
			$this->pedidoDAO->commit();
			$this->responce->success = true;
			$this->responce->message = "El pedido se guardó correctamente";
		} else {
			$this->pedidoDAO->rollback();
			Loger::log("Error al guardar el pedido con folio ".$pedido->folio, null);
			$this->responce->success = false;
			$this->responce->message = "Error al agregar el nuevo pedido ".$pedido->folio;
		}
	}

	private function printError(){
		$this->pedidoDAO->rollback();
		$this->responce->success = false;
		$this->responce->message = "Hubo un error al guardar el pedido";
	}

	public function updateElement($pedido){
		$this->pedidoDAO->beginTransaction();
		$dao = new PedidoTrofeosDao();
		if($this->pedidoDAO->createOrUpdateElement($pedido)){
			foreach($pedido->trophies as $key => $val){
				if($val['action'] === 'add'){
					if(!$dao->createSimpleRelationship($pedido->id, $val['id'])){
						$this->printError();
					}
				}else if($val['action'] === 'delete'){
					if(!$dao->removeSimpleRelationship($pedido->id, $val['id'])){
						$this->printError();
					}
				}
			}
			$this->pedidoDAO->commit();
			$this->responce->success = true;
			$this->responce->message = "El pedido se guardó correctamente";
		} else {
			$this->printError();
		}
	}

	public function getElementsGrid($pedido){
		$this->responce = new Responce();
		$params = "";
		if($pedido != null){
			if($pedido->id != null)
				$params .= "AND P.id = ".$pedido->id;
			if($pedido->folio != null)
				$params .= "AND P.folio like '%".$pedido->folio."%'";
			if($pedido->fElaboracion != null)
				$params .= "AND P.fElaboracion like '%".$pedido->fElaboracion."%'";
			if($pedido->fEntrega != null)
				$params .= "AND P.fEntrega like '%".$pedido->fEntrega."%'";
			if($pedido->subtotal != null)
				$params .= "AND P.subtotal like '%".$pedido->subtotal."%'";
			if($pedido->total != null)
				$params .= "AND P.total like '%".$pedido->total."%'";
			if($pedido->idCliente != null)
				$params .= "AND Cl.nombre like '%".$pedido->idCliente."%'";
			if($pedido->IdUsuario != null)
				$params .= "AND U.usuario like '%".$pedido->IdUsuario."%'";
		}
		
		$result = $this->pedidoDAO->getElementsGrid($params);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}

	public function getElementosTrofeos($pedido){
		$this->responce = new Responce();
		$params = "";
		if($pedido != null){
			if($pedido->id != null)
				$params .= "AND P.id = ".$pedido->id;
			if($pedido->folio != null)
				$params .= "AND P.folio like '%".$pedido->folio."%'";
			if($pedido->fElaboracion != null)
				$params .= "AND P.fElaboracion like '%".$pedido->fElaboracion."%'";
			if($pedido->fEntrega != null)
				$params .= "AND P.fEntrega like '%".$pedido->fEntrega."%'";
			if($pedido->subtotal != null)
				$params .= "AND P.subtotal like '%".$pedido->subtotal."%'";
			if($pedido->total != null)
				$params .= "AND P.total like '%".$pedido->total."%'";
			if($pedido->idCliente != null)
				$params .= "AND Cl.nombre like '%".$pedido->idCliente."%'";
			if($pedido->IdUsuario != null)
				$params .= "AND U.usuario like '%".$pedido->IdUsuario."%'";
		}
		
		$result = $this->pedidoDAO->getElementosTrofeos($params);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}

	public function getElementosTrofeo($trofeo){
		$this->responce = new Responce();
		$result = $this->pedidoDAO->getElementosTrofeo($trofeo);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}

	public function deleteElement($pedido){
		$this->responce = new Responce();
		if($this->pedidoDAO->deleteElement($pedido)){
			$this->responce->success = true;
			$this->responce->message = "El pedido se eliminó correctamente";
		} else {
			Loger::log("Error, no se pudo eliminar el pedido ".$pedido->folio, null);
			$this->responce->success = false;
			$this->responce->message = "Error al eliminar el pedido ".$pedido->folio;
		}
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}

	public function createOrUpdateElement($pedido){
		$this->responce = new Responce();
		try{
			if($pedido->id == null){
				$this->saveElement($pedido);
			} else {
				$this->updateElement($pedido);
			}
		}catch(Exception $e){
			Loger::log("Error al actualizar el pedido ".$pedido->folio."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = $e->getMessage();
		}

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}

	/*public function setMeasure($pedido, $medida){
		$this->responce = new Responce();
		try{
			$this->pedidoDAO->setMeasure($pedido, $medida);
			$this->responce->success = true;
			$this->responce->message = "Se ha registrado la medida ".$medida->id;
		}catch(Exception $e){
			throw new Exception("Falló en insertar la medida ".$medida->id);
		}

		//echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}

	public function setMeasures($pedido, $medidas){
		try {
			if(count($medidas) == 0)
				throw new Exception('No hay medidas que agregar a éste elemento');
			foreach ($medidas as $medida) {
				$this->setMeasure($pedido, $medida);
			}
		} catch (Exception $e) {
			$this->responce->success = false;
			$this->responce->message = $e->getMessage();
		}

		$this->responce->success = true;
		$this->responce->message = "Medidas insertados con éxito";
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}*/
}
?>