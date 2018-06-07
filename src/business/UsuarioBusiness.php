<?php
/**
* 
*/
require_once dirname(__DIR__)."/utils/Loger.php";
require_once dirname(__DIR__)."/dao/UsuarioDao.php";
require_once dirname(__DIR__)."/utils/Responce.php";

class UsuarioBusiness
{
	private $usuarioDAO;

	function __construct()
	{
		$this->usuarioDAO = new UsuarioDao();
	}

	public function login($user){
		$responce = new Responce();
		$result = $this->usuarioDAO->getUserByUserName($user->usuario);
		$responce->success = $result->equals($user);

		Loger::log("Try login: \n".print_r($responce, true), null);
		if($responce->success)
			session_start();

		$_SESSION['modules'] = array("Usuarios", "Trofeos", "Materiales");

		echo json_encode($responce);
	}

	public function saveUser($user){
		return $this->usuarioDAO->saveUser($user); 
	}

	public function getUsersGrid($params){
		#return $this->
	}
}
?>