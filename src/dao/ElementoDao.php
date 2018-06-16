<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/entities/Elemento.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class ElementoDao extends DAO
{

	function __construct()
	{
		parent::__construct();
	}

	public function getElementoByElementName($ElementName){
		$result = $this->query("SELECT * FROM elementos WHERE nombre = ?", array($ElementName));
		$responceLength = count($result->getResultSet());

		if($responceLength <= 0)
			throw new Exception("Material no encontrado");
		if($responceLength > 1)
			throw new Exception("Hay más de un material con el mismo nombre y descripción");

		$row = $result->getResultSet()[0];
		return new Element($row['id'], $row['nombre'], $row['descripcion'], $row['precio'], $row['idColor'], $row['idDeporte'], $row['idMaterial']);
	}

	public function saveElemento($elemento){
		try{
			$this->execute("INSERT INTO elementos(nombre, descripcion, precio, idColor, idDeporte, idMaterial) VALUES(?, ?, ?, ?, ?, ?)", array(array($elemento->nombre, $elemento->descripcion, $elemento->precio, $elemento->idColor, $elemento->idDeporte, $elemento->idelemento)));
		}catch(Exception $e){
			throw $e;
		}
		
	}

	public function getElementosGrid($params){
		return $this->query(
			"SELECT 
				id,
				nombre,
				descripcion,
				precio,
				idColor,
				idDeporte,
				idMaterial 
			FROM elementos 
			WHERE 
				estatus = 1", 
			null);
	}

	public function deleteElemento($elemento){
		try{
			$this->execute("UPDATE elementos SET estatus = 0 WHERE id = ?", array(array($elemento->id)));
		}catch(Exception $e){
			throw $e;
		}
	}

	public function getElementosByID($elemento){
		$result = $this->query("SELECT * FROM elementos WHERE id = ?", array($elemento->id));
		$row = $result->getResultSet()[0];

		return new Element($row['id'], $row['nombre'], $row['descripcion'], $row['precio']);
	}

	public function updateElementos($elemento){
		try{
			$elementoNew = $this->getelementoByID($elemento);
			if($elemento->nombre != null && $elemento->nombre != '')
				$elementoNew->usuario = $elemento->nombre;
			if($elemento->descripcion != null && $elemento->descripcion != '')
				$elementoNew->descripcion = $elemento->descripcion;

			$this->execute(
				"UPDATE elementos 
				SET 
					nombre = ?,
					descripcion = ?,
					precio = ?
				WHERE id = ?", 
				array(array($elementoNew->nombre, $elementoNew->descripcion, $elementoNew->precio, $elementoNew->id)));
		}catch(Exception $e){
			throw $e;
		}	
	}
}
?>