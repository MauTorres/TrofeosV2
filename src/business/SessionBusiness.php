<?php

/**
 * 
 */
require_once __DIR__."/Business.php";
require_once __DIR__."/UsuarioBusiness.php";
require_once dirname(__DIR__)."/utils/Constants.php";

class SessionBusiness extends Business
{
	private $usuarioBusiness;
	function __construct()
	{
		parent::__construct();
		$this->usuarioBusiness = new UsuarioBusiness();
	}

	public function login($usuario){
		$this->usuarioBusiness->login($usuario);
	}

	public function getSession(){
		$this->responce = new Responce();

		session_start();
		if (session_status() == PHP_SESSION_NONE || !isset($_SESSION['user'])){
			header( "Location: ../../".LOGIN_PAGE);
			return;
		}else{
			$this->responce->success = true;
			$this->responce->data = $_SESSION['user'];
			echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
		}
	}

	public function endSession(){
		session_start();
		if(session_status() != PHP_SESSION_NONE){
			session_destroy();
		}

		$this->responce = new Responce();
		$this->responce->success = true;
		$this->responce->message = "Se ha cerrado la sesión";
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}
}
?>