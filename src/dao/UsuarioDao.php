<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/entities/Usuario.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class UsuarioDao extends DAO
{

	function __construct()
	{
		parent::__construct();
	}

	public function getUserByUserName($userName){
		$result = $this->query("SELECT * FROM usuarios WHERE usuario = ?", array($userName));
		$responceLength = count($result->getResultSet());

		if($responceLength <= 0)
			throw new Exception("Usuario no encontrado");
		if($responceLength > 1)
			throw new Exception("Hay más de un usuario con el mismo nombre");

		$row = $result->getResultSet()[0];
		return new Usuario($row['id'], $row['usuario'], $row['passwd'], $row['email']);
	}

	public function saveUser($usuario){
		try{
			$this->execute("INSERT INTO usuarios(usuario, passwd, email) VALUES(?, ?, ?)", array(array($usuario->usuario, $usuario->passwd, $usuario->email)));
		}catch(Exception $e){
			throw $e;
		}
		
	}

	public function getUsersGrid($params){
		return $this->query(
			"SELECT 
				id,
				usuario,
				email  
			FROM usuarios 
			WHERE 
				estatus = 1", 
			null);
	}

	public function deleteUser($usuario){
		try{
			$this->execute("UPDATE usuarios SET estatus = 0 WHERE id = ?", array(array($usuario->id)));
		}catch(Exception $e){
			throw $e;
		}
	}
}
?>