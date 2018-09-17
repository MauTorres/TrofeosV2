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
			$this->execute("INSERT INTO tiposMedidas(descripcion) VALUES(?)", array(array($measure->descripcion)));
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
			$this->execute("UPDATE tiposMedidas SET estatus = 0 WHERE id = ?", array(array($measure->id)));
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
					descripcion = ?
				WHERE id = ?", 
				array(array($measureNew->descripcion, $measureNew->id)));
		}catch(Exception $e){
			Loger::log($e->getMessage(), null);
			throw $e;
		}	
	}
}
?>