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

	public function getElementByElementName($ElementName){
		$elementos = array();
		$result = $this->query("SELECT * FROM elementos WHERE nombre = ?", array($ElementName));
		$result = $result->getResultSet();

		foreach ($result as $elementos) {
			array_push($elementos, new Elemento($elemento['id'], $usuario['usuario'], $usuario['passwd'], $usuario['email']));
		}

		return $usuarios;
	}

	/*public function getElementByElementName($ElementName){
		$result = $this->query("SELECT * FROM elementos WHERE nombre = ?", array($ElementName));
		$responceLength = count($result->getResultSet());
		if($responceLength <= 0)
			throw new Exception("Material no encontrado");
		if($responceLength > 1)
			throw new Exception("Hay más de un material con el mismo nombre y descripción");

		$row = $result->getResultSet()[0];
		return new Element($row['id'], $row['nombre'], $row['descripcion'], $row['precio'], $row['idColor'], $row['idDeporte'], $row['idMaterial']);
	}*/

	public function saveElement($elemento){
		try{
			$this->execute("INSERT INTO elementos(nombre, descripcion, precio, idColor, idDeporte, idMaterial) VALUES(?, ?, ?, ?, ?, ?)", array(array($elemento->nombre, $elemento->descripcion, $elemento->precio, $elemento->idColor, $elemento->idDeporte, $elemento->idMaterial)));
		}catch(Exception $e){
			throw $e;
		}
		
	}

	public function getElementsGrid($params){
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

	public function deleteElement($elemento){
		try{
			$this->execute("UPDATE elementos SET estatus = 0 WHERE id = ?", array(array($elemento->id)));
		}catch(Exception $e){
			throw $e;
		}
	}

	public function getElementByID($elemento){
		$result = $this->query("SELECT * FROM elementos WHERE id = ?", array($elemento->id));
		$row = $result->getResultSet()[0];
		if ($row == null) {
			return null;
		}
		return new Elemento($row['id'], $row['nombre'], $row['descripcion'], $row['precio'], $row['idColor'], $row['idDeporte'], $row['idMaterial']);
	}

	public function createOrUpdateElement($elemento){
		try{
			if($elemento->id == null){
				$this->saveElement($elemento);
				return;
			}

			$elementoNew = $this->getElementByID($elemento);
			if($elemento->nombre != null && $elemento->nombre != '')
				$elementoNew->nombre = $elemento->nombre;
			if($elemento->descripcion != null && $elemento->descripcion != '')
				$elementoNew->descripcion = $elemento->descripcion;
			if($elemento->precio != null && $elemento->precio != '')
				$elementoNew->precio = $elemento->precio;

			$this->execute(
				"UPDATE elementos 
				SET 
					nombre = ?,
					descripcion = ?,
					precio = ?
				WHERE id = ?", 
				array(array($elementoNew->nombre, $elementoNew->descripcion, $elementoNew->precio, $elementoNew->id)));
		}catch(Exception $e){
			Loger::log($e->getMessage(),null);
			throw $e;
		}	
	}
}
?>