<?php
/**
* 
*/
require_once __DIR__."/Business.php";
require_once dirname(__DIR__)."/dao/ElementoDao.php";

class ElementoBusiness extends Business
{
	private $elementoDAO;
	private $responce;

	function __construct()
	{
		parent::__construct();
		$this->elementoDAO = new ElementoDao();
	}

	public function saveElement($elemento){
		$this->responce = new Responce();
		try{
			$this->elementoDAO->saveElement($elemento);
			$this->responce->success = true;
			$this->responce->message = "El material se guardó correctamente";
		}catch(Exception $e){	
			Loger::log("Error al guardar el elemento ".$elemento->nombre."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = "Error al agregar el nuevo material ".$elemento->nombre;
		}
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
		
	}

	public function getElementsGrid($elemento){
		$this->responce = new Responce();
		$params = "";
		if($elemento != null){
			if($elemento->id != null)
				$params .= "AND E.id = ".$elemento->id;
			if($elemento->nombre != null)
				$params .= "AND E.nombre like '%".$elemento->nombre."%'";
			if($elemento->descripcion != null)
				$params .= "AND E.descripcion like '%".$elemento->descripcion."%'";
			if($elemento->idColor != null)
				$params .= "AND C.descripcion like '%".$elemento->idColor."%'";
			if($elemento->idCategoria != null)
				$params .= "AND Cat.descripcion like '%".$elemento->idCategoria."%'";
			if($elemento->idMaterial != null)
				$params .= "AND M.descripcion like '%".$elemento->idMaterial."%'";
		}
		
		$result = $this->elementoDAO->getElementsGrid($params);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}

	public function getElementosTrofeos($elemento){
		$this->responce = new Responce();
		$params = "";
		if($elemento != null){
			if($elemento->id != null)
				$params .= "AND E.id = ".$elemento->id;
			if($elemento->nombre != null)
				$params .= "AND E.nombre like '%".$elemento->nombre."%'";
			if($elemento->descripcion != null)
				$params .= "AND E.descripcion like '%".$elemento->descripcion."%'";
			if($elemento->idColor != null)
				$params .= "AND C.descripcion like '%".$elemento->idColor."%'";
			if($elemento->idCategoria != null)
				$params .= "AND Cat.descripcion like '%".$elemento->idCategoria."%'";
			if($elemento->idMaterial != null)
				$params .= "AND M.descripcion like '%".$elemento->idMaterial."%'";
		}
		
		$result = $this->elementoDAO->getElementosTrofeos($params);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}

	public function deleteElement($elemento){
		$this->responce = new Responce();
		try{
			$this->elementoDAO->deleteElement($elemento);
			$this->responce->success = true;
			$this->responce->message = "El material se eliminó correctamente";
		}catch(Exception $e){
			Loger::log("Error, no se pudo eliminar el elemento ".$elemento->nombre."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = "Error al eliminar el material ".$elemento->nombre;
		}
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}

	public function createOrUpdateElement($elemento){
		$this->responce = new Responce();
		
		try{

			if($elemento->id == null){
				$this->saveElement($elemento);
				return;
			}
			$result = $this->elementoDAO->getElementByID($elemento);

			$this->elementoDAO->createOrUpdateElement($elemento);
			$this->responce->success = true;
			$this->responce->message = "El elemento se guardó correctamente";
		}catch(Exception $e){
			Loger::log("Error al actualizar el elemento ".$elemento->nombre."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = $e->getMessage();
		}

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}
}
?>