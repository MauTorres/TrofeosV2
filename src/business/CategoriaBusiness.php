<?php
/**
* 
*/
require_once __DIR__."/Business.php";
require_once dirname(__DIR__)."/dao/CategoryDao.php";

class CategoryBusiness extends Business
{
	private $categoriaDAO;
	private $responce;

	function __construct()
	{
		parent::__construct();
		$this->categoriaDAO = new CategoryDao();
	}

	public function saveCategory($categoria){
		$this->responce = new Responce();
		try{
			$this->categoriaDAO->saveCategory($categoria);
			$this->responce->success = true;
			$this->responce->message = "La categoria se guardó correctamente";
		}catch(Exception $e){	
			Loger::log("Error al guardar la categoria ".$categoria->descripcion."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = "Error al agregar una nueva categoria ".$categoria->descripcion;
		}
		echo json_encode($this->responce);
		
	}

	public function getCategoriesGrid($categoria){
		$this->responce = new Responce();
		$params = "";
		if($categoria != null){
			if($categoria->id != null)
				$params .= "AND Cat.id = ".$categoria->id;
			if($categoria->nombre != null)
				$params .= "AND Cat.descripcion like '%".$categoria->descripcion."%'";
		}
		Loger::log(print_r($params,true), null);
		$result = $this->categoriaDAO->getCategoriesGrid($params);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce); 
	}

	public function deleteCategory($categoria){
		$this->responce = new Responce();
		try{
			$this->categoriaDAO->deleteCategory($categoria);
			$this->responce->success = true;
			$this->responce->message = "La categoria se descartó correctamente";
		}catch(Exception $e){
			Loger::log("Error, no se pudo eliminar la categoria ".$categoria->descripcion."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = "Error al eliminar la categoria ".$categoria->descripcion;
		}
		echo json_encode($this->responce);
	}

	public function createOrUpdateCategory($categoria){
		$this->responce = new Responce();
		
		try{

			if($categoria->id == null){
				$this->saveCategory($categoria);
				return;
			}
			$result = $this->categoriaDAO->getCategoryByID($categoria);

			$this->categoriaDAO->createOrUpdateCategory($categoria);
			$this->responce->success = true;
			$this->responce->message = "El categoria se guardó correctamente";
		}catch(Exception $e){
			Loger::log("Error al actualizar la categoria ".$categoria->descripcion."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = $e->getMessage();
		}

		echo json_encode($this->responce);
	}
}
?>