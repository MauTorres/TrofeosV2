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
		if (isset($_SESSION['most_recent_activity']) && 
		((time() -   $_SESSION['most_recent_activity']) > 1800)) {
			session_destroy();   
			session_unset();  
		}
		if (session_status() == PHP_SESSION_NONE || !isset($_SESSION['user'])){
			header( "Location: ../../".LOGIN_PAGE);
			return;
		}else{
			$this->responce->success = true;
			$this->responce->data = $_SESSION['user'];
			$_SESSION['most_recent_activity'] = time();
			Loger::log(print_r($_SESSION, 1), null);
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