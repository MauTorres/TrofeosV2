<?php
/**
 * 
 */
require_once __DIR__."/Business.php";
require_once dirname(__DIR__)."/dao/TrofeoDao.php";

class TrofeoBusiness extends Business
{
	private $trofeoDAO;
	private $responce;

	function __construct()
	{
		parent::__construct();
		$this->trofeoDAO = new TrofeoDao();
	}

	public function saveTrophy($trofeo){
		$this->responce = new Responce();
		try{
			$this->trofeoDAO->saveTrophy($trofeo);
			$this->responce->success = true;
			$this->responce->message = "El trofeo se guardó correctamente";
		}catch(Exception $e){	
			Loger::log("Error al guardar el elemento ".$trofeo->nombre."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = "Error al agregar el nuevo material ".$trofeo->nombre;
		}
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
		
	}

	public function getTrofeosGrid($trofeo){
		$this->responce = new Responce();
		$params = "";
		if($trofeo != null){
			if($trofeo->nombre != null)
				$params .= "AND T.nombre like '%".$trofeo->nombre."%'";
			if($trofeo->precio != null)
				$params .= "AND T.precio = ".$trofeo->precio;
		}
		
		$result = $this->trofeoDAO->getTrofeosGrid($params);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}

	public function deleteTrophy($trofeo){
		$this->responce = new Responce();
		try{
			$this->elementoDAO->deleteElement($trofeo);
			$this->responce->success = true;
			$this->responce->message = "El material se eliminó correctamente";
		}catch(Exception $e){
			Loger::log("Error, no se pudo eliminar el elemento ".$trofeo->nombre."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = "Error al eliminar el material ".$trofeo->nombre;
		}
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}

	public function createOrUpdateTrophy($trofeo){
		$this->responce = new Responce();
		
		try{

			if($trofeo->id == null){
				$this->saveElement($trofeo);
				return;
			}
			$result = $this->elementoDAO->getElementByID($trofeo);

			$this->elementoDAO->createOrUpdateElement($trofeo);
			$this->responce->success = true;
			$this->responce->message = "El elemento se guardó correctamente";
		}catch(Exception $e){
			Loger::log("Error al actualizar el elemento ".$trofeo->nombre."\n".$e->getMessage(), null);

	public function setElement($trofeo, $elemento){
		$this->responce = new Responce();
		try{
			$this->trofeoDAO->setElement($trofeo, $elemento);
			$this->responce->success = true;
			$this->responce->message = "Se ha registrado el elemento ".$elemento->id;
		}catch(Exception $e){
			throw new Exception("Falló en insertar el elemento ".$elemento->id);	
		}

		//echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}

	public function setElements($trofeo, $elementos){
		try {
			if(count($elementos) == 0)
				throw new Exception('No hay elementos que agregar a éste trofeo');	
			foreach ($elementos as $elemento) {
				$this->setElement($trofeo, $elemento);
			}
		} catch (Exception $e) {
			$this->responce->success = false;
			$this->responce->message = $e->getMessage();
		}

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
		$this->responce->success = true;
		$this->responce->message = "Elementos insertados con éxito";
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}
}
?>