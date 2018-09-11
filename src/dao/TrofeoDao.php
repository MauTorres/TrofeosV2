<?php
/**
 *
 */
require_once __DIR__."/DAO.php";
require_once __DIR__."/entities/Trofeo.php";
require_once __DIR__."/entities/Elemento.php";

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
			return $this->query($query, null);
		} catch (Exception $e) {
			Loger::log($e->getMessage(), null);
		}
	}

	public function setElement($trofeo, $elemento){
		try {
			$this->execute('INSERT INTO trofeoselementos(idTrofeo, idElemento) VALUES(:idTrofeo, :idElemento)', 
				array(
					":idTrofeo"=>$trofeo->id,
					":idElemento"=>$elemento->id
				)
			);
		} catch (Exception $e) {
			Loger::log($e->getMessage(), null);
			throw $e;
		}
	}

	public function saveTrophy($trofeo){
		try {
			/*foreach ($trofeo as $key => $value) {
				print_r($key);
				echo "<bo"
				print_r($value);
			}*/
			$this->execute('INSERT INTO trofeos(nombre, descripcion, precio, fotoPath) VALUES(:nombre, :descripcion, :precio, :foto)', 
				array(
					":nombre"=>$trofeo->nombre, 
					":descripcion"=>$trofeo->descripcion,
					":precio"=>$trofeo->precio,
					":foto"=>$trofeo->foto
				));
		}catch (Exception $e) {
			Loger::log($e->getMessage(), null);
		}
	}

	public function deleteElementoTrofeo($trofeo, $elemento){
		try {
			$this->execute('DELETE FROM trofeoselementos WHERE idTrofeo = :idTrofeo AND idElemento = :idElemento', 
				array(
					":idTrofeo" => $trofeo->id, 
					":idElemento" => $elemento->id
				));
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
			$trofeoNew = $this->getTrophyById($trofeo);
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
					nombre = :nombre,
					descripcion = :descripcion,
					precio = :precio,
					fotoPath = :fotoPath,
					estatus = :estatus
				WHERE id = :id',
				array(
					":nombre"=>$trofeo->nombre,
					":descripcion"=>$trofeo->descripcion,
					":precio"=>$trofeo->precio,
					":foto"=>$trofeo->foto,
					":estatus"=>$trofeo->estatus,
					":id"=>$trofeo->id
				)
			);
		}catch (Exception $e) {
			Loger::log($e->getMessage(), null);
			throw $e;
		}
	}
}
?>