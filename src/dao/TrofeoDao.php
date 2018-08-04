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
			return new Trofeo($row['id'], $row['nombre'], $row['descripcion'], $row['precio'], $row['fotoPath'], $row['estatus']);
		}catch (Exception $e) {
			Loger::log($e->getMessage(), null);
		}
	}

	public function getTrofeosGrid($params){
		try {
			$query = sprintf(
				"SELECT
					T.id,
					T.nombre as nombre,
					T.descripcion as descripcion,
					T.precio as precio
				FROM trofeos T
				WHERE
					T.estatus = 1
					%s
				", $params);
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

	public function createOrUpdateTrophy($trofeo){
		try {
			if($trofeo->id != null){
				$this->saveTrophy($trofeo);
				return;
			}

			$trofeoNew = $this->getTrophyById($trofeo);
			if($trofeo->nombre != null && $trofeo->nombre != '')
				$trofeoNew->nombre = $trofeo->nombre;
			if($trofeo->descripcion != null && $trofeo->descripcion != '')
				$trofeoNew->descripcion = $trofeo->descripcion;
			if($trofeo->precio != null && $trofeo->precio != '')
				$trofeoNew->precio = $trofeo->precio;
			if($trofeo->fotoPath != null && $trofeo->fotoPath != '')
				$trofeoNew->fotoPath = $trofeo->fotoPath;

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
					$trofeo->fotoPath,
					$trofeo->estatus,
					$trofeo->id)));
		}catch (Exception $e) {
			Loger::log($e->getMessage(), null);
			throw $e;
		}
	}
}
?>