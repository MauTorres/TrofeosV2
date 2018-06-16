<?php
/**
* 
*/
require_once __DIR__."/Business.php";
require_once dirname(__DIR__)."/dao/UsuarioDao.php";

class MaterialBusiness extends Business
{
	private $usuarioDAO;
	private $responce;

	function __construct()
	{
		parent::__construct();
		$this->usuarioDAO = new UsuarioDao();
	}

	public function login($user){
		$this->responce = new Responce();
		$result = $this->usuarioDAO->getUserByUserName($user->usuario);
		$this->responce->success = $result->equals($user);
		if($this->responce->success){
			session_start();
			$result->passwd = null;
			$_SESSION['user'] = $result;
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

	public function updateUser($usuario){
		$this->responce = new Responce();
		try{
			$this->usuarioDAO->updateUser($usuario);
			$this->responce->success = true;
			$this->responce->message = "El usuario se actualizó correctamente";
		}catch(Exception $e){
			$this->responce->success = false;
			$this->responce->message = "Error al actualizar al usuario ".$user->usuario;
		}
		echo json_encode($this->responce);
	}
}
?>