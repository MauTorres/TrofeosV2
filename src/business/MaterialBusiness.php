<?php
/**
* 
*/
require_once __DIR__."/Business.php";
require_once dirname(__DIR__)."/dao/MaterialDao.php";

class MaterialBusiness extends Business
{
	private $materialDAO;
	private $responce;

	function __construct()
	{
		parent::__construct();
		$this->materialDAO = new MaterialDao();
	}

	public function saveMaterial($material){
		$this->responce = new Responce();
		try{
			$this->materialDAO->saveMaterial($material);
			$this->responce->success = true;
			$this->responce->message = "El material se guardó correctamente";
		}catch(Exception $e){	
			Loger::log("Error al guardar el material ".$material->descripcion."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = "Error al agregar el nuevo material ".$material->descripcion;
		}
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
		
	}

	public function getMaterialsGrid($material){
		$this->responce = new Responce();
		$params = "";
		if($material != null){
			if($material->id != null)
				$params .= "AND M.id = ".$material->id;
			if($material->descripcion != null)
				$params .= "AND M.descripcion like '%".$material->descripcion."%'";
		}
		Loger::log(print_r($params,true), null);
		$result = $this->materialDAO->getMaterialsGrid($params);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}

	public function deleteMaterial($material){
		$this->responce = new Responce();
		try{
			$this->materialDAO->deleteMaterial($material);
			$this->responce->success = true;
			$this->responce->message = "El material se eliminó correctamente";
		}catch(Exception $e){
			Loger::log("Error, no se pudo eliminar el material ".$material->descripcion."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = "Error al eliminar el material ".$material->descripcion;
		}
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}

	public function createOrUpdateMaterial($material){
		$this->responce = new Responce();
		
		try{

			if($material->id == null){
				$this->saveMaterial($material);
				return;
			}
			$result = $this->materialDAO->getMaterialByID($material);

			$this->materialDAO->createOrUpdateMaterial($material);
			$this->responce->success = true;
			$this->responce->message = "El material se guardó correctamente";
		}catch(Exception $e){
			Loger::log("Error al actualizar el material ".$material->descripcion."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = $e->getMessage();
		}

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}
}
?>