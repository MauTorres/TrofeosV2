<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/entities/Medidas.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class MedidaDao extends DAO
{

	function __construct()
	{
		parent::__construct();
	}

	public function getMeasureByMeasureDescription($measureName){
		$measure = array();
		$result = $this->query("SELECT * FROM tiposMedidas WHERE descripcion = ?", array($measureName));
		$result = $result->getResultSet();
		foreach ($result as $measure) {
			array_push($measure, new Measure($measure['id'], $measure['descripcion']));
		}

		return $measure;
	}

	public function saveMeasure($measure){
		try{
			$this->execute("INSERT INTO tiposMedidas(descripcion) VALUES(:descripcion)", array(":descripcion"=>$measure->descripcion));
		}catch(Exception $e){
			Loger::log($e->getMessage(), null);
			throw $e;
		}
		
	}

	public function getElementsGrid($params){
		$query = sprintf("SELECT 
				Meds.id,
				Meds.descripcion
			FROM tiposMedidas Meds
			WHERE
				estatus = 1
				%s", $params);
		return $this->query($query, null);
	}

	public function deleteMeasure($measure){
		try{
			$this->execute("UPDATE tiposMedidas SET estatus = 0 WHERE id = :id", array(":id"=>$measure->id));
		}catch(Exception $e){
			throw $e;
		}
	}

	public function getMeasureByID($measure){
		$result = $this->query("SELECT * FROM tiposMedidas WHERE id = ?", array($measure->id));
		$row = $result->getResultSet()[0];
		return new Measure($row['id'], $row['descripcion']);
	}

	public function createOrUpdateMeasure($measure){
		try{
			$measureNew = $this->getMeasureByID($measure);
			if($measure->descripcion != null && $measure->descripcion != ''){
				$measureNew->descripcion = $measure->descripcion;
			}
			
			$this->execute(
				"UPDATE tiposMedidas 
				SET 
					descripcion = :descripcion
				WHERE id = :id", 
				array(
					":descripcion"=>$measureNew->descripcion, 
					":id"=>$measureNew->id
				)
			);
		}catch(Exception $e){
			Loger::log($e->getMessage(), null);
			throw $e;
		}	
	}

	public function getMeasureByElement($element) {
		$elemId = $element->id;
		$params = "";
		$query = sprintf("SELECT 
				Meds.id,
				Meds.medida
			FROM medidas Meds
			WHERE
<<<<<<< HEAD
				idElemento = $elemId AND 
				estatus = 1
=======
				Meds.idElemento = $elemId AND 
				Meds.estatus = 1
>>>>>>> 2979e661916fb59aa3b0e0be2d42e6321fea9f56
				%s", $params);
		return $this->query($query, null);
		/*$measure = array();
		$result = $this->query("SELECT `id`,`medida` FROM `medidas` WHERE `idElemento` = ? AND `estatus` = 1", array($element->id));
		$result = $result->getResultSet();
		foreach ($result as $measure) {
			array_push($measure, new Measure($measure['id'], $measure['medida']));
		}
		return $measure;*/
	}
}
?>