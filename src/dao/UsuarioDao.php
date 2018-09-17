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
		$usuarios = array();
		$result = $this->query("SELECT * FROM usuarios WHERE usuario = ?", array($userName));
		$result = $result->getResultSet();

		foreach ($result as $usuario) {
			array_push($usuarios, new Usuario($usuario['id'], $usuario['usuario'], $usuario['passwd'], $usuario['email']));
		}

		return $usuarios;
	}

	public function saveUser($usuario){
		try{
			$this->execute(
				"INSERT INTO usuarios(usuario, passwd, email) 
				VALUES(:usuario, :passwd, :email)", 
				array(
					":usuario"=>$usuario->usuario, 
					":passwd"=>$usuario->passwd, 
					":email"=>$usuario->email
				)
			);
		}catch(Exception $e){
			throw $e;
		}
		
	}

	public function getUsersGrid($params){
		$query = sprintf("SELECT 
				id,
				usuario,
				email  
			FROM usuarios 
			WHERE
				estatus = 1
				%s", $params);
		return $this->query($query, null);
	}

	public function deleteUser($usuario){
		try{
			$this->execute("UPDATE usuarios SET estatus = 0 WHERE id = :id", array(":id"=>$usuario->id));
		}catch(Exception $e){
			throw $e;
		}
	}

	public function getUserByID($usuario){
		$result = $this->query("SELECT * FROM usuarios WHERE id = ?", array($usuario->id));
		$row = $result->getResultSet()[0];

		return new Usuario($row['id'], $row['usuario'], $row['passwd'], $row['email']);
	}

	public function createOrUpdateUser($usuario){
		try{
			if($usuario->id == null){
				$this->saveUser($usuario);
				return;
			}

			$usuarioNew = $this->getUserByID($usuario);
			if($usuario->usuario != null && $usuario->usuario != '')
				$usuarioNew->usuario = $usuario->usuario;
			if($usuario->passwd != null && $usuario->passwd != '')
				$usuarioNew->passwd = $usuario->passwd;
			if($usuario->email != null && $usuario->email != '')
				$usuarioNew->email = $usuario->email;

			$this->execute(
				"UPDATE usuarios 
				SET 
					usuario = :usuario,
					passwd = :passwd,
					email = :email
				WHERE id = ?", 
				array(
					":usuario"=>$usuarioNew->usuario, 
					":passwd"=>$usuarioNew->passwd, 
					":email"=>$usuarioNew->email, 
					":id"=>$usuarioNew->id
				)
			);
		}catch(Exception $e){
			throw $e;
		}	
	}
}
?>