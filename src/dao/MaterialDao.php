<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/entities/Material.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class MaterialDao extends DAO
{

	function __construct()
	{
		parent::__construct();
	}

	public function getMaterialByElementName($ElementName){
		$result = $this->query("SELECT * FROM elementos WHERE nombre = ?", array($ElementName));
		$responceLength = count($result->getResultSet());

		if($responceLength <= 0)
			throw new Exception("Material no encontrado");
		if($responceLength > 1)
			throw new Exception("Hay más de un material con el mismo nombre y descripción");

		$row = $result->getResultSet()[0];
		return new Element($row['id'], $row['nombre'], $row['descripcion'], $row['precio']);
	}

	public function saveMaterial($material){
		try{
			$this->execute("INSERT INTO elementos(nombre, descripcion, precio) VALUES(?, ?, ?)", array(array($material->nombre, $material->descripcion, $material->precio)));
		}catch(Exception $e){
			throw $e;
		}
		
	}

	public function getMaterialsGrid($params){
		return $this->query(
			"SELECT 
				id,
				nombre,
				descripcion,
				precio  
			FROM elementos 
			WHERE 
				estatus = 1", 
			null);
	}

	public function deleteMaterial($material){
		try{
			$this->execute("UPDATE elementos SET estatus = 0 WHERE id = ?", array(array($material->id)));
		}catch(Exception $e){
			throw $e;
		}
	}

	public function getMaterialByID($material){
		$result = $this->query("SELECT * FROM elementos WHERE id = ?", array($material->id));
		$row = $result->getResultSet()[0];

		return new Element($row['id'], $row['nombre'], $row['descripcion'], $row['precio']);
	}

	public function updateMaterial($material){
		try{
			$materialNew = $this->getMaterialByID($material);
			if($material->nombre != null && $material->nombre != '')
				$materialNew->usuario = $material->nombre;
			if($material->descripcion != null && $material->descripcion != '')
				$materialNew->descripcion = $material->descripcion;

			$this->execute(
				"UPDATE elementos 
				SET 
					nombre = ?,
					descripcion = ?,
					precio = ?
				WHERE id = ?", 
				array(array($materialNew->nombre, $materialNew->descripcion, $materialNew->precio, $materialNew->id)));
		}catch(Exception $e){
			throw $e;
		}	
	}
}
?>