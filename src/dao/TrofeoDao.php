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
}
?>