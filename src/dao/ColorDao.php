<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/entities/Color.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class UsuarioDao extends DAO
{

	function __construct()
	{
		parent::__construct();
	}

	public function getColorByColorName($colorName){
		$color = array();
		$result = $this->query("SELECT * FROM colores WHERE descripcion = ?", array($colorName));
		$result = $result->getResultSet();

		foreach ($result as $color) {
			array_push($color, new Color($color['id'], $color['descripcion']));
		}

		return $color;
	}

	public function saveColor($color){
		try{
			$this->execute("INSERT INTO colores(descripcion,) VALUES(?)", array(array($color->descripcion)));
		}catch(Exception $e){
			throw $e;
		}
		
	}

	public function getColorsGrid($params){
		$query = sprintf("SELECT 
				id,
				descripcion
			FROM colores 
			WHERE
				estatus = 1
				%s", $params);
		Loger::log($query, null);
		return $this->query($query, null);
	}

	public function deleteColor($color){
		try{
			$this->execute("UPDATE colores SET estatus = 0 WHERE id = ?", array(array($color->id)));
		}catch(Exception $e){
			throw $e;
		}
	}

	public function getColorByID($color){
		$result = $this->query("SELECT * FROM colores WHERE id = ?", array($color->id));
		$row = $result->getResultSet()[0];

		return new Color($row['id'], $row['descripcion']);
	}

	public function createOrUpdateColor($color){
		try{
			if($color->id == null){
				$this->saveColor($color);
				return;
			}

			$colorNew = $this->getColorByID($color);
			if($color->descripcion != null && $color->descripcion != '')
				$colorNew->descripcion = $color->descripcion;
			
			$this->execute(
				"UPDATE colores 
				SET 
					descripcion = ?,
				WHERE id = ?", 
				array(array($colorNew->descripcion, $colorNew->id)));
		}catch(Exception $e){
			throw $e;
		}	
	}
}
?>