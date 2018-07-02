<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/entities/Deporte.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class UsuarioDao extends DAO
{

	function __construct()
	{
		parent::__construct();
	}

	public function getSportBySportName($sportName){
		$sport = array();
		$result = $this->query("SELECT * FROM deportes WHERE descripcion = ?", array($sportName));
		$result = $result->getResultSet();

		foreach ($result as $sport) {
			array_push($sport, new Sport($sport['id'], $sport['descripcion']));
		}

		return $sport;
	}

	public function saveSport($sport){
		try{
			$this->execute("INSERT INTO deportes(descripcion,) VALUES(?)", array(array($sport->descripcion)));
		}catch(Exception $e){
			throw $e;
		}
		
	}

	public function getSportsGrid($params){
		$query = sprintf("SELECT 
				id,
				descripcion
			FROM deportes 
			WHERE
				estatus = 1
				%s", $params);
		Loger::log($query, null);
		return $this->query($query, null);
	}

	public function deleteSport($sport){
		try{
			$this->execute("UPDATE deportes SET estatus = 0 WHERE id = ?", array(array($sport->id)));
		}catch(Exception $e){
			throw $e;
		}
	}

	public function getSportByID($sport){
		$result = $this->query("SELECT * FROM deportes WHERE id = ?", array($sport->id));
		$row = $result->getResultSet()[0];

		return new Sport($row['id'], $row['descripcion']);
	}

	public function createOrUpdateSport($sport){
		try{
			if($sport->id == null){
				$this->saveSport($sport);
				return;
			}

			$sportNew = $this->getSportByID($sport);
			if($sport->descripcion != null && $sport->descripcion != '')
				$sportNew->descripcion = $sport->descripcion;
			
			$this->execute(
				"UPDATE deportes 
				SET 
					descripcion = ?,
				WHERE id = ?", 
				array(array($sportNew->descripcion, $sportNew->id)));
		}catch(Exception $e){
			throw $e;
		}	
	}
}
?>