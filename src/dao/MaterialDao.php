<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/entities/Material.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class UsuarioDao extends DAO
{

	function __construct()
	{
		parent::__construct();
	}

	public function getMaterialByMaterialName($materialName){
		$material = array();
		$result = $this->query("SELECT * FROM materiales WHERE descripcion = ?", array($materialName));
		$result = $result->getResultSet();

		foreach ($result as $material) {
			array_push($material, new Material($material['id'], $material['descripcion']));
		}

		return $material;
	}

	public function saveMaterial($material){
		try{
			$this->execute("INSERT INTO materiales(descripcion,) VALUES(?)", array(array($material->descripcion)));
		}catch(Exception $e){
			throw $e;
		}
		
	}

	public function getMaterialsGrid($params){
		$query = sprintf("SELECT 
				id,
				descripcion
			FROM materiales 
			WHERE
				estatus = 1
				%s", $params);
		Loger::log($query, null);
		return $this->query($query, null);
	}

	public function deleteMaterial($material){
		try{
			$this->execute("UPDATE materiales SET estatus = 0 WHERE id = ?", array(array($material->id)));
		}catch(Exception $e){
			throw $e;
		}
	}

	public function getMaterialByID($material){
		$result = $this->query("SELECT * FROM materiales WHERE id = ?", array($material->id));
		$row = $result->getResultSet()[0];

		return new Material($row['id'], $row['descripcion']);
	}

	public function createOrUpdateMaterial($material){
		try{
			if($material->id == null){
				$this->saveMaterial($material);
				return;
			}

			$materialNew = $this->getMaterialByID($material);
			if($material->descripcion != null && $material->descripcion != '')
				$materialNew->descripcion = $material->descripcion;
			
			$this->execute(
				"UPDATE materiales 
				SET 
					descripcion = ?,
				WHERE id = ?", 
				array(array($materialNew->descripcion, $materialNew->id)));
		}catch(Exception $e){
			throw $e;
		}	
	}
}
?>