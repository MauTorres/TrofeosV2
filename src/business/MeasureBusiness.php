<?php
/**
* 
*/
require_once __DIR__."/Business.php";
require_once dirname(__DIR__)."/dao/MedidaDao.php";

class MeasureBusiness extends Business
{
	private $measureDAO;
	private $responce;

	function __construct()
	{
		parent::__construct();
		$this->measureDAO = new MedidaDao();
	}

	public function saveMeasure($measure){
		$this->responce = new Responce();
		try{
			$this->measureDAO->saveMeasure($measure);
			$this->responce->success = true;
			$this->responce->message = "La medida se guardó correctamente";
		}catch(Exception $e){	
			Loger::log("Error al guardar la medida ".$measure->descripcion."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = "Error al agregar la nueva medida ".$measure->descripcion;
		}
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
		
	}

	public function getElementsGrid($measure){
		$this->responce = new Responce();
		$params = "";
		if($measure != null){
			if($measure->id != null)
				$params .= "AND Md.id = ".$measure->id;
			if($measure->descripcion != null)
				$params .= "AND Md.descripcion like '%".$measure->descripcion."%'";
		}
		$result = $this->measureDAO->getElementsGrid($params);
		$this->responce->success = true;
		$this->responce->data = $result;
		//Loger::log(print_r($this->responce, 1), null);

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}

	public function getMedidasElementos($medida){
		$this->responce = new Responce();
		$params = "";
		if($medida != null){
			if($medida->id != null)
				$params .= "AND Meds.id = ".$medida->id;
			if($medida->descripcion != null)
				$params .= "AND Meds.descripcion like '%".$medida->descripcion."%'";
		}
		
		$result = $this->measureDAO->getMedidasElementos($params);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}

	public function getMedidasElemento($measure){
		$this->responce = new Responce();
		$params = "";
		if($measure != null){
			if($measure->id != null)
				$params .= "AND Md.id = ".$measure->id;
			if($measure->descripcion != null)
				$params .= "AND Md.medida like '%".$measure->descripcion."%'";
		}
		$result = $this->measureDAO->getMeasureByElement($measure);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);

		/*$this->responce = new Responce();
		$result = $this->measureDAO->getMeasureByElement($trofeo);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); */
	}

	public function deleteMeasure($measure){
		$this->responce = new Responce();
		try{
			$this->measureDAO->deleteMeasure($measure);
			$this->responce->success = true;
			$this->responce->message = "La medida se descartó correctamente";
		}catch(Exception $e){
			Loger::log("Error, no se pudo eliminar la medida ".$measure->descripcion."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = "Error al eliminar la medida ".$measure->descripcion;
		}
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}

	public function createOrUpdateMeasure($measure){
		$this->responce = new Responce();
		
		try{

			if($measure->id == null){
				$this->saveMeasure($measure);
				return;
			}
			$this->measureDAO->createOrUpdateMeasure($measure);
			$this->responce->success = true;
			$this->responce->message = "La medida se guardó correctamente";
		}catch(Exception $e){
			Loger::log("Error al actualizar la medida ".$measure->descripcion."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = $e->getMessage();
		}

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}
}
?>