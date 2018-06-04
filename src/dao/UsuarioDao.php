<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/entities/Usuario.php";

class UsuarioDao extends DAO
{

	function __construct()
	{
		parent::__construct();
	}

	public function getUserByUserName($userName){
		$result = $this->query("SELECT * FROM usuarios WHERE usuario = ?", array($userName));
		if(count($result) <= 0)
			throw new Exception("Usuario no encontrado");
		if(count($result) > 1)
			throw new Exception("Hay más de un usuario con el mismo nombre");
		$row = $result[0];
		return new Usuario($row['id'], $row['usuario'], $row['passwd'], $row['email']);
	}

	public function saveUser($usuario){
		return $this->execute("INSERT INTO usuarios VALUES(null, ?, ?, ?)", array(array($usuario->usuario, $usuario->passwd, $usuario->email)));
	}
}
?>