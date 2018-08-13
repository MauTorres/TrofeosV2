<?php
/**
 *
 */
require_once __DIR__."/DAO.php";
require_once __DIR__."/entities/Trofeo.php";
require_once __DIR__."/entities/Elemento.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class TrofeoDao extends DAO
{

	function __construct()
	{
		parent::__construct();
	}

	public function getTrophyById($trofeo){
		try {
			$result = $this->query("SELECT * FROM trofeos WHERE id = ?", array($trofeo->id));
			$row = $result->getResultSet()[0];
			return new Trofeo($row);
		}catch (Exception $e) {
			Loger::log($e->getMessage(), null);
		}
	}

	public function getTrophyByName($trofeo){
		try {
			$result = $this->query("SELECT * FROM trofeos WHERE nombre = ? AND estatus = 1", array($trofeo->nombre));
			$rows = $result->getResultSet();
			if(count($rows) <= 0)
				return null;
			return new Trofeo($rows[0]);
		}catch (Exception $e) {
			Loger::log($e->getMessage(), null);
		}
	}

	public function getTrofeosGrid($params){
		try {
			$query = sprintf(
				"SELECT
					id,
					nombre,
					descripcion,
					precio,
					fotoPath
				FROM trofeos
				WHERE
					estatus = 1
					%s
				", $params);
			Loger::log($query, null);
			return $this->query($query, null);
		} catch (Exception $e) {
			Loger::log($e->getMessage(), null);
		}
	}

	public function setElement($trofeo, $elemento){
		try {
			$this->execute('INSERT INTO trofeoselementos(idTrofeo, idElemento) VALUES(?, ?)', array(array($trofeo->id, $elemento->id)));
		} catch (Exception $e) {
			Loger::log($e->getMessage(), null);
			throw $e;
		}
	}

	public function saveTrophy($trofeo){
		try {
			$this->execute('INSERT INTO trofeos(nombre, descripcion, precio, fotoPath) VALUES(?, ?, ?, ?)', array(array($trofeo->nombre, $trofeo->descripcion, $trofeo->precio, $trofeo->foto)));
		}catch (Exception $e) {
			Loger::log($e->getMessage(), null);
		}
	}

	public function deleteElementoTrofeo($trofeo, $elemento){
		try {
			$this->execute('DELETE FROM trofeoselementos WHERE idTrofeo = ? AND idElemento = ?', array(array($trofeo->id, $elemento->id)));
		}catch (Exception $e) {
			Loger::log($e->getMessage(), null);
		}	
	}

	public function createOrUpdateTrophy($trofeo){
		try {
			$trofeoResult = $this->getTrophyByName($trofeo);
			if($trofeo->id == null || $trofeo->id == 0){
				if($trofeoResult != null){
					throw new Exception("Ya existe un trofeo con éste identificador");
				}
				$this->saveTrophy($trofeo);
				return;
			}
			Loger::log("Nuevo: ".print_r($trofeo, 1), null);
			$trofeoNew = $this->getTrophyById($trofeo);
			Loger::log("Anterior: ".print_r($trofeoNew, 1), null);
			if($trofeo->nombre != null && $trofeo->nombre != '')
				$trofeoNew->nombre = $trofeo->nombre;
			if($trofeo->descripcion != null && $trofeo->descripcion != '')
				$trofeoNew->descripcion = $trofeo->descripcion;
			if($trofeo->precio != null && $trofeo->precio != '')
				$trofeoNew->precio = $trofeo->precio;
			if($trofeo->foto != null && $trofeo->foto != '')
				$trofeoNew->foto = $trofeo->foto;
			if($trofeo->estatus != null && $trofeo->estatus != '')
				$trofeoNew->estatus = $trofeo->estatus;

			$this->execute(
				'UPDATE trofeos
				SET
					nombre = ?,
					descripcion = ?,
					precio = ?,
					fotoPath = ?,
					estatus = ?
				WHERE id = ?',
				array(array(
					$trofeo->nombre,
					$trofeo->descripcion,
					$trofeo->precio,
					$trofeo->foto,
					$trofeo->estatus,
					$trofeo->id)));
		}catch (Exception $e) {
			Loger::log($e->getMessage(), null);
			throw $e;
		}
	}
}
?>