<?php
/**
* 
*/
require_once __DIR__."/Business.php";
require_once dirname(__DIR__)."/dao/UsuarioDao.php";

class UsuarioBusiness extends Business
{
	private $usuarioDAO;
	private $responce;

	function __construct()
	{
		parent::__construct();
		$this->usuarioDAO = new UsuarioDao();
	}

	public function login($user){
		try{
			$this->responce = new Responce();
			$result = $this->usuarioDAO->getUserByUserName($user->usuario);	
			$usersCount = count($result);

			if($usersCount <= 0)
				throw new Exception("Usuario no encontrado");
			if($usersCount > 1)
				throw new Exception("Hay más de un usuario con el mismo nombre");

			$this->responce->success = true;
			session_start();
			$result[0]->passwd = null;
			$_SESSION['user'] = $result[0];

		}catch(Exception $e){
			$this->responce->success = false;
			$this->responce->message = $e->getMessage();
		}

		echo json_encode($this->responce);
	}

	public function saveUser($user){
		$this->responce = new Responce();
		try{
			$this->usuarioDAO->saveUser($user);
			$this->responce->success = true;
			$this->responce->message = "El usuario se insertó correctamente";
		}catch(Exception $e){
			$this->responce->success = false;
			$this->responce->message = "Error al agregar al usuario ".$user->usuario;
		}
		echo json_encode($this->responce);
		
	}

	public function getUsersGrid($params){
		$this->responce = new Responce();
		$result = $this->usuarioDAO->getUsersGrid($params);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce); 
	}

	public function deleteUser($usuario){
		$this->responce = new Responce();
		try{
			$this->usuarioDAO->deleteUser($usuario);
			$this->responce->success = true;
			$this->responce->message = "El usuario se eliminó correctamente";
		}catch(Exception $e){
			$this->responce->success = false;
			$this->responce->message = "Error al eliminar al usuario ".$user->usuario;
		}
		echo json_encode($this->responce);
	}

	public function createOrUpdateUser($usuario){
		$this->responce = new Responce();
		
		try{
			$result = $this->usuarioDAO->getUserByUserName($usuario->usuario);

			$usersCount = count($result);
			
			if($usersCount > 0)
				throw new Exception("Ya hay un usuario con el mismo nombre");

			$this->usuarioDAO->createOrUpdateUser($usuario);
			$this->responce->success = true;
			$this->responce->message = "El usuario se guardó correctamente";
		}catch(Exception $e){
			Loger::log("Error al actualizar al usuario ".$usuario->usuario."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = $e->getMessage();
		}

		echo json_encode($this->responce);
	}
}
?>