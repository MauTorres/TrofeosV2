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

	public function saveElemento($elemento){
		$this->responce = new Responce();
		try{
			$this->lelementoDAO->saveElemento($elemento);
			$this->responce->success = true;
			$this->responce->message = "El material se guardó correctamente";
		}catch(Exception $e){
			$this->responce->success = false;
			$this->responce->message = "Error al agregar el nuevo material ".$elemento->nombre;
		}
		echo json_encode($this->responce);
		
	}

	public function getElementsGrid($params){
		$this->responce = new Responce();
		$result = $this->elementoDAO->getUElementsGrid($params);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce); 
	}

	public function deleteElements($elemento){
		$this->responce = new Responce();
		try{
			$this->elementoDAO->deleteElements($elemento);
			$this->responce->success = true;
			$this->responce->message = "El material se eliminó correctamente";
		}catch(Exception $e){
			$this->responce->success = false;
			$this->responce->message = "Error al eliminar el material ".$elemento->nombre;
		}
		echo json_encode($this->responce);
	}

	public function updateElement($elemento){
		$this->responce = new Responce();
		try{
			$this->elementoDAO->updateUser($elemento);
			$this->responce->success = true;
			$this->responce->message = "El material se actualizó correctamente";
		}catch(Exception $e){
			$this->responce->success = false;
			$this->responce->message = "Error al actualizar el material ".$elemento->nombre;
		}
		echo json_encode($this->responce);
	}
}
?>