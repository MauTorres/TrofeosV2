<?php
/**
* 
*/
require_once dirname(__DIR__)."/dao/UsuarioDao.php";

class UsuarioBusiness
{
	private $usuarioDAO;

	function __construct()
	{
		$this->usuarioDAO = new UsuarioDao();
	}

	public function login($user){
		$result = $this->usuarioDAO->getUserByUserName($user->usuario);

		return $result->equals($user);
	}

	public function saveUser($user){
		return $this->usuarioDAO->saveUser($user); 
	}

	public function getUsersGrid($params){
		#return $this->
	}
}
?>