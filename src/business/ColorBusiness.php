<?php
/**
* 
*/
require_once __DIR__."/Business.php";
require_once dirname(__DIR__)."/dao/ColorDao.php";

class ColorBusiness extends Business
{
	private $colorDAO;
	private $responce;

	function __construct()
	{
		parent::__construct();
		$this->colorDAO = new ColorDao();
	}

	public function saveColor($color){
		$this->responce = new Responce();
		try{
			$this->colorDAO->saveColor($color);
			$this->responce->success = true;
			$this->responce->message = "El color se guardó correctamente";
		}catch(Exception $e){	
			Loger::log("Error al guardar el color ".$color->descripcion."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = "Error al agregar el nuevo color ".$color->descripcion;
		}
		echo json_encode($this->responce);
		
	}

	public function getColorsGrid($color){
		$this->responce = new Responce();
		$params = "";
		if($color != null){
			if($color->id != null)
				$params .= "AND C.id = ".$color->id;
			if($color->nombre != null)
				$params .= "AND C.descripcion like '%".$color->descripcion."%'";
		}
		Loger::log(print_r($params,true), null);
		$result = $this->colorDAO->getColorsGrid($params);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce); 
	}

	public function deleteColor($color){
		$this->responce = new Responce();
		try{
			$this->colorDAO->deleteColor($color);
			$this->responce->success = true;
			$this->responce->message = "El color se descartó correctamente";
		}catch(Exception $e){
			Loger::log("Error, no se pudo eliminar el color ".$color->descripcion."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = "Error al eliminar el color ".$color->descripcion;
		}
		echo json_encode($this->responce);
	}

	public function createOrUpdateColor($color){
		$this->responce = new Responce();
		
		try{

			if($color->id == null){
				$this->saveColor($color);
				return;
			}
			$result = $this->colorDAO->getColorByID($color);

			$this->colorDAO->createOrUpdateColor($color);
			$this->responce->success = true;
			$this->responce->message = "El color se guardó correctamente";
		}catch(Exception $e){
			Loger::log("Error al actualizar el color ".$color->descripcion."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = $e->getMessage();
		}

		echo json_encode($this->responce);
	}
}
?>